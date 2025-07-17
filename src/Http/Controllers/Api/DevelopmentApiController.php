<?php

namespace Moawiaab\LaravelTheme\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Moawiaab\LaravelTheme\Services\DefaultText;
use Moawiaab\LaravelTheme\Services\DevelopmentService;
use Moawiaab\LaravelTheme\Services\FileService;
use Illuminate\Http\Response;
use Moawiaab\LaravelTheme\Services\ControllerService;
use Moawiaab\LaravelTheme\Services\ModelService;
use Moawiaab\LaravelTheme\Services\RequestService;
use Moawiaab\LaravelTheme\Services\ResourcesService;

class DevelopmentApiController extends Controller
{
    public function index()
    {
        $pack = [];
        $ismodel = [];
        $controller_out = app_path('Http/Controllers/Api');
        $resources = app_path('Http/Resources');
        $requests = app_path('Http/Requests');
        $models = app_path('Models');
        $table = 'Tables_in_' . env("DB_DATABASE");

        foreach (DevelopmentService::views() as $i) {
            if ($i['type'] == false) {
                if ($i['name'] == "clients") {
                    $pack[] = "ClientApiController";
                    array_push($ismodel, "Client", "FinancialClient");
                } elseif ($i['name'] == "expanses") {
                    $pack[] = "ExpanseApiController";
                    array_push($ismodel, "Expanse", "ExpanseItem");
                } elseif ($i['name'] == "suppliers") {
                    $pack[] = "SupplierApiController";
                    array_push($ismodel, "Supplier", "FinancialSupplier");
                } elseif ($i['name'] == "ProductManagement") {
                    array_push($pack, "CategoryApiController", "ProductApiController", "StoreApiController", "UnitApiController");
                    array_push($ismodel, "Category", "Product", "Store", "Unit", "User", "ProductStore", "StoreProduct");
                } elseif ($i['name'] == "FinancialManagement") {
                    array_push($pack, "BudgetApiController", "BudgetNameApiController", "CheckApiController", "PrivateLockerApiController", "PublicTreasuryApiController", "StageApiController");
                    array_push($ismodel, "Budget", "BudgetName", "Check", "OpenDay", "PrivateLocker", "PublicTreasury", "Stage", "Bank");
                }
            } else {
                array_push($pack, "AbilitiesController", "PermissionsApiController", "LoginApiController", "DevelopmentApiController");
                array_push($ismodel, "User", "Permission");
            }
        }

        return [
            'controller_out'  => is_dir($controller_out) ? FileService::allFiles($controller_out, ["AbilitiesController", "PermissionsApiController"]) : [],
            'controller_in'  => FileService::allFiles(__DIR__, $pack),
            'models_out'  => is_dir($models) ? FileService::allFiles($models, ["Controller"]) : [],
            'models_in'  => FileService::allFiles(__DIR__ . '/../../../Models', $ismodel),
            'resources'  => is_dir($resources) ? FileService::allFiles($resources, ["Controller"]) : [],
            'requests'  => is_dir($requests) ? FileService::allFiles($requests, ["Controller"]) : [],
            'table'  => $table,
            'tables'    => DB::select('SHOW TABLES  WHERE ' . $table . '  NOT IN
            ("cache_locks", "cache", "failed_jobs", "job_batches", "jobs",
            "migrations", "permission_role", "password_reset_tokens", "permissions",
            "sessions", "accounts", "roles","settings", "personal_access_tokens")')
        ];
    }

    public function create()
    {
        return [
            'views' => DevelopmentService::views(),

        ];
    }

    public function tools()
    {
        return [
            'views' => DevelopmentService::views(),
            'meta' => [
                'products' => "products",
            ]
        ];
    }

    public function remove(Request $request)
    {
        return [
            'views' => DevelopmentService::getPermission($request->name),
        ];
    }

    public function add(Request $request)
    {
        return [
            'views' => DevelopmentService::setPermission($request->name),
        ];
    }

    public function store(Request $request)
    {

        FileService::makeDefaultFolder($request->controller);
        // set model
        ModelService::createIsNotExist($request->items);
        
        $view = resource_path('js/Pages/' . DefaultText::$url_page);
        $store = resource_path('js/stores/' . DefaultText::$url_page);
        // set controller
        ControllerService::createIsNotExist();
        //set Resources
        ResourcesService::createIsNotExist();
        //set Request
        RequestService::createIsNotExist();
        // copy resources files in vue folder
        if (config('theme.stack') === 'quasar') {
            (new Filesystem)->copyDirectory(__DIR__ . '/../../../Resources/Basic/quasar', $view);
            (new Filesystem)->copyDirectory(__DIR__ . '/../../../Resources/Store/quasar', $store);
            // add column to columns.ts
        } elseif (config('theme.stack') === 'vuetify') {
            (new Filesystem)->copyDirectory(__DIR__ . '/../../../Resources/Basic/vuetify', $view);
            (new Filesystem)->copyDirectory(__DIR__ . '/../../../Resources/Store/vuetify', $store);
        }
        // views files index , create, update, show
        FileService::viewResource(DefaultText::$small_name, $view, $store);
        // add route to web page
        DefaultText::setRoute();

        return  response([
            'data' => auth()->user()->role->permissions
                ->pluck('title')->toArray()
        ], Response::HTTP_ACCEPTED);

        // dd(DefaultText::$name);
    }

    public function storeModel(Request $request)
    {
        FileService::makeDefaultFolder($request->controller);
        if ($request->tab == "model") {
            ModelService::createIsNotExist($request->items);
        } else if ($request->tab == "resource") {
            ResourcesService::createIsNotExist();
        } else if ($request->tab == "request") {
            RequestService::createIsNotExist();
        }

        return  response(null, Response::HTTP_ACCEPTED);
    }
}

<?php

namespace Moawiaab\LaravelTheme\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Moawiaab\LaravelTheme\Models\Permission;
use Moawiaab\LaravelTheme\Models\Role;
use Moawiaab\LaravelTheme\Services\DefaultText;
use Moawiaab\LaravelTheme\Services\DevelopmentService;
use Moawiaab\LaravelTheme\Services\FileService;
use Illuminate\Http\Response;


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
        // small name
        FileService::makeDefaultFolder();

        $smallName = str_replace(' ', '', trim(strtolower($request->controller)));
        DefaultText::items($request->items, $smallName);
        $name = ucfirst($smallName);

        $controllerName = $name . 'ApiController';
        $controller = app_path('Http/Controllers/Api/' . $controllerName . '.php');
        $model = app_path('Models/' . $name . '.php');
        $resource = app_path('Http/Resources/' . $name . 'Resource.php');
        $storeR = app_path('Http/Requests/Store' . $name . 'Request.php');
        $updateR = app_path('Http/Requests/Update' . $name . 'Request.php');

        $view = resource_path('js/Pages/' . $name . 's/');
        $store = resource_path('js/stores/' . $smallName . 's/');


        $api = base_path('routes/api.php');

        $colName = $name . 'Column';
        //migrations
        $m_name = date("Y-m-d") . "_" . time() . "_" . "create_" . $smallName . "_table.php";
        $migrate = database_path("migrations/" . $m_name);

        $ar = resource_path('js/i18n/ar/index.ts');

        if (config('theme.stack') === 'quasar') {
            $menu = resource_path('js/Components/menu/ListMenu.vue');
            $col = resource_path('js/types/columns.ts');
            $en = resource_path('js/i18n/en-US/index.ts');
            $router = resource_path('js/router/index.js');
        } elseif (config('theme.stack') === 'vuetify') {
            $menu = resource_path('js/plugins/sidebar_item.js');
            $en = resource_path('js/i18n/en/index.ts');
            $router = resource_path('js/router/index.ts');
            $setingPath = resource_path('js/stores/settings/');
            $text = $smallName .'s' ."\n" . 'tableNames';
            FileService::replaceInFile('tableNames', $smallName .'s', $setingPath. 'SettingHeaderTable.js');

        } else {
            $menu = null;
        }

        copy(__DIR__ . '/../../../Resources/database/basic.php', $migrate);

        $this->setPermission(strtolower($name));
        // dd("done");

        // copy files from basic to new directory
        copy(__DIR__ . '/../BasicController.php', $controller);
        copy(__DIR__ . '/../../../Models/Basic.php', $model);
        copy(__DIR__ . '/../../Resources/BasicResource.php', $resource);
        copy(__DIR__ . '/../../Requests/StoreBasicRequest.php', $storeR);
        copy(__DIR__ . '/../../Requests/UpdateBasicRequest.php', $updateR);

        if (file_exists($controller)) {
            //replace model name
            FileService::replaceInFile('Basic', $name, $model);
            FileService::replaceInFile('tablesName', $smallName . "s", $model);
            FileService::replaceInFile("'name',", DefaultText::$filedModel, $model);
            FileService::replaceInFile("//function", DefaultText::$appModel, $model);

            //replace resource name
            FileService::replaceInFile('BasicResource', $name . "Resource", $resource);
            //replace request name
            FileService::replaceInFile('StoreBasicRequest', 'Store' . $name . "Request", $storeR);
            FileService::replaceInFile("'name' => [],", DefaultText::$filedRequire, $storeR);
            FileService::replaceInFile('UpdateBasicRequest', 'Update' . $name . "Request", $updateR);
            FileService::replaceInFile("'name' => [],", DefaultText::$filedRequire, $updateR);

            //replace controller name and method names
            FileService::replaceInFile('BasicController', $controllerName, $controller);
            FileService::replaceInFile('$basic', '$' . $smallName, $controller);
            // FileService::replaceInFile('Basics/', $name . 's/', $controller);
            // FileService::replaceInFile('basics', $smallName . 's', $controller);
            FileService::replaceInFile('basic_', $smallName . '_', $controller);
            FileService::replaceInFile('Basic', $name, $controller);
            FileService::replaceInFile('//set resource', DefaultText::$appModelList, $controller);
            // copy resources files in vue folder
            if (config('theme.stack') === 'quasar') {
                (new Filesystem)->copyDirectory(__DIR__ . '/../../../Resources/Basic/quasar', $view);
                (new Filesystem)->copyDirectory(__DIR__ . '/../../../Resources/Store/quasar', $store);
                // add column to columns.ts
                FileService::editFile($col, DefaultText::column($colName));
            } elseif (config('theme.stack') === 'vuetify') {
                (new Filesystem)->copyDirectory(__DIR__ . '/../../../Resources/Basic/vuetify', $view);
                (new Filesystem)->copyDirectory(__DIR__ . '/../../../Resources/Store/vuetify', $store);
            }
            // views files index , create, update, show
            FileService::viewResource($smallName, $view, $store);

            // add route to web page
            FileService::replaceInFile('//don`t remove this lint', DefaultText::route($smallName), $router);
            FileService::replaceInFile('//don`t remove this lint', DefaultText::routeApi($smallName, $controllerName), $api);

            //add item to menu items
            FileService::replaceInFile('//don`t remove this lint', DefaultText::menu($smallName), $menu);

            // add lang to ar and en

            FileService::replaceInFile('//don`t remove this item', DefaultText::langItem($name), $ar);
            FileService::replaceInFile('//don`t remove this lint', DefaultText::lang($name), $ar);
            FileService::replaceInFile('//don`t remove this item', DefaultText::langItem($name), $en);
            FileService::replaceInFile('//don`t remove this lint', DefaultText::lang($name), $en);

            // replace table name
            FileService::replaceInFile('basics', $smallName . "s", $migrate);
            // set filed items
            FileService::replaceInFile('$table->string("name");', DefaultText::$filedTable, $migrate);

            Artisan::call('migrate');
        }

        return  response([
            'data' => auth()->user()->role->permissions
                ->pluck('title')->toArray()
        ], Response::HTTP_ACCEPTED);

        // dd($name);
    }


    private function setPermission($name)
    {
        $data = [
            ['details' => " access " .   $name, 'title' => $name . "_access"],
            ['details' => " create " .  $name, 'title' => $name . "_create"],
            ['details' => " edit " .  $name, 'title' => $name . "_edit"],
            ['details' => " delete " .    $name, 'title' => $name . "_delete"]
        ];
        $role = Role::find(1);
        $permission = Permission::insert($data);
        if ($permission) {
            $permissions = Permission::orderBy('id', 'desc')->take(4)->get(['id', 'title']);
            foreach ($permissions as $key) {
                $role->permissions()->syncWithoutDetaching($key->id);
            }
        }
    }

    public function storeModel(Request $request)
    {
        // small name

        $smallName = str_replace(' ', '', trim(strtolower($request->controller)));
        DefaultText::items($request->items, $smallName);
        $name = ucfirst($smallName);

        $model = app_path('Models/' . $name . '.php');
        $resource = app_path('Http/Resources/' . $name . 'Resource.php');
        $storeR = app_path('Http/Requests/Store' . $name . 'Request.php');
        $updateR = app_path('Http/Requests/Update' . $name . 'Request.php');

        //migrations
        $m_name = date("Y-m-d") . "_" . time() . "_" . "create_" . $smallName . "_table.php";
        $migrate = database_path("migrations/" . $m_name);

        if ($request->tab == "model") {
            copy(__DIR__ . '/../../../Resources/database/basic.php', $migrate);
            copy(__DIR__ . '/../../../Models/Basic.php', $model);

            //replace model name
            FileService::replaceInFile('Basic', $name, $model);
            FileService::replaceInFile('tablesName', $smallName . "s", $model);
            FileService::replaceInFile("'name',", DefaultText::$filedModel, $model);
            FileService::replaceInFile("//function", DefaultText::$appModel, $model);


            // replace table name
            FileService::replaceInFile('basics', $smallName . "s", $migrate);
            // set filed items
            FileService::replaceInFile('$table->string("name");', DefaultText::$filedTable, $migrate);
            Artisan::call('migrate');
        } else if ($request->tab == "resource") {
            copy(__DIR__ . '/../../Resources/BasicResource.php', $resource);
            //replace resource name
            FileService::replaceInFile('BasicResource', $name . "Resource", $resource);
        } else if ($request->tab == "request") {
            copy(__DIR__ . '/../../Requests/StoreBasicRequest.php', $storeR);
            copy(__DIR__ . '/../../Requests/UpdateBasicRequest.php', $updateR);
            //replace request name
            FileService::replaceInFile('StoreBasicRequest', 'Store' . $name . "Request", $storeR);
            FileService::replaceInFile("'name' => [],", DefaultText::$filedRequire, $storeR);
            FileService::replaceInFile('UpdateBasicRequest', 'Update' . $name . "Request", $updateR);
            FileService::replaceInFile("'name' => [],", DefaultText::$filedRequire, $updateR);
        }

        return  response(null, Response::HTTP_ACCEPTED);
    }
}

<?php

namespace Moawiaab\LaravelTheme\Services;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DevelopmentService
{

    public static $error = "";
    private static $pram = [];
    public static $string = array("clients", "expanses", "suppliers", "ProductManagement", "FinancialManagement");
    public static $keys = array("created_at", "deleted_at", "id", "user_id", "account_id", "updated_at", "deletable", "editable");

    public static function views()
    {
        $files = [];
        foreach (self::$string as $v) {
            $files[] = [
                'name' => $v,
                'type' => is_dir(resource_path('js/Pages/' . $v)),
            ];
        }
        return $files;
    }

    public static function check($request, $defaultValue, $fillable = [])
    {
        $items = [];
        $newKey = array_merge(self::$keys, $fillable);
        foreach ($request as $req) {
            $keys = [];
            foreach ($req as $k => $v) {
                if (in_array($k, $newKey)) continue;
                $keys[$k] = $v;
            }

            array_push($items, array_merge($keys, $defaultValue));
        }
        return $items;
    }


    public static function setPermission($name)
    {
        self::setRole($name, true);
        foreach (self::$pram as $v) {
            Permission::where('title', 'like', "%$v%")->onlyTrashed()->restore();
            $permission = Permission::where('title', 'like', "%$v%")->get();
            if ($permission->count() == 0) {
                $data = [
                    ['description' => " access " .   $v, 'name' => $v . "_access", "guard_name" => "web"],
                    ['description' => " create " .  $v, 'name' => $v . "_create", "guard_name" => "web"],
                    ['description' => " edit " .  $v, 'name' => $v . "_edit", "guard_name" => "web"],
                    ['description' => " delete " .    $v, 'name' => $v . "_delete", "guard_name" => "web"]
                ];
                $role = Role::find(1);
                $permission = Permission::insert($data)->only('id');

                if ($permission) {
                    $permissions = Permission::orderBy('id', 'desc')->take(4)->get(['id', 'title']);
                    foreach ($permissions as $key) {
                        $role->permissions()->syncWithoutDetaching($key->id);
                    }
                }
            }
        }
    }

    public static function getPermission($name)
    {
        self::setRole($name);
        foreach (self::$pram as $v) {
            Permission::where('name', 'like', "%$v%")->delete();
        }
    }

    private static function setRole($name, $type = false)
    {
        $route = resource_path('js/router/index.js');
        $view = resource_path('js/Pages/' . $name);
        // Artisan::call('migrate');

        if ($name == 'clients') {
            self::$pram[] = 'client';
            if ($type) {
                self::setRoute(['//client'], $name);
                FileService::replaceInFile('//component ' . $name, trim(DefaultText::removeRoute($name . '/index')),  $route);
                FileService::replaceInFile('//component ' . $name . 'AmountList', trim(DefaultText::removeRoute($name . "amountList")), $route);
                Artisan::call('vendor:publish --tag theme-client');
            } else {
                if (is_dir($view)) {
                    FileService::deleteAllFiles($view);
                    rmdir($view);
                }
                FileService::replaceInFile(trim(DefaultText::removeRoute($name . "/index")), '//component ' . $name, $route);
                FileService::replaceInFile(trim(DefaultText::removeRoute($name . "amountList")), '//component ' . $name . 'AmountList', $route);
            }
        } else if ($name == 'expanses') {
            self::$pram[] = 'expanse';
            if ($type) {
                FileService::replaceInFile('//component ' . $name, trim(DefaultText::removeRoute($name . '/index')),  $route);
                self::setRoute(['//expanse'], $name);
                Artisan::call('vendor:publish --tag theme-expanse');
            } else {
                if (is_dir($view)) {
                    FileService::deleteAllFiles($view);
                    rmdir($view);
                }
                FileService::replaceInFile(trim(DefaultText::removeRoute($name . "/index")), '//component ' . $name, $route);
            }
        } else if ($name == 'suppliers') {
            self::$pram[] = 'supplier';
            if ($type) {
                FileService::replaceInFile('//component ' . $name, trim(DefaultText::removeRoute($name . '/index')),  $route);
                self::setRoute(['//supplier'], $name);
                FileService::replaceInFile('//component ' . $name . 'AmountList', trim(DefaultText::removeRoute($name . "/amountList")), $route);
                Artisan::call('vendor:publish --tag theme-supplier');
            } else {
                if (is_dir($view)) {
                    FileService::deleteAllFiles($view);
                    rmdir($view);
                }
                FileService::replaceInFile(trim(DefaultText::removeRoute($name . "/index")), '//component ' . $name, $route);
                FileService::replaceInFile(trim(DefaultText::removeRoute($name . "/amountList")), '//component ' . $name . 'AmountList', $route);
            }
        } else if ($name == 'ProductManagement') {
            self::$pram[] = 'product';
            self::$pram[] = 'unit';
            self::$pram[] = 'category';
            self::$pram[] = 'product_management';
            if ($type) {
                self::setRoute(['//product'], $name);
                FileService::replaceInFile('//component' . $name . 'ProductsIndex', DefaultText::removeRoute($name . "/products/index"), $route);
                FileService::replaceInFile('//component' . $name . 'UnitsIndex', DefaultText::removeRoute($name . "/units/index"), $route);
                FileService::replaceInFile('//component' . $name . 'StoresIndex', DefaultText::removeRoute($name . "/stores/index"), $route);
                FileService::replaceInFile('//component' . $name . 'CategoriesIndex', DefaultText::removeRoute($name . "/categories/index"), $route);
                Artisan::call('vendor:publish --tag theme-product');
            } else {
                if (is_dir($view)) {
                    FileService::deleteAllFiles($view);
                    rmdir($view);
                }
                FileService::replaceInFile(DefaultText::removeRoute($name . "/products/index"), '//component' . $name . 'ProductsIndex', $route);
                FileService::replaceInFile(DefaultText::removeRoute($name . "/units/index"), '//component' . $name . 'UnitsIndex', $route);
                FileService::replaceInFile(DefaultText::removeRoute($name . "/stores/index"), '//component' . $name . 'StoresIndex',  $route);
                FileService::replaceInFile(DefaultText::removeRoute($name . "/categories/index"), '//component' . $name . 'CategoriesIndex', $route);
            }
        } else if ($name == 'FinancialManagement') {
            self::$pram[] = 'public_treasury';
            self::$pram[] = 'financial_management';
            self::$pram[] = 'private_locker';
            self::$pram[] = 'budget_name';
            self::$pram[] = 'budget';
            if ($type) {
                self::setRoute(['//locker'], $name);
                FileService::replaceInFile('//component_' . $name . 'budgetNames', DefaultText::removeRoute($name . "/budget-names/index"), $route);
                FileService::replaceInFile('//component_' . $name . 'budgetsIndex', DefaultText::removeRoute($name . "/budgets/index"), $route);
                FileService::replaceInFile('//component_' . $name . 'publicTreasuriesIndex', DefaultText::removeRoute($name . "/public-treasuries/index"), $route);
                FileService::replaceInFile('//component_' . $name . 'privateLockersIndex', DefaultText::removeRoute($name . "/private-lockers/index"), $route);
                FileService::replaceInFile('//component_' . $name . 'StagesIndex', DefaultText::removeRoute($name . "/stages/index"), $route);
                FileService::replaceInFile('//component_' . $name . 'CheckIndex', DefaultText::removeRoute($name . "/check/index"), $route);
                Artisan::call('vendor:publish --tag theme-locker');
            } else {
                if (is_dir($view)) {
                    FileService::deleteAllFiles($view);
                    rmdir($view);
                }
                FileService::replaceInFile(DefaultText::removeRoute($name . "/budget-names/index"), '//component_' . $name . 'budgetNames', $route);
                FileService::replaceInFile(DefaultText::removeRoute($name . "/budgets/index"), '//component_' . $name . 'budgetsIndex', $route);
                FileService::replaceInFile(DefaultText::removeRoute($name . "/public-treasuries/index"), '//component_' . $name . 'publicTreasuriesIndex',  $route);
                FileService::replaceInFile(DefaultText::removeRoute($name . "/private-lockers/index"), '//component_' . $name . 'privateLockersIndex', $route);
                FileService::replaceInFile(DefaultText::removeRoute($name . "/stages/index"), '//component_' . $name . 'StagesIndex', $route);
                FileService::replaceInFile(DefaultText::removeRoute($name . "/check/index"), '//component_' . $name . 'CheckIndex', $route);
            }
        }
    }

    private static function setRoute($name, $p)
    {
        $view = resource_path('js/Pages/' . $p);
        if (!is_dir($view)) {
            // mkdir($view);
            (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/quasar/resources/Pages/' . $p, $view);
        }
        $path = database_path('seeders/PermissionSeeder.php');
        $router = base_path('routes/api.php');
        $menu = resource_path('js/Components/menu/ListMenu.vue');
        $route = resource_path('js/router/index.js');
        foreach ($name as $v) {
            FileService::replaceInFile($v, '', $router);
            FileService::replaceInFile($v, '', $path);
            FileService::replaceInFile($v, '', $menu);
            FileService::replaceInFile($v, '', $route);
        }
    }
}

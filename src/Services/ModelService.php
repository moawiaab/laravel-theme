<?php

namespace Moawiaab\LaravelTheme\Services;

use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ModelService
{

    public static function createIsNotExist($items)
    {
        DefaultText::items($items);
        $model = app_path('Models/' . DefaultText::$name . '.php');

        $table = "";
        if (file_exists($model)) {
            $tb = "App\Models\\" . DefaultText::$name;
            $t = new $tb();
            $table = $t->getTable() ?? DefaultText::$small_name . "s";
            foreach (FileService::allFiles(database_path('migrations')) as $v) {
                if (stristr($v, $table) || stristr($v, DefaultText::$small_name)) {
                    unlink(database_path('migrations') . '/' . $v . '.php');
                }
            }
            unlink($model);
        } else {
            self::setPermission(strtolower(DefaultText::$small_name));
        }

        copy(__DIR__ . '/../Models/Basic.php', $model);

        FileService::replaceInFile('Basic', DefaultText::$name, $model);
        $tb = "App\Models\\" . DefaultText::$name;
        $t = new $tb();
        DefaultText::$tableName = $t->getTable() ?? DefaultText::$small_name . "s";
        DefaultText::$url_page = str_replace('_', '-', DefaultText::$tableName);

        FileService::replaceInFile("'name',", DefaultText::$filedModel, $model);
        FileService::replaceInFile("//function", DefaultText::$appModel, $model);

        $m_name = date("Y-m-d") . "_" . time() . "_" . "create_" . DefaultText::$small_name . "_table.php";
        $migrate = database_path("migrations/" . $m_name);
        copy(__DIR__ . '/../Resources/database/basic.php', $migrate);
        // replace table name
        FileService::replaceInFile('basics', DefaultText::$tableName, $migrate);
        // set filed items
        FileService::replaceInFile('$table->string("name");', DefaultText::$filedTable, $migrate);

        Artisan::call('migrate');
    }

    private static function setPermission($name)
    {

        $data = [
            ['description' => " access " .   $name, 'name' => $name . "_access", "guard_name" => "web"],
            ['description' => " create " .  $name, 'name' => $name . "_create", "guard_name" => "web"],
            ['description' => " edit " .  $name, 'name' => $name . "_edit", "guard_name" => "web"],
            ['description' => " delete " .    $name, 'name' => $name . "_delete", "guard_name" => "web"]
        ];
        $role = Role::find(1);
        $permission = Permission::insert($data);
        if ($permission) {
            $permissions = Permission::orderBy('id', 'desc')->take(4)->get(['id', 'name']);
            foreach ($permissions as $key) {
                $role->permissions()->syncWithoutDetaching($key->id);
            }
        }
    }
}

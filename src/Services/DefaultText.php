<?php

namespace Moawiaab\LaravelTheme\Services;

use Illuminate\Support\Str;

class DefaultText
{

    public static $small_name = "";
    public static $controllerName = "";
    public static $name = "";
    public static $colName = "";
    public static $tableName = "";
    public static $url_page = "";
    public static $filedTable = "";
    public static $filedModel = "";
    public static $filedRequire = "";
    public static $langText = "";
    public static $inputItems = "";
    public static $formInput = "";
    public static $columnNames = "";
    public static $columnNamesVuetify = "";
    public static $appModelList = "";
    public static $appModel = "";
    public static $validation = "true &&";

    protected static $string = array("string", "text", "tinyText", "longText", "phone");
    public static function column($column)
    {
        if (config('theme.stack') === 'quasar') {
            return "\n" . 'export const ' . $column . ' = [
            ' . self::$columnNames . '
            { name: "created_at", label: "g.created_at", field: "created_at", align: "left", sortable: true },
            { name: "options", label: "g.options", field: "options" }
            ]';
        }
    }

    public static function menu($text, $url)
    {
        if (config('theme.stack') === 'quasar') {
            return "\n" . '{
            text: "item.' . $text . '",
            icon: "mdi-format-list-bulleted",
            to: "/' . $url . '",
            access: "' . $text . '",
        },' . "\n" . ' //don`t remove this lint';
        } elseif (config('theme.stack') === 'vuetify') {
            return "\n" . '{
            text: "item.' . $text . '",
            icon: "mdi-format-list-bulleted",
            url: "/' . $url . '",
            access: "' . $text . '",
        },' . "\n" . ' //don`t remove this lint';
        }
    }

    public static function route()
    {
        return '{
            path: "' . DefaultText::$url_page . '",
            name: "List ' . DefaultText::$url_page . '",
            component: () => import("@/Pages/' . DefaultText::$url_page . '/Index.vue"),
        },' . "\n" . ' //don`t remove this lint';
    }

    public static function routeApi()
    {
        return "Route::resource('" . DefaultText::$url_page . "', '" . DefaultText::$controllerName . "');
        Route::post('/" . DefaultText::$url_page . "/delete-all', '" . DefaultText::$controllerName . "@destroyAll');
        Route::post('/" . DefaultText::$url_page . "/add-all', '" . DefaultText::$controllerName . "@addAll');
        Route::put('/" . DefaultText::$url_page . "/{item}/restore', '" . DefaultText::$controllerName . "@restore');"
            . "\n" . ' //don`t remove this lint';
    }

    public static function setRoute()
    {
        $api = base_path('routes/api.php');
        $ar = resource_path('js/i18n/ar/index.ts');
        $file = file_get_contents($api);

        if (config('theme.stack') === 'quasar') {
            $menu = resource_path('js/Components/menu/ListMenu.vue');
            $menuFile = file_get_contents($menu);
            $col = resource_path('js/types/columns.ts');
            $en = resource_path('js/i18n/en-US/index.ts');
            $router = resource_path('js/router/index.js');
            $routerFile = file_get_contents($router);
            $colName = DefaultText::$name . 'Column';
            FileService::editFile($col, DefaultText::column($colName));
        } elseif (config('theme.stack') === 'vuetify') {
            $menu = resource_path('js/plugins/sidebar_item.js');
            $menuFile = file_get_contents($menu);
            $en = resource_path('js/i18n/en/index.ts');
            $router = resource_path('js/router/index.ts');
            $routerFile = file_get_contents($router);
            $setingPath = resource_path('js/stores/settings/');
            $settingFile = file_get_contents($api);
            $text = '"' . DefaultText::$url_page . '": [],' . "\n" . '//tableNames';
            if (!strpos($settingFile, DefaultText::$url_page)) {
                FileService::replaceInFile('//tableNames', $text, $setingPath . 'SettingHeaderTable.js');
            }
        }

        if (!strpos($file, DefaultText::$controllerName)) {
            self::routeApi();
            FileService::replaceInFile('//don`t remove this lint', DefaultText::routeApi(DefaultText::$url_page), $api);
        }
        if (!strpos($routerFile, DefaultText::$url_page)) {
            self::route();
            FileService::replaceInFile('//don`t remove this lint', DefaultText::route(DefaultText::$url_page), $router);
        }

        if (!strpos($menuFile, DefaultText::$small_name)) {

            FileService::replaceInFile('//don`t remove this lint', DefaultText::menu(DefaultText::$small_name, DefaultText::$url_page), $menu);
            // add lang to ar and en
            FileService::replaceInFile('//don`t remove this item', DefaultText::langItem(DefaultText::$small_name, DefaultText::$name), $ar);
            FileService::replaceInFile('//don`t remove this lint', DefaultText::lang(DefaultText::$small_name), $ar);
            FileService::replaceInFile('//don`t remove this item', DefaultText::langItem(DefaultText::$small_name, DefaultText::$name), $en);
            FileService::replaceInFile('//don`t remove this lint', DefaultText::lang(DefaultText::$small_name), $en);
        }
    }

    public static function removeRoute($name)
    {
        return 'component: () => import("@/Pages/' . $name . '.vue"),';
    }

    public static function lang($text)
    {
        $name = strtolower($text);
        return "\n" . '  ' . $name . ': {
        title: "' . $text . 's List",
        title_new: "Create New ' . $text . '",
        title_edit: "Edit This ' . $text . '",
        view: "View this ' . $text . '",
        ' . self::$langText . '
    },' . "\n" . ' //don`t remove this lint';
    }

    public static function langItem($item, $text)
    {
        return $item . ': "List ' . $text . '",' . "\n" . ' //don`t remove this item';
    }

    public static function items($items)
    {
        foreach ($items as $item) {
            $v = 'null';
            $filed = str_replace(' ', '', trim(strtolower($item['filed'])));

            $type = "string";
            $inputType = "text";
            if (in_array($item['type'], self::$string)) {
                $type = "string";
                $inputType = $item['type'] == "phone" ? "phone" : "text";
                $v = "'" . $item['value'] . "'" ?? 'null';
            } elseif ($item['type'] == 'boolean') {
                $type = "boolean";
                $inputType = "";
            } elseif ($item['type'] == 'decimal') {
                $type = "numeric";
                $inputType = "number";
                $v = $item['value'] ?? 'null';
                self::$columnNames .= 'format: (val: number) => formatNumber(val),';
            } elseif ($item['type'] == 'date') {
                $type = "date";
                $inputType = "date";
                $v = "'" . $item['value'] . "'" ?? 'null';
            } else {
                $type = "integer";
                $inputType = "number";
                $v = $item['value'] ?? 'null';
                self::$columnNames .= 'format: (val: number) => formatNumber(val),';
            }

            self::$columnNames .= '{ name: "' . $filed . '", label: "input.' . DefaultText::$small_name . "." . $filed . '", align: "left", field: "' . $filed . '",';
            self::$columnNamesVuetify .= '{ text: "input.' . DefaultText::$small_name . "." . $filed . '", value: "' . $filed . '"';
            if ($item['type'] == 'longText') {
                self::$inputItems .= self::editor($filed, DefaultText::$small_name, $item['require']);
                self::$columnNames .= 'format: (val: any) => detailsText(val),';
            } elseif ($item['type'] == 'belongsTo') {
                $lists = trim($item['belongsTo']);
                $model = Str::studly(Str::singular($lists));

                self::$appModelList .= "'" . $lists . "'    => \App\Models\\" . ucfirst($model) . "::get(['id', 'name'])," . "\n";
                self::$appModel .= 'public function ' . $filed . '() : BelongsTo
                {
                    return $this->belongsTo(' . ucfirst($model) . '::class);
                }' . "\n";
                $filed = $filed . "_id";
                self::$inputItems .= self::select(DefaultText::$small_name, $filed, $item['require'], $lists);
            } else {
                self::$inputItems .= self::input(DefaultText::$small_name, $filed, $item['require'], $inputType);
            }

            $filedType = $item['type'] == "phone" ? "string" : $item['type'];
            $nullable = $item['require'] == false ? "->nullable();" : ";";
            $nullableReq = $item['require'] == false ? "nullable" : "required";

            if ($item['type'] == 'belongsTo') {
                self::$filedTable .= '$table->bigInteger("' . $filed . '")->references("id")->on("' . trim($item['belongsTo']) . '")' . $nullable . "\n";
            } else {
                self::$filedTable .= '$table->' . $filedType . '("' . $filed . '")' . $nullable . "\n";
            }
            self::$filedModel .= "'" . $filed . "'," . "\n";
            self::$filedRequire .= "'" . $filed . "' => ['" . $type . "', '" . $nullableReq . "']," . "\n";
            self::$langText .= $filed . ': "' . ucfirst($item['name']) . '",' . "\n";

            self::$columnNames .= '},' . "\n";
            self::$columnNamesVuetify .= '},' . "\n";
            self::$formInput .= $filed . ": " . $v . "," . "\n";
        }
    }


    public static function input($name, $filed, $bool, $type)
    {

        if (config('theme.stack') === 'quasar') {
            if ($bool == true) {
                $role = ':rules="[(val) => !!val || $t(' . "'v.required'" . ')]"';
            } else {
                $role = '';
            }
            return '<m-input
                        type="' . $type . '"
                        v-model="single.entry.' . $filed . '"
                        :label="$t(' . "'input." . $name . "." . $filed . "'" . ')"
                        :error="single.errors.' . $filed . '"
                        ' . $role . '
                        />' . "\n";
        } elseif (config('theme.stack') === 'vuetify') {
            if ($bool == true) {
                self::$validation .= " single.entry." . $filed . " && ";
                $role = ':rules="rules.required"
                :error-messages="single.errors.name"
                required';
            } else {
                $role = '';
            }
            return ' <v-text-field
            clearable
            type="' . $type . '"
            v-model="single.entry.' . $filed . '"
            :label="$t(' . "'input." . $name . "." . $filed . "'" . ')"
            :hint="$t(' . "'input." . $name . "." . $filed . "'" . ')"
            variant="solo"
            color="primary"
            ' . $role . '
            />' . "\n";
        }
    }

    public static function editor($filed, $name, $bool)
    {
        if (config('theme.stack') === 'quasar') {
            return '<q-editor v-model="single.entry.' . $filed . '" min-height="5rem"
        :placeholder="$t(' . "'input." . $name . "." . $filed . "'" . ')"/>' . "\n";
        } elseif (config('theme.stack') === 'vuetify') {
            if ($bool == true) {
                self::$validation .= " single.entry." . $filed . " && ";
                $role = ':rules="rules.required"
            :error-messages="single.errors.name"
            required';
            } else {
                $role = '';
            }
            return ' <v-textarea
        clearable
        v-model="single.entry.' . $filed . '"
        :label="$t(' . "'input." . $name . "." . $filed . "'" . ')"
        :hint="$t(' . "'input." . $name . "." . $filed . "'" . ')"
        variant="solo"
        color="primary"
        ' . $role . '
        />' . "\n";
        }
    }

    public static function select($name, $filed, $bool, $lists)
    {
        if (config('theme.stack') === 'quasar') {
            if ($bool == true) {
                $role = ':rules="[(val) => !!val || $t(' . "'v.required'" . ')]"';
            } else {
                $role = '';
            }
            return '<m-select
                        :options="single.lists.' . $lists . '"
                        v-model="single.entry.' . $filed . '"
                        :label="$t(' . "'input." . $name . "." . $filed . "'" . ')"
                        :error="single.errors.' . $filed . '"
                        ' . $role . ' />' . "\n";
        } elseif (config('theme.stack') === 'vuetify') {
            if ($bool == true) {
                self::$validation .= " single.entry." . $filed . " && ";
            }
            return '    <v-select
            v-model="single.entry.' . $filed . '"
        :label="$t(' . "'input." . $name . "." . $filed . "'" . ')"
            clearable
            :items="single.lists.' . $lists . '"
            variant="solo"
            item-title="name"
            item-value="id"
        />' . "\n";
        }
    }
}

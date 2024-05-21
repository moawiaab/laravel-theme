<?php

namespace Moawiaab\LaravelTheme\Services;

class DefaultText
{

    public static $filedTable = "";
    public static $filedModel = "";
    public static $filedRequire = "";
    public static $langText = "";
    public static $inputItems = "";
    public static $formInput = "";
    public static $columnNames = "";
    public static $appModelList = "";
    public static $appModel = "";
    public static $props = "";
    public static $propsEdit = "";

    protected static $string = array("string", "text", "tinyText", "longText", "phone");
    public static function column($column)
    {
        return "\n" . 'export const ' . $column . ' = [
            ' . self::$columnNames . '
            { name: "created_at", label: "g.created_at", field: "created_at", align: "left", sortable: true },
            { name: "options", label: "g.options", field: "options" }
            ]';
    }

    public static function menu($text)
    {
        return "\n" . '{
            text: "item.' . $text . '",
            icon: "list",
            to: "/' . $text . 's",
            access: "' . $text . '",
        },' . "\n" . ' //don`t remove this lint';
    }

    public static function route($name)
    {
        return '{
            path: "' . $name . '",
            name: "الفروع",
            component: () => import("@/Pages/' . $name . '/index.vue"),
        },' . "\n" . ' //don`t remove this lint';
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

    public static function langItem($text)
    {
        $name = strtolower($text);
        return $name . ': "List ' . $text . 's",' . "\n" . ' //don`t remove this item';
    }

    public static function items($items, $name)
    {
        self::$propsEdit .= "'" . $name . "' : Object, " . "\n";
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
            } elseif ($item['type'] == 'date') {
                $type = "date";
                $inputType = "date";
                $v = "'" . $item['value'] . "'" ?? 'null';
            } else {
                $type = "integer";
                $inputType = "number";
                $v = $item['value'] ?? 'null';
            }

            self::$columnNames .= '{ name: "' . $filed . '", label: "input.' . $name . "." . $filed . '", align: "left", field: "' . $filed . '",';

            if ($item['type'] == 'longText') {
                self::$inputItems .= self::editor($filed, $name);
                self::$columnNames .= 'format: (val: any) =>
                `${
                    val.replace(/(<([^>]+)>)/gi, "").length > 30
                        ? val
                              .replace(/(<([^>]+)>)/gi, "")
                              .split("", 30)
                              .join("") + "..."
                        : val.replace(/(<([^>]+)>)/gi, "")
                }`,';
            } elseif ($item['type'] == 'belongsTo') {
                $lists = trim($item['belongsTo']);
                $model = substr_replace($lists, '', -1);

                self::$props .= "'" . $lists . "' : Object, " . "\n";
                self::$appModelList .= "'" . $lists . "'    => \App\Models\\" . ucfirst($model) . "::get(['id', 'name'])," . "\n";
                self::$appModel .= 'public function ' . $filed . '() : BelongsTo
                {
                    return $this->belongsTo(' . ucfirst($model) . '::class);
                }' . "\n";
                $filed = $filed . "_id";
                self::$inputItems .= self::select($name, $filed, $item['require'], $lists);
            } else {
                self::$inputItems .= self::input($name, $filed, $item['require'], $inputType);
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
            self::$formInput .= $filed . ": " . $v . "," . "\n";
        }
    }

    public static function input($name, $filed, $bool, $type)
    {
        if ($bool == true) {
            $role = ' lazy-rules
            :rules="[(val) => !!val || $t(' . "'v.required'" . ')]"
            :error-message="form.errors.' . $filed . '"
            :error="form.errors.' . $filed . ' ? true : false"';
        } else {
            $role = 'class="q-mb-md"';
        }
        return '<q-input
        clearable
        type="' . $type . '"
        filled
        v-model="form.' . $filed . '"
        :label="$t(' . "'input." . $name . "." . $filed . "'" . ')"
       ' . $role . '
      />' . "\n";
    }

    public static function editor($filed, $name)
    {
        return '<q-editor v-model="form.' . $filed . '" min-height="5rem"
        :placeholder="' . "'input." . $name . "." . $filed . "'" . '"/>' . "\n";
    }

    public static function select($name, $filed, $bool, $lists)
    {
        if ($bool == true) {
            $role = ' lazy-rules
            :rules="[(val) => !!val || $t(' . "'v.required'" . ')]"
            :error-message="form.errors.' . $filed . '"
            :error="form.errors.' . $filed . ' ? true : false"';
        } else {
            $role = 'class="q-mb-md"';
        }
        return '<q-select
        clearable
        :options="' . $lists . '"
        option-value="id"
        option-label="name"
        emit-value
        map-options
        filled
        v-model="form.' . $filed . '"
        :label="$t(' . "'input." . $name . "." . $filed . "'" . ')"
       ' . $role . '
      />' . "\n";
    }
}

<?php

namespace Moawiaab\LaravelTheme\Services;

use Illuminate\Support\Facades\File;

class FileService
{
    public static function allFiles($path, $continueText = ["Controller", "Auth"])
    {
        $files = File::allFiles($path);

        $allFiles = [];

        foreach ($files as $file) {
            $file = explode(".", $file->getRelativePathname())[0];
            if (in_array($file, $continueText)) {
                continue;
            }
            $allFiles[] = $file;
        }
        return $allFiles;
    }

    public static function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    public static function editFile($path, $text)
    {
        $file = fopen($path, 'a');
        fwrite($file, $text);
        fclose($file);
    }

    public static function deleteAllFiles($path)
    {
        if (is_dir($path)) {
            array_map(function ($value) {
                self::deleteAllFiles($value);
                rmdir($value);
            }, glob($path . '/*', GLOB_ONLYDIR));
            array_map('unlink', glob($path . "/*"));
        }
    }

    public static function makeDefaultFolder()
    {
        $path = app_path('Http/Controllers/Api');
        $resource = app_path('Http/Resources');
        $require = app_path('Http/Requests');
        if (!is_dir($path))
            mkdir($path, 0755);
        if (!is_dir($resource))
            mkdir($resource, 0755);
        if (!is_dir($require))
            mkdir($require, 0755);
    }

    public static function viewResource($name, $path, $store, $tableName)
    {
        $useStoreIndex = 'use' . ucfirst($name) . 'sIndex';
        $useStoreSingle = 'use' . ucfirst($name) . 'sSingle';
        $createName = 'Create' . ucfirst($name);
        $editName = 'Edit' . ucfirst($name);
        $showName = 'Show' . ucfirst($name);
        //index file
        FileService::replaceInFile('useUsersIndex', $useStoreIndex, $path . '/Index.vue');
        FileService::replaceInFile('users', $tableName, $path . '/Index.vue');
        FileService::replaceInFile('user', $name, $path . '/Index.vue');
        FileService::replaceInFile("//don't remove the line", DefaultText::$columnNamesVuetify, $path . '/Index.vue');

        //create file
        FileService::replaceInFile('useUsersIndex', $useStoreIndex, $path . '/Create.vue');
        FileService::replaceInFile('useSingleUsers', $useStoreSingle, $path . '/Create.vue');
        FileService::replaceInFile('CreateUser', $createName, $path . '/Create.vue');
        FileService::replaceInFile('users', $tableName, $path . '/Create.vue');
        FileService::replaceInFile('user', $name, $path . '/Create.vue');
        FileService::replaceInFile('inputsItem', DefaultText::$inputItems, $path . '/Create.vue');
        FileService::replaceInFile('validationFiled', DefaultText::$validation, $path . '/Create.vue');

        //edit file
        FileService::replaceInFile('useUsersIndex', $useStoreIndex, $path . '/Edit.vue');
        FileService::replaceInFile('useSingleUsers', $useStoreSingle, $path . '/Edit.vue');
        FileService::replaceInFile('EditUser', $editName, $path . '/Edit.vue');
        FileService::replaceInFile('users', $tableName, $path . '/Edit.vue');
        FileService::replaceInFile('user', $name, $path . '/Edit.vue');
        FileService::replaceInFile('inputsItem', DefaultText::$inputItems, $path . '/Edit.vue');
        FileService::replaceInFile('validationFiled', DefaultText::$validation, $path . '/Edit.vue');
        //show file
        FileService::replaceInFile('useUsersIndex', $useStoreIndex, $path . '/Show.vue');
        FileService::replaceInFile('useSingleUsers', $useStoreSingle, $path . '/Show.vue');
        FileService::replaceInFile('users', $tableName, $path . '/Show.vue');
        FileService::replaceInFile('user', $name, $path . '/Show.vue');
        FileService::replaceInFile('ShowUser', $showName, $path . '/Show.vue');

        //store file

        if (config('theme.stack') === 'quasar') {
            FileService::replaceInFile('useUsersIndex', $useStoreIndex, $store . '/index.ts');
            FileService::replaceInFile('UserColumn', ucfirst($name) . 'Column', $store . '/index.ts');
            FileService::replaceInFile('users', $tableName, $store . '/index.ts');
            FileService::replaceInFile('user', $name, $store . '/index.ts');
        } elseif (config('theme.stack') === 'vuetify') {
            FileService::replaceInFile('useSingleUsers', $useStoreSingle, $store . '/single.ts');
            FileService::replaceInFile('users', $tableName, $store . '/single.ts');
            FileService::replaceInFile('user', $name, $store . '/single.ts');

            FileService::replaceInFile('useUserIndex', $useStoreIndex, $store . '/users.ts');
            FileService::replaceInFile('users', $tableName, $store . '/users.ts');
            FileService::replaceInFile('user', $name, $store . '/users.ts');
        }
    }
}

<?php

namespace Moawiaab\LaravelTheme\Services;


class RequestService
{

    public static function createIsNotExist()
    {
        $storeR = app_path('Http/Requests/Store' . DefaultText::$name . 'Request.php');
        $updateR = app_path('Http/Requests/Update' . DefaultText::$name . 'Request.php');

        if (!file_exists($storeR)) {
            copy(__DIR__ . '/../Http/Requests/StoreBasicRequest.php', $storeR);
        }
        if (!file_exists($updateR)) {
            copy(__DIR__ . '/../Http/Requests/UpdateBasicRequest.php', $updateR);
        }
        //replace request name
        FileService::replaceInFile('StoreBasicRequest', 'Store' . DefaultText::$name . "Request", $storeR);
        FileService::replaceInFile("'name' => [],", DefaultText::$filedRequire, $storeR);
        FileService::replaceInFile('UpdateBasicRequest', 'Update' . DefaultText::$name . "Request", $updateR);
        FileService::replaceInFile("'name' => [],", DefaultText::$filedRequire, $updateR);
    }
}

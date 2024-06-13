<?php

namespace Moawiaab\LaravelTheme\Services;


class ControllerService
{

    public static function createIsNotExist()
    {
        $controller = app_path('Http/Controllers/Api/' . DefaultText::$controllerName . '.php');
        if (!file_exists($controller)) {
            copy(__DIR__ . '/../Http/Controllers/BasicController.php', $controller);
        }
        //replace controller name and method names
        FileService::replaceInFile('BasicController', DefaultText::$controllerName, $controller);
        FileService::replaceInFile('$basic', '$' . DefaultText::$small_name, $controller);
        // FileService::replaceInFile('Basics/', $name . 's/', $controller);
        // FileService::replaceInFile('basics', $smallName . 's', $controller);
        FileService::replaceInFile('basic_', DefaultText::$small_name . '_', $controller);
        FileService::replaceInFile('Basic', DefaultText::$name, $controller);
        FileService::replaceInFile('//set resource', DefaultText::$appModelList, $controller);
    }
}

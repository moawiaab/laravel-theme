<?php

namespace Moawiaab\LaravelTheme\Services;


class ResourcesService
{

    public static function createIsNotExist()
    {
        $resource = app_path('Http/Resources/' . DefaultText::$name . 'Resource.php');

        if (!file_exists($resource)) {
            copy(__DIR__ . '/../Http/Resources/BasicResource.php', $resource);
        }

        FileService::replaceInFile('BasicResource', DefaultText::$name . "Resource", $resource);

    }
}

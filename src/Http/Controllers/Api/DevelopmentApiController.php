<?php

namespace Moawiaab\LaravelTheme\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Moawiaab\LaravelTheme\Services\DevelopmentService;

class DevelopmentApiController extends Controller
{
    public function index()
    {

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

    public function remove(Request $request) {
        return [
            'views' => DevelopmentService::getPermission($request->name),
        ];
    }

    public function add(Request $request) {
        return [
            'views' => DevelopmentService::setPermission($request->name),
        ];
    }
}

<?php

namespace Moawiaab\LaravelTheme\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class DashboardApiController extends Controller
{
    public function index()
    {
        $bar5 = [
            'labels' => [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ],
            'datasets' => [
                [
                    'label' => 'one',
                    'backgroundColor'    => '#f800ff',
                    'data' => [15, 20, 12, 59, 10],
                ],
                [
                    'label' => 'tow',
                    'backgroundColor'    => '#000079',
                    'data' => [40, 12, 12, 39, 10, 40, 39, 60, 40, 20, 12, 11],
                ]
            ]
        ];


        $dataNum = [
            'user' => 20, //auth()->user()->account->users()->count(),
            'client' => 120, //auth()->user()->account->clients()->count(),
            'product' => 98 , //auth()->user()->account->products()->count(),
            'store' => 5 //auth()->user()->account->stores()->count(),
        ];
        return [
            'bar'      => $bar5,
            'barChart' => null ,// Order::count() >  0 ? $bar : null,
            'num'      => $dataNum,
            'line'     => null, //Order::count() >  0 ? $line4 : null
        ];
    }
}

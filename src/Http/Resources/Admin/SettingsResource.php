<?php

namespace Moawiaab\LaravelTheme\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'exp_roof'         => $this->exp_roof ? true : false,
            'exp_conf'         => $this->exp_conf ? true : false,
            'order_sup_conf'   => $this->order_sup_conf ? true : false,
            'order_conf'       => $this->order_conf ? true : false,
            'order_back_conf'  => $this->order_back_conf ? true : false,
            'locker_conf'      => $this->locker_conf ? true : false,
        ];
    }
}

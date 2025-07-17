<?php

namespace Moawiaab\LaravelTheme\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    public function toArray($request)
    {
            return [
            'id'         => $this->id,
            'name'       => $this->description ?? '',
            'users'       => $this->users ?? '',
            'permissions'      => $this->permissions ?? '',
            'amount'     => $this->amount ?? '',
            'details'    => $this->name ?? '',
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : '',
        ];
    }
}

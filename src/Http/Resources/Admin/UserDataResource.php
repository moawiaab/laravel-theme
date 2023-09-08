<?php

namespace Moawiaab\LaravelTheme\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDataResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name ?? '',
            'email'      => $this->email ?? '',
            'phone'      => $this->phone ?? '',
            'role'       => $this->role->title ?? '',
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : '',
        ];
    }
}

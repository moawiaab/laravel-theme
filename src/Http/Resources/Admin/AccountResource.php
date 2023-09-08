<?php

namespace Moawiaab\LaravelTheme\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'details'  => $this->details ?? '',
            'phone'   => $this->phone,
            'toggle'  => $this->status,
            'user'    => $this->users->count(),
            'role'    => $this->roles->count(),
            'users' => $this->users->transform(fn($e) => ['user' => $e->name]),
            'roles' => $this->roles->transform(fn($e) => ['role' => $e->title]),
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : '',
        ];
    }
}

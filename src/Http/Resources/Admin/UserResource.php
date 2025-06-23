<?php

namespace Moawiaab\LaravelTheme\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name ?? '',
            'email'      => $this->email ?? '',
            'toggle'     => $this->status,
            'locker'     => $this->locker->id ?? false,
            'phone'      => $this->phone ?? '',
            // 'role_id'    => $this->role_id ?? '',
            'account'    => $this->account->name ?? '',
            'deletable'  => $this->account_id == auth()->user()->account_id ?? false,
            'editable'   => $this->account_id == auth()->user()->account_id ?? false,
            // 'online'     => $this->last_activity ?? '',
            'role'       => $this->role ? $this->role->title : 'لا يوجد صلاحية',
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : '',
            'deleted_at' => $this->deleted_at ?? '',
        ];
    }
}

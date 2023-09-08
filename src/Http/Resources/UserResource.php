<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name ?? '',
            'email'      => $this->email ?? '',
            // 'toggle'     => $this->status,
            'phone'      => $this->phone ?? '',
            'role_id'    => $this->role_id ?? '',
            'account'    => $this->account->name ?? '',
            // 'online'     => $this->last_activity ?? '',
            'role'       => $this->role ? $this->role->title : 'لا يوجد صلاحية',
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : '',
            'deleted_at' => $this->deleted_at ?? '',
        ];
    }
}

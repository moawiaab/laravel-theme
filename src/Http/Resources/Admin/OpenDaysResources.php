<?php

namespace Moawiaab\LaravelTheme\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class OpenDaysResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'      => $this->id,
            'name'    => $this->locker->user->name ?? '',
            'user'    => $this->user ? $this->user->name : '' ?? '',
            'admin'   => $this->admin ? $this->admin->name : '' ?? '',
            'amount'  => $this->amount ?? '',
            'status'  => $this->status,
            'problem' => $this->problem ?? '',
            'on_open' => $this->on_open ?? '',
            'newItem' => $this->status,
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y :h:i:s') : '',
            'updated_at' => $this->updated_at ? $this->updated_at->format('d-m-Y :h:i:s') : '',
            'deleted_at' => $this->deleted_at ?? ''
        ];
    }
}

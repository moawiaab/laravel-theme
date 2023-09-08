<?php

namespace Moawiaab\LaravelTheme\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpanseItemsResources extends JsonResource
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
            'id'         => $this->id,
            'name'       => $this->exp->name ?? '',
            'user'       => $this->user->name ?? '',
            'admin'      => $this->admin->name ?? '',
            'amount'     => $this->amount ?? '',
            'details'    => $this->details ?? '',
            'status'     => $this->status ?? '',
            'done'       => $this->status ?? '',
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y :h:i:s') : '',
        ];
    }
}

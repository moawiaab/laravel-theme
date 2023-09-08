<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AmountListResource extends JsonResource
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
            'id' => $this->id,
            'user' => $this->user->name ?? '',
            'admin' => $this->admin->name ?? '',
            'amount' => $this->amount ?? '',
            'problem' => $this->problem ?? '',
            'on_open' => $this->on_open ?? '',
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y :h:i:s') : '',
            'updated_at' => $this->updated_at ? $this->updated_at->format('d-m-Y :h:i:s') : '',
        ];
    }
}

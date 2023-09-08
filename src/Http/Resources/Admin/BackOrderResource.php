<?php

namespace Moawiaab\LaravelTheme\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BackOrderResource extends JsonResource
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
            'name'       => $this->pro->name ?? $this->name ?? '',
            'all_amount' => $this->amount,
            'num'        => $this->num ?? '',
            'price'      => $this->amount > 0 ? $this->amount / $this->num  :  0,
            'user'       => $this->user->name ?? '',
            'updated_user'      => $this->updatedUser->name ?? '',
            'details'    => $this->details ?? '',
            'status'     => $this->status == 1 ? true : false,
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y :h:i:s') : '',
            'updated_at' => $this->updated_at ? $this->updated_at->format('d-m-Y :h:i:s') : '',
        ];
    }
}

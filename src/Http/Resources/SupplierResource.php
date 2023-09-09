<?php

namespace Moawiaab\LaravelTheme\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
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
            'id'        => $this->id,
            'name'      => $this->name ?? '',
            'email'     => $this->email ?? '',
            'toggle'    => $this->status,
            'deletable' => true,
            'status'    => $this->status,
            'phone'     => $this->phone ?? '-',
            'user'      => $this->user->name ?? '-',
            'address'   => $this->address ?? '-',
            'amount'    => $this->amount ?? 0,
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : '',
            'deleted_at' => $this->deleted_at ?? '',
        ];
    }
}

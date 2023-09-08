<?php

namespace App\Http\Resources\Admin\Lists;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowSupplierResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'email'   => $this->email,
            'toggle'  => $this->status,
            'details' => $this->details,
            'child'   => $this->status,
            'status'  => $this->status,
            'phone'   => $this->phone ?? '-',
            'address' => $this->address ?? '',
            'amount'  => $this->amount ?? '',
        ];
    }
}

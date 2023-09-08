<?php

namespace App\Http\Resources\Admin\Lists;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowClientResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'email'     => $this->email,
            'toggle'    => $this->status,
            'child'     => $this->type != 2 ?  ($this->roof <= $this->amount ? false : true) : true,
            'roof'      => $this->roof,
            'type_label' => $this->type_label,
            'status'    => $this->status,
            'phone'     => $this->phone ?? '-',
            'address'   => $this->address ?? '',
            'amount'    => $this->amount ?? '',

        ];
    }
}

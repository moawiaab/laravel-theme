<?php

namespace Moawiaab\LaravelTheme\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CheckResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'         => $this->id ?? '',
            'name'       => $this->name ?? '',
            'client'     => $this->client ? $this->client->name : $this->supplier->name ?? '',
            'amount'     => $this->amount ?? 0,
            'num'        => $this->num ?? 0,
            'details'    => $this->details ?? '',
            'status'     => $this->status == 1 ? true : false,
            'type'       => $this->type,
            'bank'       => $this->bank,
            'user'       => $this->user->name ?? '',
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : '',
        ];
    }
}

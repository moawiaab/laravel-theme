<?php

namespace Moawiaab\LaravelTheme\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Moawiaab\LaravelTheme\Http\Resources\AmountListResource;

class PrivateLockerResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->user->name ?? '',
            'toggle' => $this->status,
            'child' =>  $this->user
                ? (auth()->id() == $this->user_id
                    ? true : (auth()->user()->role_id === 1
                        ? true : false
                    )
                ) : false,
            'amount' => $this->amount ?? '',
            'items'   => AmountListResource::collection($this->items->take(5)) ?? [],
            'problem' => $this->problem ?? '',
            'on_open' => $this->on_open ?? '',
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : '',
            'updated_at' => $this->updated_at ? $this->updated_at->format('d-m-Y :h:i:s') : '',
            'deleted_at' => $this->deleted_at ?? ''
        ];
    }
}

<?php

namespace Moawiaab\LaravelTheme\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductStoreResource extends JsonResource
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
            'id'              => $this->id,
            'name'            => $this->product->name ?? '',
            'store'           => $this->store->name ?? '',
            'number'          => $this->number ?? 0,
            'number_in'       => $this->number_in ?? 0,
            'number_out'      => $this->number_out ?? 0,
            'category'        => $this->product->category->name ?? '',
            'unit'            => $this->product->unit->name ?? '',
            'price'           => $this->product->price ?? 0,
            'amount'          => $this->product->amount ?? 0,
        ];
    }
}

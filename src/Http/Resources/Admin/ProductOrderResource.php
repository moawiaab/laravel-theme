<?php

namespace Moawiaab\LaravelTheme\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductOrderResource extends JsonResource
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
            'name'     => "$this->name - السعر : $this->amount",
            'barcode'  => $this->barcode,
            'value'    => $this->id,
            'product'  => $this->name ?? '',
            'max'      => $this->number,
            'gain'     => $this->gain,
            'amount'   => $this->amount  ?? 0,
            'price'    => $this->price ?? 0,
            'options'  => [
                'سعر البيع      : ' . $this->price,
                'سعر الشراء     : ' . $this->amount,
                'العدد الموجود : ' . $this->products->where('account_id', request('account',auth()->user()->account_id))->sum('number') ?? 0,
                'نسبة الربح : ' . $this->gain,
                ' التفاصيل : ' . $this->details,
            ]
        ];
    }
}

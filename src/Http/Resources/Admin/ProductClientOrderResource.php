<?php

namespace Moawiaab\LaravelTheme\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductClientOrderResource extends JsonResource
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
            'name'    => "$this->name - السعر : $this->price",
            'barcode'  => $this->barcode,
            'value'    => $this->id,
            'product'  => $this->name ?? '',
            'max'      => $this->number,
            'gain'     => $this->gain,
            'amount'   => $this->amount  ?? 0,
            'price'    => $this->price ?? 0,
            'options'  => [
                'سعر البيع      : ' . $this->price,
                'الكمية الواردة      : ' . $this->products->where('account_id', request('account',auth()->user()->account_id))->sum('number_in') ?? 0,
                'الكمية الصادرة      : ' . $this->products->where('account_id', request('account',auth()->user()->account_id))->sum('number_out') ?? 0,
                'الكمية الفعلية : ' . $this->products->where('account_id', request('account',auth()->user()->account_id))->sum('number') ?? 0,
                ' التفاصيل : ' . $this->details,
            ],
            'stores'  => $this->products->where('account_id', request('account',auth()->user()->account_id))->transform(fn ($e) => [
                'id' => $e->id,
                'store_id' => $e->store_id,
                'number' => $e->number,
                'store' => $e->store->name . ' - الكمية : ' . $e->number?? ''
            ])
        ];
    }
}

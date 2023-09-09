<?php

namespace Moawiaab\LaravelTheme\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreItemResource extends JsonResource
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
            'id'           => $this->id,
            'product'      => $this->product->name ?? '',
            'orderId'      => $this->order_id ?? '',
            'user'         => $this->user->name ?? '',
            'supplier'     => $this->supplier->name ?? $this->client->name ?? '',
            'num'          => $this->num,
            'itemCount'    => $this->items->count(),
            'number'       => $this->last_num,
            'editable'     => $this->num > $this->last_num ? true : false,
            'status'       => $this->status == 1 ? 'قيد الوزن' : 'تم الوزن' ?? '-',
            'created_at'   => $this->created_at ? $this->created_at->format('d-m-Y :h:i:s') : '',
            'weight'       => $this->items->transform(fn ($e) => [
                'dirver' => $e->dirver->only(['name', 'car_id']) ?? '',
                'items' => $e->items->transform(fn ($i) =>
                ['jawal' => $i->jawal, 'number' => $i->number, 'num' => $i->num]),
                'countItem' => $e->items->count()
            ]),
            'created_at'   => $this->created_at ? $this->created_at->format('d-m-Y :h:i:s') : '',
        ];
    }
}

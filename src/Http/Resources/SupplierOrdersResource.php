<?php

namespace Moawiaab\LaravelTheme\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierOrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'         => $this->id,
            'type'       => $this->type == 0 ? 'مشتريات موردين' : 'مشتريات عملاء',
            'amount'     => $this->amount ?? 0,
            'account'    => $this->type == 0 ? $this->supplier->name : $this->client->name ?? '-',
            'num'        => $this->items->count(),
            'details'    => $this->details ?? '',
            'status'     => $this->items->whereIn('status', 1)->first() ? true : false,
            // 'tegs'       => $this->items->sum('last_num') ?? 0,
            'number'     => $this->items->sum('num') ?? 0,
            'user'       => $this->user->name ?? '',
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y :h:i:s') : '',
            'items'       => $this->items->transform(fn ($e) => [
                'id'      => $e->id,
                'name'    => $e->product->name ?? '-',
                'num'     => $e->num ?? 0,
                // 'tegs'    => $e->last_num ?? 0,
                'amount'  => $e->amount ?? 0,
                // 'price'   => $e->price ?? 0,
                'status'  => $e->status == 1 ? true : false,
                'total'   => $e->amount * $e->num ?? 0,
                'user'    => $e->user->name ?? '-',
                'admin'   => $e->userCheck->name ?? '-',
                'updated_at' => $e->updated_at->format('d-m-Y :h:i:s') ?? '-',
            ]) ?? [],
        ];
    }
}

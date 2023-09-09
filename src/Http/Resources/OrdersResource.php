<?php

namespace Moawiaab\LaravelTheme\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
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
            'type'       => $this->type == 0 ? ' دين' : ' كاش',
            'amount'     => $this->amount ?? 0,
            'account'    => $this->client->name ?? '-',
            'num'        => $this->items->count(),
            'details'    => $this->details ?? '',
            'discount'   => $this->discount ?? 0,
            'backed'     => $this->items->sum('back') <= 0 ? true : false,
            // 'tegs'       => $this->items->sum('last_num') ?? 0,
            'status'     => $this->items->whereIn('status', 1)->first() ? true : false,
            'number'     => $this->items->sum('num') ?? 0,
            'user'       => $this->user->name ?? '',
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y :h:i:s') : '',
            'items'       => $this->items->transform(fn ($e) => [
                'id'      => $e->id,
                'name'    => $e->product->name ?? '-',
                'num'     => $e->num ?? 0,
                'backed'     => $e->back < $e->num ? true : false,
                'back'       => $e->back ?? 0,
                'status'  => $e->status == 1 ? true : false,
                'amount'  => $e->amount ?? 0,
                'price'   => $e->price ?? 0,
                'total'   => $e->price * $e->num ?? 0,
                'user'    => $e->user->name ?? '-',
                'admin'   => $e->userCheck->nmae ?? '-',
                'updated_at' => $e->updated_at->format('d-m-Y :h:i:s') ?? '-',
            ]) ?? [],
        ];
    }
}

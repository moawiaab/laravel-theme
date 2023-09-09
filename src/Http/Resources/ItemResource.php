<?php

namespace Moawiaab\LaravelTheme\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'price'           => $this->price ?? 0,
            'amount'          => $this->amount ?? 0,
        ];
    }
}

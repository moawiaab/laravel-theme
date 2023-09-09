<?php

namespace Moawiaab\LaravelTheme\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Moawiaab\LaravelTheme\Models\ProductStore;

class StoresResource extends JsonResource
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
            'id'       => $this->id,
            'name'     => $this->name ?? '',
            'details'  => $this->details ?? '',
            'toggle'   => $this->status,
            'products' => ProductStoreResource::collection(ProductStore::where('store_id', $this->id)->get()->take(10)), //ProductResource::collection($this->products),
            'productCount' => $this->products->count() ?? 0,
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : '',
            'deleted_at' => $this->deleted_at ?? '',
        ];
    }
}

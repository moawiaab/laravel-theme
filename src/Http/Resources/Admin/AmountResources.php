<?php

namespace Moawiaab\LaravelTheme\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AmountResources extends JsonResource
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
            'amount'   => $this->amount ?? 0,
            'details'  => $this->details ?? '',
            'take'     => $this->take ?? 0,
            'type'     => $this->type_label ?? '',
            'export'   => $this->export ?? 0,
            'user'     => $this->user->name ?? '',
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : '',
        ];
    }
}

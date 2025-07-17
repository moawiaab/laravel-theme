<?php

namespace Moawiaab\LaravelTheme\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpanseResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);
         return [
            'id'         => $this->id ?? '',
            'name'      => $this->budget->budget->name ?? '',
            'amount'        => (int)$this->amount ?? 0,
            'text_amount'        => $this->text_amount ?? 'لا يوجد نص',
            'beneficiary'        => $this->beneficiary ?? '',
            'details'        => $this->details ?? '',
            'status'     => (int)$this->status,
            'user'       => $this->user->name ?? '',
            'admin'       => $this->admin->name ?? 'غير مستلم',
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : '',
            'deleted_at' => $this->deleted_at ? $this->deleted_at->format('d-m-Y') : '',
            'updated_at' => $this->updated_at ? $this->updated_at->format('d-m-Y') : '',
            'show'  => true
        ];
    }
}

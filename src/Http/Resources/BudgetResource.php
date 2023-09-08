<?php

namespace App\Http\Resources;

use App\Http\Resources\Admin\ExpanseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BudgetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->budget->name ?? '',
            'amount'        => $this->amount ?? 0,
            'expense'       => $this->expense_amount ?? 0,
            'toggle'        => $this->status,
            'budget_status' => $this->status_label ?? '',
            'num'           => $this->expanses->count() ?? 0,
            'items'         => ExpanseResource::collection($this->expanses->take(5)) ?? [],
            'created_at'    => $this->created_at ? $this->created_at->format('d-m-Y :h:i:s') : '',
            'deleted_at' => $this->deleted_at ?? '',
        ];
    }
}

<?php

namespace Moawiaab\LaravelTheme\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class StageResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'       => $this->id ?? '',
            'label'    => $this->name ?? '',
            'details'  => $this->details ?? 'الموازنات المالية لهذه السنة',
            'start_date' => $this->start_date ?? '',
            'end_date'   => $this->end_date ?? '',
            'children' => $this->budgets->transform(fn ($i) => [
                'id' => $this->id . '-' . $i->id,
                'label'   => $i->budget->name ?? '',
                'details' => $i->budget->details ?? '',
                'amount'  => $i->amount ?? 0,
                'expense' => $i->expense_amount ?? 0,
                'num'     => $i->expanses->count() ?? 0,
            ])
        ];
    }
}

<?php

namespace Moawiaab\LaravelTheme\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class StageResource extends JsonResource
{
    public function toArray($request)
    {
        $amount = $this->budgets->sum("amount");
        $exp    = $this->budgets->sum("expense_amount");
        $back  =  $amount - $exp;
        // return parent::toArray($request);
        return [
            'id'         => $this->id ?? '',
            'label'       => $this->name . " : الموازنة : " . $amount . " | المصروف : " . $exp . ' | المتبقي : ' . $back?? '',
            // 'details'  => $this->details ?? 'الموازنات المالية لهذه السنة',
            'start_date' => $this->start_date ?? '',
            'end_date'   => $this->end_date ?? '',
            'children'   => $this->budgets->transform(fn ($i) => [
                'id'     => $this->id . '-' . $i->id,
                'label'   => $i->budget->name . ' :  المبلغ المصدق : ' .($i->amount ?? 0) . "  | المصروف : " .($i->expense_amount ?? 0) . " | المتبقي :" .($i->amount - $i->expense_amount)?? '',
                // 'details' => $i->budget->details ?? '',
                'amount'  => $i->amount ?? 0,
                'expense' => $i->expense_amount ?? 0,
                'num'     => $i->expanses->count() ?? 0,

            ])
        ];
    }
}

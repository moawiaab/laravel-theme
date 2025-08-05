<?php

namespace Moawiaab\LaravelTheme\Services;

use Moawiaab\LaravelTheme\Models\FiscalYear;
use Moawiaab\LaravelTheme\Models\Stage;

class FiscalYearService
{

    public static $error = "";
    public static $yearId = null;
    public static $stageId = null;
    public static $startDate = null;
    public static $endDate = null;


    public static function checkYear()
    {
        $y = FiscalYear::where('name', date("Y"))->first();
        if (!$y) {
            self::stopYear();
            $i = new FiscalYear();
            $i->name       = date("Y");
            $i->status     = 1;
            if ($i->save()) {
                $data = [
                    [
                        'name'        => "الربع الاول",
                        'start_date'  => date("y") . "-01-01",
                        'end_date'    => date("y") . "-03-31",
                        'status'      => 1,
                        "fiscal_year_id"        => $i->id,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ],
                    [
                        'name'        => "الربع الثاني",
                        'start_date'  => date("y") . "-04-01",
                        'end_date'    => date("y") . "-06-30",
                        'status'      => 2,
                        "fiscal_year_id"        => $i->id,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ],
                    [
                        'name'        => "الربع الثالث",
                        'start_date'  => date("y") . "-07-01",
                        'end_date'    => date("y") . "-09-30",
                        'status'      => 2,
                        "fiscal_year_id"        => $i->id,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ],
                    [
                        'name'        => "الربع الرابع",
                        'start_date'  => date("y") . "-10-01",
                        'end_date'    => date("y") . "-12-31",
                        'status'      => 2,
                        "fiscal_year_id"        => $i->id,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]
                ];
                $st =   Stage::insert($data);

                return $i;
            }
            return $i;
        }
        return $y;
    }
    public static function checkStage()
    {
        $paymentDate = date('Y-m-d');
        $yId = self::checkYear();

        if ($yId) {
            self::$yearId   = $yId->id;
            $stage = $yId->stages->where("status", 1)->first();

            if ($stage) {
                // dd($paymentDate >= $stage->start_date && $paymentDate <= $stage->end_date);
                if ($paymentDate >= $stage->start_date && $paymentDate <= $stage->end_date) {
                    self::$stageId  = $stage->id;
                    self::$startDate  = $stage->start_date;
                    self::$endDate  = $stage->end_date;
                } else {
                    $s2 = $yId->stages->where('start_date', "<", $paymentDate)->where('end_date', ">", $paymentDate)->first();
                    // dd($s2);
                    self::$stageId  = $s2->id;
                    self::$startDate  = $s2->start_date;
                    self::$endDate  = $s2->end_date;
                    $s2->status = 1;
                    $stage->status = 0;
                    $stage->save();
                    $s2->save();
                }
            }

            return true;
        }
    }

    public static function getStage()
    {
        $y = FiscalYear::where('name', date("Y"))->first();
        $stage = $y->stages->where("status", 1)->first();
        self::$stageId  = $stage->id ?? 0;

        // dd(self::$stageId);
    }
    public static function stopYear()
    {
        $ids  = FiscalYear::pluck("id");
        // dd($ids);
        FiscalYear::whereIn('id', $ids)->update(["status" => 0]);
    }
}

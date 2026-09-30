<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrPayroll extends Model
{
    protected $fillable = [
        'employee_id',
        'year',
        'month',
        'basic_salary',
        'total_bonuses',
        'total_deductions',
        'net_salary',
        'status',
        'paid_at',
        'notes',
    ];

    public function employee()
    {
        return $this->belongsTo(HrEmployee::class);
    }
    public static function totalsFor(HrEmployee $employee, int $year, int $month)
    {
        $bonuses = $employee->bonuses()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->sum('amount');
        $deductions = $employee->deductions()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->sum('amount');
        $base = (float) ($employee->basic_salary ?? 0);
    }
}

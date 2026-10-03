<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrPayroll extends Model
{
    protected $fillable = [
        'employee_id',
        'year',
        'month',
        'base_salary',
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
    public function period()
    {
        return sprintf('%04d-%02d',$this->year, $this->month);
    }
    public function isPaid()
    {
        return $this->status === 'paid';
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
        $base = (float) ($employee->salary ?? 0);
        return [
            'base_salary' => $base,
            'total_bonuses' => $bonuses,
            'total_deductions' => $deductions,
            'net_salary' => $base + $bonuses - $deductions,
        ];
    }
}

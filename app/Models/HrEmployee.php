<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrEmployee extends Model
{
    protected $casts = [
        'hire_date' => 'date',
        'salary' => 'decimal:2',
    ];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'department_id',
        'job_title',
        'hire_date',
        'salary',
        'status',
        'address',
        'notes'
    ];

    public function department()
    {
        return $this->belongsTo(HrDepartment::class);
    }

    public function bonuses()
    {
        return $this->hasMany(HrBonus::class, 'employee_id');
    }

    public function deductions()
    {
        return $this->hasMany(HrDeduction::class, 'employee_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory,SoftDeletes,HasUlids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'address',
        'industry',
        'website',
        'ownerid',
    ];

    protected $dates = [
        'deleted_at'
        ];
    
    protected function casts(): array
    {  
        return [
            'deleted_at' => 'datetime',
        ];
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'ownerid', 'id');
    }
    
    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class, 'company_id', 'id');
    }

    public function jobApplications()
    {
        return $this->hasManyThrough(JobApplication::class, JobVacancy::class, 'company_id', 'job_vacancy_id', 'id', 'id');
    }

}

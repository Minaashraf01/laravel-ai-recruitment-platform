<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class JobVacancy extends Model
{
    use HasFactory,SoftDeletes,HasUlids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'job_vacancies';

    protected $fillable = [
        'title',
        'description',
        'company',
        'type',
        'location',
        'viewCount',
        'salary',
        'company_id',
        'job_category_id',
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
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id','id');
    }
    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id', 'id');
    }
    
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'job_vacancy_id', 'id');
    }

}

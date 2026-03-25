<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplication extends Model
{
    use HasUlids,HasFactory,SoftDeletes;
    protected $table = 'job_applications';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'status',
        'aiGeneratedScore',
        'aiGeneratedFeedback',
        'job_vacancy_id',
        'user_id',
        'resume_id',
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

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function resume()
    {
        return $this->belongsTo(Resume::class, 'resume_id', 'id'); 
    }
}

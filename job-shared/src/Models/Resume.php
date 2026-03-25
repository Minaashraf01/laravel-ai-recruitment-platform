<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resume extends Model
{
    Use HasFactory,SoftDeletes,HasUlids;
    protected $table = 'resumes';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'filename',
        'fileUrl',
        'contactDetails',
        'education',
        'summary',
        'skills',
        'experience',
        'user_id',
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

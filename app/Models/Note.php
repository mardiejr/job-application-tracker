<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = ['job_application_id', 'content'];

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }
}

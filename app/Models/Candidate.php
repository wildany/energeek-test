<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class candidate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['job_id', 'name', 'email', 'phone', 'year', 'created_by', 'updated_by', 'deleted_by'];
    protected $dates = ['deleted_at'];
    public function job()
    {
        return $this->belongsTo(job::class);
    }

    public function skill()
    {
        return $this->belongsToMany(
            skill::class,
            'skill_sets',
            'candidate_id',
            'skill_id'
        );
    }
}

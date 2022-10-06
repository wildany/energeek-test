<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class skill extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'created_by', 'updated_by', 'deleted_by'];
    protected $dates = ['deleted_at'];
    public function candidate()
    {

        return $this->belongsToMany(
            candidate::class,
            'skill_sets',
            'skill_id',
            'candidate_id'
        );
    }
}

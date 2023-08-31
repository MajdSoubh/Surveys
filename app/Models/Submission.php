<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Submission extends Model
{
    use HasFactory;
    public $timestamps = false;


    protected $fillable = ['survey_id', 'start_date', 'end_date'];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}

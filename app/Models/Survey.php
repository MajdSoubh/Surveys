<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Survey extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['user_id', 'title', 'image', 'slug', 'status', 'description', 'expire_date'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isActive()
    {
        return $this->status;
    }
    public function expired()
    {
        return Carbon::parse($this->expire_date)->format('Y-m-d') <= today();
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
    public function answers()
    {
        return $this->hasManyThrough(Answer::class, Submission::class, 'survey_id', 'submission_id');
    }
}

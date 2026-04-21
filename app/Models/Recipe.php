<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Recipe extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function reactions() {
        return $this->hasMany(Reaction::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function favorites(){
        return $this->hasMany(Favorite::class);
    }

    protected static function boot() {
        parent::boot();

        static::creating(function ($recipe){
            $slug = Str::slug($recipe->recipe_name);
            $original = $slug;
            $count = 1;

            while (self::where('slug', $slug)->exists()){
                $slug = $original . '-' . $count++;
            }

            $recipe->slug = $slug;
        });
    }
}

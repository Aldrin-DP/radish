<?php

namespace App\Models;

use Dom\Comment as DomComment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function replies() {
        return $this->hasMany(Comment::class, 'parent_id');
    }
    public function reactions() {
        return $this->hasMany(Reaction::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function recipe() {
        return $this->belongsTo(Recipe::class);
    }
}

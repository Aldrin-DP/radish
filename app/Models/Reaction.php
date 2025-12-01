<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function recipe() {
        return $this->belongsTo (Recipe::class);
    }

    public function comment(){
        return $this->belongsTo (Comment::class );
    }
}

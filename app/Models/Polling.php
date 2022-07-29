<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polling extends Model
{
    use HasFactory;

    protected $table = 'polling';
    protected $guarded = ['id'];

    public function options (){

        return $this->hasMany(OpsiPolling::class);
    }

    public function created_by(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function answer(){
        return $this->hasOne(JawabanPolling::class)->where('user_id', auth()->id());
    }

    public function answers (){
        return $this->hasMany(JawabanPolling::class);
    }
}

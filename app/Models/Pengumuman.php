<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;
    
    protected $table = 'pengumuman';
    protected $guarded = ['id'];

    public function created_by (){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    
    public function users(){
        return $this->belongsToMany(User::class);
    }
}

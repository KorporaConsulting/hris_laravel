<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'kehadiran';


    public function user (){
        return $this->belongsTo(User::class); 
    }
}

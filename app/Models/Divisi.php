<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;
    
    protected $table = 'divisi';

    protected $guarded = [];


    public function users ()
    {
        return $this->belongsToMany(User::class)->withPivot('status');
    }
}

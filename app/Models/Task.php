<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $with = ['user'];

    protected $table = 'task';

    protected $guarded = ['id'];

    public function user (){
        return $this->belongsTo(User::class);
    }
}

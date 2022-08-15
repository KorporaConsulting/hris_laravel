<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table = 'project';
    protected $guarded = [];

    public function board (){
        return $this->hasOne(Board::class);
    }
}

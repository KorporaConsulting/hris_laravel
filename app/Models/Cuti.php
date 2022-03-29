<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $table = 'cuti';

    public function user () {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpsiPolling extends Model
{
    use HasFactory;

    protected $table = 'opsi_polling';

    protected $guarded = ['id'];
}

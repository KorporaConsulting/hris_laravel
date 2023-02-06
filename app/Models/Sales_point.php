<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales_point extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function totalUserPoint($user_id)
    {
        $data = Sales_point::where('user_id', $user_id)->get();

        $point = [];

        foreach ($data as $value) {
            $point[] = $value->point();
        }

        return count($point);
    }
}

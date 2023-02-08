<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
    }

    public function getListUser()
    {
        if (auth()->user()->hasRole('manager')) {
            $divisi_id = auth()->user()->divisi_id;
            $user = User::where('divisi_id', $divisi_id)->get();
        }

        if (auth()->user()->hasRole('hrd')) {
            $user = User::all();
        }

        foreach ($user as $data) {
            $res[] = ['id' => $data->id, 'text' => $data->name];
        }

        return response()->json($res);
    }
}

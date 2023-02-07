<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales_point;
use Illuminate\Support\Facades\DB;

class PointSalesController extends Controller
{

    public function index()
    {
        if (auth()->user()->hasRole('staff')) {
            $points = Sales_point::where('user_id', auth()->user()->id)->get();
        }

        if (auth()->user()->hasRole('hrd')) {
            $points = Sales_point::all();
        }

        if (auth()->user()->hasRole('manager')) {
            $points = Sales_point::all();
        }

        return view('point-sales/index', compact('points'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $files = $request->file('files');
        foreach ($files as $file) {
            $file_path['path'][] = $file->store('file-point');
        }

        $sales_point = new Sales_point();

        $sales_point->deskripsi = $request->deskripsi;
        $sales_point->files = json_encode($file_path);
        $sales_point->user_id = $request->user_id ?? auth()->user()->id;

        $sales_point->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Mengajukan',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $sales_point = Sales_point::with('user')->findOrFail($request->id);
        return response()->json($sales_point);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales_point;
use App\Models\Penukaran_point;
use Illuminate\Support\Facades\DB;

class PointSalesController extends Controller
{

    public function index()
    {
        $total_point = [];
        $total_penukaran = [];

        if (auth()->user()->hasRole('staff')) {
            $points = Sales_point::where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->get();
            foreach ($points as $value) {
                array_push($total_point, $value->point);
            }
            $penukaran = Penukaran_point::where('user_id', auth()->user()->id)->get();
            foreach ($penukaran as $value) {
                array_push($total_penukaran, $value->pengurangan_point);
            }
        }

        if (auth()->user()->hasRole('hrd')) {
            $points = Sales_point::all();
        }

        if (auth()->user()->hasRole('manager')) {
            $divisi_id = auth()->user()->divisi_id;
            $points = Sales_point::with('user')
                ->whereHas('user', function ($q) use ($divisi_id) {
                    $q->where('divisi_id', '=', $divisi_id);
                })
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $sisa_point = array_sum($total_point) - array_sum($total_penukaran);
        return view('point-sales.index', compact('points', 'sisa_point'));
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

        return redirect()->back();
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
        $sales_point = Sales_point::findOrFail($request->id);

        if ($request->status == 'Setujui') {
            $sales_point->is_approved = 1;
            $sales_point->point = $request->point;
        } else if ($request->status == 'Tolak') {
            $sales_point->is_approved = 0;
            $sales_point->point = 0;
        }
        $sales_point->approved_by = $request->approved_by;
        $sales_point->tanggal_approve = $request->tanggal_approve;

        $sales_point->update();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $Sales_point = Sales_point::findOrFail($request->id);

        $Sales_point->delete();
        return response()->json(['success' => true]);
    }

    public function sisa(Request $request)
    {
        $total_point = [];
        $total_penukaran = [];

        $points = Sales_point::where('user_id', $request->id)->get();
        foreach ($points as $value) {
            array_push($total_point, $value->point);
        }

        $penukaran = Penukaran_point::where('user_id', $request->id)->get();
        foreach ($penukaran as $value) {
            array_push($total_penukaran, $value->pengurangan_point);
        }

        $sisa = array_sum($total_point) - array_sum($total_penukaran);

        return response()->json([
            'sisa' => $sisa
        ]);
    }
}

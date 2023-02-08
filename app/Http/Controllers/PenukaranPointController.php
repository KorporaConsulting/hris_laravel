<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penukaran_point;

class PenukaranPointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penukaran_points = Penukaran_point::all();
        return view('penukaran-points.index', compact('penukaran_points'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $penukaran_point = new Penukaran_point;

        $penukaran_point->pengurangan_point = $request->pengurangan_point;
        $penukaran_point->reward = $request->reward;
        $penukaran_point->tanggal_penukaran = $request->tanggal_penukaran;
        $penukaran_point->user_id = $request->user_id;
        $penukaran_point->approved_by = $request->approved_by;

        $penukaran_point->save();

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $penukaran_points = Penukaran_point::with('user')->findOrFail($request->id);

        return response()->json($penukaran_points);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $penukaran_points = Penukaran_point::findOrFail($request->id);

        $penukaran_points->delete();
        return response()->json(['success' => true]);
    }
}

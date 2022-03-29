<?php

namespace App\Http\Controllers;

use App\Events\NotificationsEvent;
use Illuminate\Http\Request;
use App\Models\Cuti;


class CutiController extends Controller
{

    public function index ()
    {

        if(auth()->user()->level == 'manager'){
            $callback = function($q){
                $q->where('parent_id', '!=', auth()->id());
            };
        }else if(auth()->user()->level == 'direktur'){
            $callback = function($q){
                $q->where('parent_id', auth()->id())->whereIn('level', ['manager', 'hr']);
            };    
        }else{
            return abort(404);
        }

        return view('cuti.index',[
            'cuti' => Cuti::whereHas('user', $callback)->with('user')
            ->where('status', 'waiting')
            ->get()
        ]);
    }
 

    public function show () {

    
        return view('cuti.show', [
            'cuti' => Cuti::where('user_id', auth()->id())->get()
        ]);
    }

    public function create ()
    {

        return view('cuti.create');
    }
    
    public function store ()
    {

        // dd(request()->all());

        $sampai_tanggal = date('Y-m-d', strtotime(request('mulai_tanggal') .' + '. request('lama_cuti').' day'));

        // dd($sampai_tanggal);
        Cuti::create([
            'user_id' => auth()->id(),
            'divisi' => auth()->user()->divisi,
            'jenis_cuti' => request('jenis_cuti'),
            'mulai_tanggal' => request('mulai_tanggal'),
            'sampai_tanggal' => $sampai_tanggal,
            'lama_cuti' => request('lama_cuti'),
            'sisa_cuti' => auth()->user()->sisa_cuti - request('lama_cuti'),
            'cuti_awal' => auth()->user()->sisa_cuti,
            'is_approve' => '0',
            'keterangan_cuti' => request('keterangan') 
        ]);
    
        session()->flash('success', 'Berhasil mengajukan cuti');

        return redirect()->route('cuti.show');

    }

    public function update ($id)
    {
        Cuti::where('id', $id)->update([
            'nama_manager' => auth()->user()->name,
            'keterangan_manager' => request('keterangan'),
            'status' => request('status'),
            'updated_at' => date('Y-m-d h:i:s')
        ]);

        $message = request('status') == 'accept' ? 'menyetujui' : 'menolak';

        NotificationsEvent::dispatch('Cuti anda disetujui', request('userId'));

        session()->flash('success', "Berhasil ".$message." cuti");

        return response()->json([
            'success' => true
        ]);
    }

    public function destroy ($id)
    {
        Cuti::where('id', $id)->delete();

        session()->flash('success', 'Berhasil menghapus cuti');

        return redirect()->route('cuti.show');
    }

    
}

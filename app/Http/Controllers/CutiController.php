<?php

namespace App\Http\Controllers;

use App\Events\NotificationsEvent;
use App\Jobs\SendEmail;
use App\Mail\NotifMail;
use Illuminate\Http\Request;
use App\Models\{Cuti, Karyawan, User};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class CutiController extends Controller
{

    public function staff ()
    {

        $divisi_id = DB::table('divisi_user')
            ->where('user_id', auth()->id())
            ->first()
            ->divisi_id;
    
        $list_staff = DB::table('divisi_user')
            ->join('users', 'users.id', '=', 'divisi_user.user_id')
            ->where('divisi_user.divisi_id', $divisi_id)
            ->get()
            ->map(function($item, $key){
                if($item->status == 'staff'){
                    return $item->id;
                }else{
                    return 0;
                }
            });
          
        $cuti = Cuti::with('user')
            ->whereIn('user_id', $list_staff)
            ->orderBy('status', 'desc')
            ->get();

        return view('cuti.index', compact('cuti'));
    }

    public function manager ()
    {
    
        $list_staff = DB::table('divisi_user')
            ->join('users', 'users.id', '=', 'divisi_user.user_id')
            ->get()
            ->map(function($item, $key){
                if($item->status == 'manager'){
                    return $item->id;
                }else{
                    return 0;
                }
            });
          
        $cuti = Cuti::with('user')
            ->whereIn('user_id', $list_staff)
            ->orderBy('status', 'desc')
            ->get();

        return view('cuti.index', compact('cuti'));
    }
 

    public function show () {

    
        return view('cuti.show', [
            'cuti' => Cuti::where('user_id', auth()->id())->latest()->get()
        ]);
    }

    public function create ()
    {
        return view('cuti.create', [
            'user' => Karyawan::where('user_id', auth()->id())->first()
        ]);
    }
    
    public function store ()
    {
        $split = explode(' - ', request('tanggal_cuti'));
        

        // return $split;



        Cuti::create([
            'user_id' => auth()->id(),
            'jenis_cuti' => request('jenis_cuti'),
            'mulai_tanggal' => $split[0],
            'sampai_tanggal' => $split[0],
            'lama_cuti' => request('lama_cuti'),
            'is_approve' => '0',
            'keterangan_cuti' => request('keterangan') 
        ]);
        
        // $user = User::find(auth()->user()->parent_id);
        // SendEmail::dispatch($user->email, auth()->user()->name .'Mengajukan Cuti');

        // Mail::to($user->email)->send(new NotifMail(auth()->user()->name .'Mengajukan Cuti'));
        // return 'ok';
        session()->flash('success', 'Berhasil mengajukan cuti');

        return redirect()->route('cuti.show');

    }

    public function update ($id)
    {
        Cuti::where('id', $id)->update([
            'nama_atasan' => auth()->user()->name,
            'keterangan_atasan' => request('keterangan'),
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

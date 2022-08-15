<?php

namespace App\Http\Controllers;

use App\Events\NotifEvent;
use App\Events\NotificationsEvent;
use App\Jobs\SendEmail;
use App\Mail\NotifMail;
use Illuminate\Http\Request;
use App\Models\{Cuti, Karyawan, Kehadiran, User};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class CutiController extends Controller
{

    public function index ()
    {

        if (auth()->user()->hasRole('manager')) {
            $divisi = DB::table('divisi_user')->where('user_id', auth()->id())->first();
            $users = DB::table('divisi_user')->where('divisi_id', $divisi->divisi_id)->get();

            $cuti = Cuti::with('user')->whereIn('user_id', $users->pluck('user_id'))->get();
        } else {
            $cuti = Cuti::with('user')->latest()->get();
        }

        // return $cuti;
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
        

        Cuti::create([
            'user_id'           => auth()->id(),
            'jenis_cuti'        => request('jenis_cuti'),
            'mulai_tanggal'     => $split[0],
            'sampai_tanggal'    => $split[1],
            'lama_cuti'         => request('lama_cuti'),
            'is_approve'        => '0',
            'keterangan_cuti'   => request('keterangan') 
        ]);
        
        // $user = User::find(auth()->user()->parent_id);
        // SendEmail::dispatch($user->email, auth()->user()->name .'Mengajukan Cuti');

        // Mail::to($user->email)->send(new NotifMail(auth()->user()->name .'Mengajukan Cuti'));
        // return 'ok';;

        return redirect()->route('cuti.show')->with('success', 'Berhasil mengajukan cuti');

    }

    public function update ($id)
    {
        $cuti = Cuti::find($id);
        

        if(request('status') == 'accept'){
            NotifEvent::dispatch('Cuti anda disetujui', request('userId'));

            if ($cuti->status != 'accept') {
                Karyawan::where('user_id', request('userId'))->decrement('sisa_cuti', $cuti->lama_cuti);

                $kehadiran = [];

                $date = Carbon::create($cuti->mulai_tanggal);
                
                while($cuti->sampai_tanggal > $date){

                    $kehadiran[] = [
                        'user_id'       =>  request('userId'),
                        'type'          =>  'cuti',
                        'created_at'    => $date
                    ];

                    $date = Carbon::create($date->addDays(1));
                }

                Kehadiran::upsert($kehadiran,['user_id', 'type']);
            }
            
            $data = [
                'message' => 'Cuti anda disetujui oleh ' . auth()->user()->email
            ];
            session()->flash('success', "Berhasil menyetujui cuti");
        }elseif(request('status') == 'reject'){

            if($cuti->status == 'accept'){
                Karyawan::where('user_id', request('userId'))->increment('sisa_cuti', $cuti->lama_cuti);

                Kehadiran::whereDate('created_at', '>=', $cuti->mulai_tanggal)
                    ->whereDate('created_at', '<=', $cuti->sampai_tanggal)
                    ->delete();
            }

            NotifEvent::dispatch('Cuti anda ditolak', request('userId'));
            $data = [
                'message' => 'Cuti anda ditolak oleh' . auth()->user()->email
            ];

            session()->flash('success', "Berhasil menolak cuti");
            
        }



        $cuti->update([
            'nama_atasan'       => auth()->user()->name,
            'keterangan_atasan' => request('keterangan'),
            'status'            => request('status'),
        ]);

        Mail::to(request('userEmail'))->send(new NotifMail($data));
        
        return response()->json([
            'success' => true, 
        ]);
    }

    public function destroy ($id)
    {
        Cuti::where('id', $id)->delete();

        session()->flash('success', 'Berhasil menghapus cuti');

        return redirect()->route('cuti.show');
    }

    
}

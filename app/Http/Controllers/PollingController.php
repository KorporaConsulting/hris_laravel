<?php

namespace App\Http\Controllers;

use App\Models\JawabanPolling;
use App\Models\OpsiPolling;
use App\Models\Polling;
use Illuminate\Http\Request;

class PollingController extends Controller
{
    public function  index ()
    {
        return view('polling.index', [
            'pollings' => Polling::with('created_by')->get()
        ]);
    }

    public function create ()
    {
        return view('polling.create');
    }

    public function store ()
    {
        $polling = Polling::create([
            'user_id'   => auth()->id(),
            'date_start' => request('date_start'),
            'date_end' => request('date_end'),
            'judul'     => request('judul')
        ]);
        
        $opsiPolling = [];

        foreach (request('opsi') as $value) {
            $opsiPolling[] = [
                'polling_id'    => $polling->id,
                'opsi'         => $value
            ];
        }

        OpsiPolling::upsert($opsiPolling, ['polling_id', 'judul']);

        return redirect()->route('user.dashboard')->with('success', 'Berhasil membuat polling');
    }

    public function vote ()
    {
        $newUser = JawabanPolling::updateOrCreate([
            'user_id'   => auth()->id(),
            'polling_id' => request('polling_id')
        ], [
            'polling_id' => request('polling_id'),
            'opsi_id' => request('opsi_id'),
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil melakukan poling'
        ]);
    }

    public function show (Polling $polling)
    {

        $polling->load(['created_by', 'options' => function ($q) {
            $q->with('answers');  
        }]);

        return view('polling.show', compact('polling'));
    }

    public function edit (Polling $polling)
    {
        $polling->load('options');

        return view('polling.edit', compact('polling'));
    }

    public function update ($pollingId)
    {

        Polling::whereId($pollingId)->update(request(['judul', 'date_start', 'date_end']));

        OpsiPolling::where('polling_id', $pollingId)->delete();

        $option = [];

        foreach (request('opsi') as $value) {
            $option[] = [
                'polling_id'    => $pollingId,
                'opsi'          => $value
            ];
        }

        OpsiPolling::upsert($option, [
            'polling_id', 'opsi'
        ]);

        return redirect()->route('polling.index')->with('success', 'Berhasil mengupdate polling');
    }


    public function destroy ($pollingId)
    {
        Polling::whereId($pollingId)->delete();
        
        return redirect()->route('polling.index')->with('success', 'Berhasil menghapus Polling');
    }

    
}

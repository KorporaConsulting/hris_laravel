<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Carbon\Carbon;


class EventController extends Controller
{
    public function index ()
    {
        if (request()->ajax()) {

            $data = Event::whereDate('start', '>=', request('start'))
                ->whereDate('end',   '<=', request('end'))
                ->get(['id', 'title', 'start', 'end']);

            return response()->json($data);
        }

        return view('event.index');
    }

    public function create ()
    {
        return view('event.create');
    }

    public function action()
    {

        switch (request('type')) {
            case 'add':
                $event = Event::create([
                    'user_id' => auth()->id(),
                    'title' => request('title'),
                    'start' => request('start'),
                    'end' => request('end'),
                ]);

                return response()->json($event);
                break;

            case 'update':
                $event = Event::find(request()->id)->update([
                    'title' => request('title'),
                    'start' => request('start'),
                    'end' => request('end'),
                ]);

                return response()->json($event);
                break;

            case 'delete':
                $event = Event::find(request()->id)->delete();

                return response()->json($event);
                break;

            default:
                break;
        }
    }

    public function store ()
    {

        $data = [];

        foreach (request('days') as $key => $day) {

            $reminderDate = Helper::getDateByDayInWeek(request('date_start'), $day);;

            $start = strtotime(request('date_start'));
            $end = strtotime(request('date_end'));

            while ($start <= $end) {
                if (strtotime($reminderDate) < strtotime(request('date_start'))) {
                    $date = new Carbon($reminderDate);
                    $reminderDate = $date->addDays('7');
                    $start = strtotime($reminderDate);
                    continue;
                } else if (strtotime($reminderDate) > strtotime(request('date_end'))) {
                    continue;
                }

                $data [] = [
                    'user_id' => auth()->id(),
                    'title' => request('title'),
                    'description' => request('description'),
                    'start' => $reminderDate,
                    'end' => Carbon::create($reminderDate)->addDays(1)
                ];

                $date = new Carbon($reminderDate);
                $reminderDate = $date->addDays('7');
                $start = strtotime($reminderDate);
            }

        }
        // return $data;
        Event::upsert($data, [
            'user_id', 'title', 'description', 'start', 'end'
        ]);
        // return $data;
        // return Helper::getDateByDayInWeek('2020-10-10', 'tuesday');

        // return request()->all();
        return redirect()->route('event.index')->with('success', 'Berhasil membuat event');
    }
}

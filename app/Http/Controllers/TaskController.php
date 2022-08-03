<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index ($projectId)
    {

        if(request()->ajax()){

            $data = Board::with('tasks')
                ->where('project_id', $projectId)
                ->orderBy('order', 'asc')
                ->get();

            return response()->json($data);
        }

        $defaultTemplate = Board::where('project_id', $projectId)->get()->count();

        return view('task.index', compact('projectId', 'defaultTemplate'));
    }

    public function store ()
    {
        Task::create(request()->except('_token'));

        return response()->json([
            'success' => 'true'
        ]);

    }
    public function update($taskId){
        
        Task::where('id', $taskId)->update(request()->except('_token'));

        return response()->json([
            'success' => 'true'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function storeDefault($projectId)
    {
        Board::upsert([
            [
                'project_id' => $projectId,
                'name' => 'To Do',
                'class' => 'red'
            ],
            [
                'project_id' => $projectId,
                'name' => 'Working On',
                'class' => 'blue'
            ],
            [
                'project_id' => $projectId,
                'name' => 'Done',
                'class' => 'green'
            ]
        ], ['project_id', 'name', 'green']);

        return redirect()->route('project.task.index', $projectId)->with('success', 'Berhasil generate template default');
    }
}

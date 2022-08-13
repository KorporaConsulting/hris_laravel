<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoardController extends Controller
{
    public function storeDefault($projectId)
    {
        Board::upsert([
            [
                'project_id' => $projectId,
                'name' => 'To Do',
                'order' => 1,
                'class' => 'red'
            ],
            [
                'project_id' => $projectId,
                'name' => 'Working On',
                'order' => 2,
                'class' => 'blue'
            ],
            [
                'project_id' => $projectId,
                'name' => 'Done',
                'order' => 3,
                'class' => 'green'
            ]
        ], ['project_id', 'name', 'class']);

        return redirect()->route('project.task.index', $projectId)->with('success', 'Berhasil generate template default');
    }

    public function store ($projectId)
    {
        $data = request()->except('_token');
        $data['project_id'] = $projectId;

        Board::create($data);

        return response()->json([
            'success' => true,
        ]);

    }

    public function update ($projectId, $boardId)
    {

        if(request('type') == 'decrement'){
            DB::table('board')->where('order', '>=', request('lastOrder'))->decrement('order', 1);
        }else if(request('type') == 'increment'){
            DB::table('board')->where('order', '<=', request('lastOrder'))->increment('order', 1);
        }else{
            return response()->json([
                'success' => false
            ]);
        }

        $board = Board::where('id', $boardId)->update(['order' => request('order')]);

        return response()->json([
            'success' => true
        ]);
    }


    public function destroy($projectId, $boardId){

        $where = [
            'id'            => $boardId,
            'project_id'    => $projectId
        ];

        Board::where($where)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengahpus board'
        ]);

    }
}

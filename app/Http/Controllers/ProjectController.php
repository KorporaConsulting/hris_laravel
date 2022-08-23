<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index ()
    {
        $user_id = auth()->id();

        if (request()->has('user_id')) {
            $user_id = request('user_id');
        }
        
        $projects = Project::where('user_id', $user_id)->get();

        return view('project.index', compact('projects'));
    }

    public function store ()
    {
        $data               = request()->except('_token');
        $data['user_id']    = auth()->id();
        $data['status']     = 0;

        Project::create($data);

        return response()->json([
            'success' => true
        ]);
    }

    public function destroy ($projectId)
    {
        Project::whereId($projectId)->delete();
        
        return redirect()->route('project.index')->with('success', "Berhasil menghapus project");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index ()
    {
        $projects = Project::where('user_id', auth()->id())->get();

        return view('project.index', compact('projects'));
    }

    public function store ()
    {
        $data = request()->except('_token');
        $data['user_id'] = auth()->id();
        $data['status'] = 0;
        Project::create($data);

        return response()->json([
            'success' => true
        ]);
    }
}

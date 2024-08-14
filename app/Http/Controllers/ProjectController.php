<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function api_view()
    {
        $project = Project::all();

        return response()->json($project);
    }

    public function api_create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_name' => 'required|string|max:255',
            'project_description' => 'required|string',
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => 'Beberapa input kosong atau invalid'], 422);
        }

        $project = new Project();
        $project->project_name = $request->project_name;
        $project->project_description = $request->project_description;
        $project->save();

        return response()->json([
            'message' => 'Data Project berhasil ditambahkan',
            'Project' => $project
        ]);
    }

    public function api_update(Project $project, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_name' => 'sometimes|string|max:255',
            'project_description' => 'sometimes|string',
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => 'Beberapa input kosong atau invalid'], 422);
        }

        if($request->has('project_name'))
        {
            $project->project_name = $request->project_name;
        }

        if($request->has('project_description'))
        {
            $project->project_description = $request->project_description;
        }

        $project->save();

        return response()->json([
            'message' => 'Data Project berhasil diubah',
            'Project' => $project
        ]);
    }

    public function api_delete(Project $project)
    {
        $project->delete();

        return response()->json([
            'message' => 'Data Project berhasil dihapus']);
    }
}

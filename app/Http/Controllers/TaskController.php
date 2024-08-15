<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function api_view()
    {
        $tasks = Task::with(['project', 'user'])->get();

        return response()->json($tasks);
    }

    public function api_create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_name' => 'required|string|max:255',
            'task_description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,project_id',
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => 'Beberapa input kosong atau invalid'], 422);
        }

        $task = new Task();

        $task->task_name = $request->task_name;
        $task->task_description = $request->task_description;
        $task->user_id = $request->user_id;
        $task->project_id = $request->project_id;
        $task->save();

        return response()->json([
            'message' => 'Data Project berhasil ditambahkan',
            'Task' => $task
        ]);
    }

    public function api_update(Task $task, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_name' => 'sometimes|string|max:255',
            'task_description' => 'sometimes|string',
            'user_id' => 'sometimes|exists:users,id',
            'project_id' => 'sometimes|exists:projects,project_id',
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => 'Beberapa input kosong atau invalid'], 422);
        }

        if($request->has('task_name'))
        {
            $task->task_name = $request->task_name;
        }

        if($request->has('task_description'))
        {
            $task->task_description = $request->task_description;
        }

        if($request->has('user_id'))
        {
            $task->user_id = $request->user_id;
        }

        if($request->has('project_id'))
        {
            $task->project_id = $request->project_id;
        }

        $task->save();

        return response()->json([
            'message' => 'Data Project berhasil diubah',
            'Task' => $task
        ]);
    }

    public function api_delete(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'Data Project berhasil dihapus',
        ]);
    }
}


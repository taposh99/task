<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $data = Task::latest()->get();

        return view('index', [
            'allDatas' => $data,
        ]);
    }

    // store data

    public function store(Request $request)
    {

        $request->validate([
            'task_name' => 'required',

        ]);

        Task::create([
            'task_name' => $request->task_name,

        ]);

        return response()->json(['message' => 'Product saved successfully']);
    }

    // edit data

    public function edit($id)
    {
        $data = Task::findOrFail($id);
        return response()->json($data);
    }

    // update data

    public function update(Request $request, $id)
    {
       


        $home = Task::findOrFail($id)->update([
            'task_name' => $request->task_name,
           
        ]);

        return response()->json($home);
    }

    // delete data

    public function destroy(Request $request)
    {
        Task::destroy($request->data_id);

        return back()->with('success', 'Deleted successfully');
    }
}

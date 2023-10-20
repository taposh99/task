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

        return back()->with('success', 'Data created successfully');
    }

    // edit data

    public function edit($id)
    {
        $home = Task::find($id);
        return view('edit', compact('home'));
    }

    // update data

    public function update(Request $request)
    {
        $home = Task::find($request->data_id);

        $home->update([
            'task_name' => $request->task_name,

        ]);

        return redirect('dashboard')->with('success', 'successfully update');
    }

    // delete data

    public function destroy(Request $request)
    {
        Task::destroy($request->data_id);

        return back()->with('success', 'Deleted successfully');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Carbon;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Task::orderBy('created_at', "DESC")->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newTask = new Task;
        $newTask->name  = $request->task['name'];
        $newTask->save();

        return $newTask;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $existingTask = Task::find($id);

        if ($existingTask) {
            $existingTask->completed = $request->task['completed'];
            $existingTask->completed_at = $request->task['completed'] ? Carbon::now() : null;

            if ($existingTask->name != "" && $existingTask->name != $request->task['name']) {
                $existingTask->name = $request->task['name'];
            }

            $existingTask->save();

            return $existingTask;
        }

        return $this->encode_error_message("Task not found");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existingTask = Task::find($id);

        if ($existingTask) {
            $existingTask->delete();

            return "Task ${id} deleted";
        }

        $this->encode_error_message("Task not found");
    }

    public function encode_error_message($message = "")
    {
        $error = array(
            'error' => true,
            'message' => $message
        );

        return json_encode($error);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{

    /**
     * This function is used to render the todo list view
     * 
     * @return view
    */
    public function index() 
    {
        return view('home');
    }


    /**
     * This function is used to fetch all tasks  
     * 
     * @param Illuminate\Http\Request
     * @return Json
    */
    public function taskList(Request $request, $type) 
    {
        try {
            $columns    = ["id", "task"];
            
            $order      = $columns[intval($request->input('order.0.column'))];
            $dir        = $request->input('order.0.dir');
            $start      = $request->input('start');
            $limit      = $request->input('length');

            $query = Task::where('task', '!=', null);

            if ($type == 'active') {
                $query = $query->where('status', 0);
            }
            
            if (!empty($request->input('search.value'))) {
                $search = $request->input('search.value');

                $query = $query->where('task', "like", "%$search%")
                ->orWhere('email', "like", "%$search%")
                ->orWhere('address', "like", "%$search%");                
            }

            $totalRecords = $query->count();
            $query = $query->offset($start)->limit($limit)->orderBy($order, $dir);

            $tasks = $query->get();

            $jsonResponse = array(
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => intval($totalRecords),
                "recordsFiltered" => intval($totalRecords),
                "data"            => $tasks,
            );
            
            echo json_encode($jsonResponse);

        } catch (\Throwable $th) {
            Log::error('Controller Name :' . __METHOD__ . 'Error : ' . $th->getMessage());
            return redirect()->back()->with('flashError', $th->getMessage());
        }
    }


    /**
     * This function is used to add a new task to the tasks table
     * 
     * @param Illuminate\Http\Request
     * @return Json
    */
    public function addTask(Request $request)
    {
        try {
            $request->validate([
                'task' => ['required', 'unique:tasks,task', 'min:3', 'max:240'],
            ], [
                'task.unique' => 'Same Task already exist.'
            ]);

            $task = Task::create([
                'task' => $request->task
            ]);

            if ($task) {
                $response = array(
                    'status' => true,
                    'message' => 'Task added successfully.'
                );
                return response()->json($response);
            }
            else {
                $response = array(
                    'status' => false,
                    'message' => 'Failed to add Task.'
                );
                return response()->json($response);
            }

        } catch (\Throwable $th) {
            Log::error('Controller Name :' . __METHOD__ . 'Error : ' . $th->getMessage());

            $response = array(
                'status' => false,
                'message' => $th->getMessage()
            );
            return response()->json($response);
        }
    }


    /**
     * This function is used to complete a task
     * 
     * @param int $id
     * @return Json
    */
    public function completeTask($id)
    {
        try {
            $task = Task::find($id);
            $task = $task->update(['status' => 1]);

            if ($task) {
                $response = array(
                    'status' => true,
                    'message' => 'Task completed successfully.'
                );
                return response()->json($response);
            }
            else {
                $response = array(
                    'status' => false,
                    'message' => 'Failed to complete Task.'
                );
                return response()->json($response);
            }

        } catch (\Throwable $th) {
            Log::error('Controller Name :' . __METHOD__ . 'Error : ' . $th->getMessage());

            $response = array(
                'status' => false,
                'message' => $th->getMessage()
            );
            return response()->json($response);
        }
    }


    /**
     * This function is used to permanently delete a task
     * 
     * @param int $id
     * @return Json
    */
    public function deleteTask($id)
    {
        try {
            $task = Task::find($id);
            $task = $task->forceDelete($id);

            if ($task) {
                $response = array(
                    'status' => true,
                    'message' => 'Task deleted successfully.'
                );
                return response()->json($response);
            }
            else {
                $response = array(
                    'status' => false,
                    'message' => 'Failed to delete Task.'
                );
                return response()->json($response);
            }

        } catch (\Throwable $th) {
            Log::error('Controller Name :' . __METHOD__ . 'Error : ' . $th->getMessage());

            $response = array(
                'status' => false,
                'message' => $th->getMessage()
            );
            return response()->json($response);
        }
    }
}

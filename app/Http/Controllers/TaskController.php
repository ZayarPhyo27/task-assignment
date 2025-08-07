<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use DataTables;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = new Task();
            // $data = $data->withTrashed();

            if($request->status!=null)
            $data = $data->where('tasks.status',$request->status);

            $data = $data->latest()->get(['tasks.*']);


            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = "";
                            // if($row->status == config("web_constant.task_status.Pending"))
                            $btn = '<a rel="tooltip" class="btn btn-success btn-link mr-2" href="tasks/'.$row->id.'/edit"  data-original-title="" title="">
                            <i class="material-icons">edit</i>
                            <div class="ripple-container"></div>
                            </a>';

                            $btn .= '<a rel="tooltip" class="btn btn-danger btn-link delete-data" href="#" action="/tasks/'.$row->id.'" data-original-title="" title="">
                            <i class="material-icons">close</i>
                            <div class="ripple-container"></div>
                            </a>';

                        return $btn;
                    })
                    ->addColumn('status', function ($row) {
                        return "<span class='badge badge-sm bg-gradient-" . config("web_constant.get_task_status.$row->status") . "'>" . config("web_constant.get_task_status.$row->status") . "</span>";
                    })

                    ->rawColumns(['action','status'])
                    ->make(true);
        }

        return view('task-management.index',[
                   'route' => 'tasks',
                   'keyword' => 'Task List'
               ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task();
        return view('task-management.create',[
                    'task' => $task,
                    'route' => 'tasks',
                    'keyword' => 'Task Create'
                ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => ['required'],
            'due_date' => ['required'],
            'description' => ['required'],
        ]);


        $result = true;
        DB::beginTransaction();
        try {
             $data['title'] = $request->title;
             $data['due_date'] = $request->due_date;
             $data['description'] = $request->description;
             $data['status'] = config('web_constant.task_status.Pending');

             $task = Task::create($data);

             if(!$task){
                 $result = false;
                 DB::rollback();
             }

             DB::commit();
        } catch (\Throwable $th) {
            dd($th);
        }

        if($result){
            session(['success' => 'Task was created successfully!']);
        }else{
            session(['error' => 'Task can not create!']);
        }

        return redirect('/tasks');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $task = Task::find($id);

        return view('task-management.update',[
                    'task' => $task,
                    'keyword' => 'Update Task',
                    'route' => 'tasks',
                ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required'],
            'due_date' => ['required'],
            'description' => ['required'],
        ]);

        $task = Task::find($id);

        DB::beginTransaction();
        try {
             $data['title'] = $request->title;
             $data['due_date'] = $request->due_date;
             $data['description'] = $request->description;
             $ans = $task->update($data);

             if(!$ans){
                 $result = false;
                 DB::rollback();
             }

             DB::commit();
        } catch (\Throwable $th) {
            dd($th);
        }


        return redirect('tasks');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        DB::beginTransaction();
        try {
             Task::where('id',$id)
                        ->delete();

             DB::commit();
        } catch (\Throwable $th) {
            dd($th);
        }

        return redirect('tasks');
    }


    public function doingState($id)
    {

        $task = Task::find($id);

        if($task){
            DB::beginTransaction();
        try {

             $data['status'] = config('web_constant.task_status.Doing');
             $ans = $task->update($data);

             if(!$ans){

                 DB::rollback();
                 $msg = "Cant change state.";
                 $code = 500;
             }

             $msg = "Change state to doing state sucessfully.";
             $code = 200;
             DB::commit();
            } catch (\Throwable $th) {
                dd($th);
            }
        }
        else{
            $ans = false;
            $code = 404;
            $msg = "Task data can't found.";
        }

         $headers['status'] = $ans;
         $headers['code'] = $code;
         $headers['message'] = $msg;

         return $headers;

    }

    public function completeState($id)
    {
        $task = Task::find($id);

        if($task){
            DB::beginTransaction();
        try {
             $data['status'] = config('web_constant.task_status.Complete');
             $ans = $task->update($data);

             if(!$ans){

                 DB::rollback();
                 $msg = "Cant change state.";
                 $code = 500;
             }
             $msg = "Change state to doing state sucessfully.";
             $code = 200;

             DB::commit();
            } catch (\Throwable $th) {
                dd($th);
            }
        }
        else{
            $ans = false;
            $code = 404;
            $msg = "Task data can't found.";
        }

        $headers['status'] = $ans;
        $headers['code'] = $code;
        $headers['message'] = $msg;

        return $headers;

    }
}

<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use DataTables;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = new User();
            // $data = $data->withTrashed();

            if($request->status!=null)
            $data = $data->where('users.status',$request->status);

            $data = $data->latest()->get(['users.*']);


            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = "";


                            if($row->status == config("web_constant.user_status.Pending"))
                            {

                                // $btn = '<a rel="tooltip" class="btn btn-success btn-link mr-2" href="users/'.$row->id.'/edit"  data-original-title="" title="">
                                // <i class="material-icons">check</i>
                                // <div class="ripple-container"></div>
                                // </a>';


                            }

                               $btn .= '<a rel="tooltip" class="btn btn-info mr-2" href="users/'.$row->id.'/edit"  data-original-title="" title="">
                                <i class="material-icons">edit</i>
                                <div class="ripple-container"></div>
                                </a>';

                            $btn .= '<a rel="tooltip" class="btn btn-danger btn-link delete-data" href="#" action="/users/'.$row->id.'" data-original-title="" title="">
                            <i class="material-icons">close</i>
                            <div class="ripple-container"></div>
                            </a>';



                        return $btn;
                    })
                    // ->addColumn('status', function ($row) {
                    //     return "<span class='badge badge-sm bg-gradient-" . config("web_constant.get_user_status.$row->status") . "'>" . config("web_constant.get_user_status.$row->status") . "</span>";
                    // })

                    // ->rawColumns(['action','status'])

                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('user-management.index',[
                   'route' => 'users',
                   'keyword' => 'User List'
               ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        return view('user-management.create',[
                    'user' => $user,
                    'route' => 'users',
                    'keyword' => 'User Create'
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);


        $result = true;
        DB::beginTransaction();
        try {
             $data['name'] = $request->name;
             $data['email'] = $request->email;
             $data['password'] = Hash::make($request->password);
             $data['status'] = config('web_constant.user_status.Pending');

             $user = User::create($data);

             if(!$user){
                 $result = false;
                 DB::rollback();
             }

             DB::commit();
        } catch (\Throwable $th) {
            dd($th);
        }

        if($result){
            session(['success' => 'User was created successfully!']);
        }else{
            session(['error' => 'User can not create!']);
        }

        return redirect('/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
         $user = User::find($id);

        return view('user-management.update',[
                    'user' => $user,
                    'keyword' => 'Update User',
                    'route' => 'users',
                ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::find($id);

        DB::beginTransaction();
        try {
             $data['name'] = $request->name;
             $data['email'] = $request->email;
             $data['password'] = Hash::make($request->password);
             $ans = $user->update($data);

             if(!$ans){
                 $result = false;
                 DB::rollback();
             }

             DB::commit();
        } catch (\Throwable $th) {
            dd($th);
        }


        return redirect('users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
         DB::beginTransaction();
        try {
             User::where('id',$id)
                        ->delete();

             DB::commit();
        } catch (\Throwable $th) {
            dd($th);
        }

        return redirect('users');
    }
}

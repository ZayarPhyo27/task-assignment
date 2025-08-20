<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use DataTables;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = new Product();
            // $data = $data->withTrashed();

            if($request->status!=null)
            $data = $data->where('products.status',$request->status);

            $data = $data->latest()->get(['products.*']);


            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = "";

                                $btn = '<a rel="tooltip" class="btn btn-success btn-link mr-2" href="products/'.$row->id.'/edit"  data-original-title="" title="">
                                <i class="material-icons">edit</i>
                                <div class="ripple-container"></div>
                                </a>';

                            $btn .= '<a rel="tooltip" class="btn btn-danger btn-link delete-data" href="#" action="/products/'.$row->id.'" data-original-title="" title="">
                            <i class="material-icons">close</i>
                            <div class="ripple-container"></div>
                            </a>';

                        return $btn;
                    })
                    ->addColumn('status', function ($row) {
                        return "<span class='badge badge-sm bg-gradient-" . config("web_constant.get_product_status.$row->status") . "'>" . config("web_constant.get_product_status.$row->status") . "</span>";
                    })
                    ->addColumn('image', function ($row) {
                    if ($row->image) {
                        $url = asset('storage/' . $row->image);
                        return "<img src='$url' alt='Image' width='50' height='50' style='object-fit:cover; border-radius:4px;'>";
                    } else {
                        return "<span class='text-muted'>No image</span>";
                    }
                })

                    ->rawColumns(['action','status','image'])
                    ->make(true);
        }

        return view('product-management.index',[
                   'route' => 'products',
                   'keyword' => 'Product List'
               ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Product();
        return view('product-management.create',[
                    'product' => $product,
                    'route' => 'products',
                    'keyword' => 'Product Create'
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

          $data = $request->all();

        $request->validate([
            'name' => 'required|string',
            'qty' => 'required|integer',
            'color' => 'required|string',
            'size' => 'required|integer',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

         // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }


        $result = true;
        DB::beginTransaction();
        try {
            //  $data['title'] = $request->title;
            //  $data['due_date'] = $request->due_date;
            //  $data['description'] = $request->description;
             $data['status'] = config('web_constant.product_status.Pending');

             $product = Product::create($data);

             if(!$product){
                 $result = false;
                 DB::rollback();
             }

             DB::commit();
        } catch (\Throwable $th) {
            dd($th);
        }

        if($result){
            session(['success' => 'Product was created successfully!']);
        }else{
            session(['error' => 'Product can not create!']);
        }

        return redirect('/products');
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
        $product = Product::find($id);

        return view('product-management.update',[
                    'product' => $product,
                    'keyword' => 'Update Product',
                    'route' => 'products',
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
         $data = $request->all();

        $request->validate([
            'name' => 'required|string',
            'qty' => 'required|string',
            'color' => 'required|string',
            'size' => 'required|integer',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);

           // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        $product = Product::find($id);

        DB::beginTransaction();
        try {

             $ans = $product->update($data);

             if(!$ans){
                 $result = false;
                 DB::rollback();
             }

             DB::commit();
        } catch (\Throwable $th) {
            dd($th);
        }


        return redirect('products');
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
             Product::where('id',$id)
                        ->delete();

             DB::commit();
        } catch (\Throwable $th) {
            dd($th);
        }

        return redirect('products');
    }

}

<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use DataTables;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Mail\TestMail;



class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = new Order();
            // $data = $data->withTrashed();

            $data = Order::with('products');
            if($request->status!=null)
            $data = $data->where('orders.status',$request->status);

            $data = $data->latest()->get(['orders.*']);



            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = "";
                            if($row->status == config("web_constant.order_status.Pending"))
                              $btn = '<a rel="tooltip" class="btn btn-warning btn-link mr-2" href="orders/'.$row->id.'/delivery"  data-original-title="" title="">
                                <i class="material-icons">local_shipping</i>
                                <div class="ripple-container"></div>
                                </a>';

                            if($row->status == config("web_constant.order_status.Delivering"))
                                $btn = '<a rel="tooltip" class="btn btn-success btn-link mr-2" href="orders/'.$row->id.'/complete"  data-original-title="" title="">
                            <i class="material-icons">check</i>
                            <div class="ripple-container"></div>
                            </a>';

                        //    if($row->status == config("web_constant.order_status.Complete") ||  config("web_constant.order_status.Pending "))
                             $btn .= '<a rel="tooltip" class="btn btn-info active btn-link mr-2" href="orders/'.$row->id.'"  data-original-title="" title="">
                            <i class="material-icons">search</i>
                            <div class="ripple-container"></div>
                            </a>';

                             $btn .= '<a rel="tooltip" class="btn btn-danger btn-link delete-data" href="#" action="/orders/'.$row->id.'" data-original-title="" title="">
                            <i class="material-icons">close</i>
                            <div class="ripple-container"></div>
                            </a>';

                        return $btn;
                    })
                    ->addColumn('status', function ($row) {
                        return "<span class='badge badge-sm bg-gradient-" . config("web_constant.get_order_status.$row->status") . "'>" . config("web_constant.get_order_status.$row->status") . "</span>";
                    })
                     ->addColumn('order_id', function ($row) {
                        return 'ORD_' . str_pad($row->id, 4, '0', STR_PAD_LEFT);
                    })
                    ->editColumn('created_at', function ($row) {
                        return $row->created_at->format('d M Y');
                    })

                    ->rawColumns(['action','status','created_at'])
                    ->make(true);
        }

        return view('order-management.index',[
                   'route' => 'orders',
                   'keyword' => 'Order List'
               ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $order = new Order();
        return view('order-management.create',[
                    'order' => $order,
                    'route' => 'orders',
                    'keyword' => 'Order Create'
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

         $validated = $request->validate([
                'customer_name' => 'required|string|max:255',
                'gmail' => 'required|email',
                'customer_phone' => [
                    'required',
                  'regex:/^(09|01)\d{7,9}$/',
                ],
                'address' => 'required|string|max:500',
                'payment_method' => 'required|string',
                'cart_data' => 'required',
                'total' => 'required|numeric',
        ]);

        $cartItems = json_decode($validated['cart_data'], true);

        if (!$cartItems || !is_array($cartItems)) {
            return back()->withErrors(['cart_data' => 'Invalid cart data']);
        }

        $result = true;
        DB::beginTransaction();
        try {

            $order = Order::create([
                'customer_name'   => $validated['customer_name'],
                'gmail'           => $validated['gmail'],
                'customer_address'=> $request->input('address'),
                'customer_phone'  => $request->input('customer_phone'),
                'payment_method' => $validated['payment_method'],
                'total'          => $validated['total'],
            ]);

            $orderId = 'ORD_' . str_pad($order->id, 4, '0', STR_PAD_LEFT);

             foreach ($cartItems as $item) {

                 OrderProduct::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item['product_id'] ?? null, // if available
                    'product_name' => $item['name'],
                    'price'        => $item['price'],
                    'quantity'     => $item['quantity'],
                    'image'        => $item['image'] ?? null,
                ]);

                if (!empty($item['product_id'])) {
                    $product = Product::find($item['product_id']);
                    if ($product && $product->qty > 0) {
                        $product->decrement('qty', 1); // reduces qty by 1
                    }
                }

            }

             if(!$order){
                 $result = false;
                 DB::rollback();
             }

             DB::commit();
        } catch (\Throwable $th) {
            dd($th);
        }

        if($result){
            Mail::to($validated['gmail'])->send(new TestMail([
            'subject'        => 'Order Confirmation',
            'order_id'        => $orderId,
            'customer_name'  => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'gmail'          => $request->gmail,
            'address'        => $request->address,
            'total'          => $request->total,
        ]));

            session(['success' => 'Order was created successfully!']);
        }else{
            session(['error' => 'Order can not create!']);
        }

        return redirect('/website');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $Order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order,$id)
    {
         $order = Order::find($id);

    if (!$order) {
        abort(404, 'Order not found');
    }

    // Load related orderProducts
    $orderProducts = $order->orderProducts;

        return view('order-management.show',[
                    'order' => $order,
                    'keyword' => 'Order Details',
                    'route' => 'orders',
                ]);
    }


    public function complete($id)
    {
        $order = Order::find($id);

        $data['status'] = 3;

        $ans = $order->update($data);

          return redirect('/orders');


    }

    public function deliver($id)
    {
        $order = Order::find($id);

        $data['status'] = 2;

        $ans = $order->update($data);

          return redirect('/orders');


    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $order = Order::find($id);

        return view('order-management.update',[
                    'order' => $order,
                    'keyword' => 'Update Order',
                    'route' => 'orders',
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

        $order = Order::find($id);

        DB::beginTransaction();
        try {
             $data['title'] = $request->title;
             $data['due_date'] = $request->due_date;
             $data['description'] = $request->description;
             $ans = $order->update($data);

             if(!$ans){
                 $result = false;
                 DB::rollback();
             }

             DB::commit();
        } catch (\Throwable $th) {
            dd($th);
        }


        return redirect('orders');
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
             Order::where('id',$id)
                        ->delete();

             DB::commit();
        } catch (\Throwable $th) {
            dd($th);
        }

        return redirect('orders');
    }


    public function doingState($id)
    {

        $task = Task::find($id);

        if($task){
            DB::beginTransaction();
        try {

             $data['status'] = config('web_constant.order_status.Doing');
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
             $data['status'] = config('web_constant.order_status.Complete');
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

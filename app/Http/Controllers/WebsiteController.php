<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use DataTables;
use App\Models\Task;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::all(); // or with pagination
        return view('website.index', compact('products'));
    }

    public function shoppingCart(Request $request)
    {
        $products = Product::all(); // or with pagination
        return view('website.shopping-cart', compact('products'));
    }



}

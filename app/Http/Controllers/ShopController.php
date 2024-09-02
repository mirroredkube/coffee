<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all products from the database
        $products = Product::all();

        // Return the view with the products
        return view('shop', ['products' => $products]);
    }
}

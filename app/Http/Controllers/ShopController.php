<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories=Category::all();
        if(request()->category){
            $products=Product::with('categories')->whereHas('categories',function($query){
                $query->where('slug',request()->category);

            });
            $categoryName=optional(Category::where('slug',request()->category)->first())->name;
       
        }else{
             $products = Product::where('featured',true);
             $categoryName="Featured";

        }
        if(request()->sort=="low_high"){
            $products=$products->orderBy('price','ASC')->paginate(9);
        }elseif(request()->sort=="high_low"){
            $products=$products->orderBy('price','DESC')->paginate(9);
        }else{
            $products=$products->paginate(9);
        }

        return view('shop')->with(['products'=> $products,
            'categoryName'=>$categoryName,
            'categories'=>$categories

    ]);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $mightAlsoLike = Product::where('slug', '!=', $slug)->mightAlsoLike()->get();

        return view('product')->with([
            'product' => $product,
            'mightAlsoLike' => $mightAlsoLike,
        ]);
    }
}

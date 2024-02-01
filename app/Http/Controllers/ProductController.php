<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartInProduct;
use App\Models\Cate;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function home(){
        try {
            $product = Product::join('categories', 'categories.id', '=' , 'products.id_cate')->select('products.*','categories.name as cate_name')->get();
        
        return view('client.homepage',compact('product'));
        }catch(Exception $e){
            dd($e->getMessage());
        };
    }
    public function detail(Request $request, $id)
{
    try {
        $user_id = auth()->id();
        $data = Product::find($id);
        $user = User::find($user_id);
        $categories = Category::pluck('name', 'id');
        
      
        $cart = Cart::where('id_user', $user_id)->get();
        
        if ($request->isMethod('post')) {
            if($user_id != null){

                if ($cart->isEmpty()) {
                    $newCart = new Cart();
                    $newCart->id_user = $user_id;
                    $newCart->id_product = $data->id;
                    $newCart->save();
                    $cart_id = $newCart->id;
                } else {
                    $cart_id = $cart->first()->id;
                }
    
                
                $CartPR = new CartInProduct();
                $CartPR->product_id = $data->id;
                $CartPR->user_id = $user->id;
                $CartPR->cart_id = $cart_id;
                $CartPR->save();
    
                return redirect(route('cart'));
            }else{
                return redirect(route('login'));
            }
        }

        return view('client.detail', compact('data', 'categories'));
    } catch (Exception $e) {
        dd($e->getMessage());
    }
}

    public function list(){
        try{
            $product = Product::join('categories', 'categories.id', '=' , 'products.id_cate')->select('products.*','categories.name as cate_name')->get();
        
        return view('admin.product.list',compact('product'));
        }catch(Exception $e){
            dd($e->getMessage());
        }
    }
    public function create(Request $request){
        try{
            $cate = DB::table('categories')->get();
       if($request->post()){
            $request->validate([
                'name' => ['required','unique:products','max:225','min:3'],
                'price' => ['required','numeric'],
            ]);
            $product = new Product();
            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->quantity = $request->quantity;
            $product->id_cate = $request->id_cate;
            $img = $request->file('img');
            $file_name = $img->getClientOriginalName();
            $product->img = $file_name;
            $img->move('image',$file_name);
            $product->save();
            
        return redirect(route('product.list'));
       }
        return view('admin.product.create',compact('cate'));
        }catch(Exception $e){
            dd($e->getMessage());
        }
    }
    public function update(Request $request,$id){
        try{
            $productUpdate = Product::find($id);
        
        $cate =  $cate = DB::table('categories')->get();
        if($request->post()){
            $request->validate([
                'name' => ['required','max:255','min:3'],
                'price' => ['required','numeric'],
                'description' => ['min:3'],
                
            ]);
            $productUpdate->name = $request->name;
            $productUpdate->price = $request->price;
            $productUpdate->description = $request->description;
            $productUpdate->quantity = $request->quantity;
            $productUpdate->id_cate = $request->id_cate;
            if($request->file('img')){
                $img = $request->file('img');
            $file_name = $img->getClientOriginalName();
            $productUpdate->img = $file_name;
            $img->move('image',$file_name);
            if(File::exists($file_name)){
                File::delete($file_name);
            }
            }else{
                $productUpdate->img = $productUpdate->img;
            }
           
            $productUpdate->save();
            return redirect(route('product.list'));
        }
    return view('admin.product.edit',compact('productUpdate','cate'));
        }catch(Exception $e){
            dd($e->getMessage());
        }
    }
    public function delete($id){
       try{
        $datadlt = Product::find($id);
        $img_path = public_path('image/' . $datadlt->img);
        if(File::exists($img_path)){
            File::delete($img_path);
        }
        $datadlt->delete();
        return redirect(route('product.list'));
       }catch(Exception $e){
        dd($e->getMessage());
       }
    }
    
}

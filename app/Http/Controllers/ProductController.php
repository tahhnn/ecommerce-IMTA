<?php

namespace App\Http\Controllers;

use App\Models\Cate;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function home(){
        $product = Product::join('categories', 'categories.id', '=' , 'products.id_cate')->select('products.*','categories.name as cate_name')->get();
        
        return view('client.homepage',compact('product'));
    }
    public function detail(Request $request, $id)
    {
        $data = Product::find($id);
        
        $categories = Category::pluck('name', 'id');
        return view('client.detail', compact('data' ,'categories')); 
    }
    public function list(){
        $product = Product::join('categories', 'categories.id', '=' , 'products.id_cate')->select('products.*','categories.name as cate_name')->get();
        
        return view('admin.product.list',compact('product'));
    }
    public function create(Request $request){
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
    }
    public function update(Request $request,$id){
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

            }else{
                $productUpdate->img = $request->oldImg;
            }
           
            $productUpdate->save();
            return redirect(route('product.list'));
        }
    return view('admin.product.edit',compact('productUpdate','cate'));
    }
    public function delete($id){
        $datadlt = Product::find($id);
        $img_path = public_path('image/' . $datadlt->img);
        if(File::exists($img_path)){
            File::delete($img_path);
        }
        $datadlt->delete();
        return redirect(route('product.list'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartInProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // cart trong admin
    public function getAllCart(){
      
        
        $cart = Cart::join('products', 'products.id', '=', 'carts.id_product')
            ->join('users', 'users.id', '=', 'carts.id_user')
            ->select('carts.*', 'users.name as user_name', 'products.name as product_name')
            ->get();
           
        return view('admin.cart.list',compact('cart'));
    }
    public function getCart(){
        $user_id = auth()->id();
        $cartinPR = DB::table('cart_in_product')
        ->join('products', 'products.id', '=', 'cart_in_product.product_id')
        ->join('users', 'users.id', '=', 'cart_in_product.user_id')

        ->select('cart_in_product.*', 'products.name as product_name' , 'products.price as product_price')->where('cart_in_product.user_id', '=', $user_id)
        ->get();
    
        return view('client.cart',compact('cartinPR'));
    }

    public function getCartAdmin(){
        $cartinPR = DB::table('cart_in_product')
        ->join('products', 'products.id', '=', 'cart_in_product.product_id')
        ->join('users', 'users.id', '=', 'cart_in_product.user_id')
        ->join('carts', 'carts.id', '=', 'cart_in_product.cart_id')
        ->select('cart_in_product.*', 'products.name as product_name' , 'products.price as product_price')
        ->get();
    
        return view('admin.cart.carDetail',compact('cartinPR'));
    }


    public function deleteCart($id){
        
        $cart_delete = DB::table('cart_in_product')->where('id','=', $id);
        $cart_delete->delete();
        return redirect(route('cart'));
    }
    public function countCart($id){
        $_SESSION['count_cart'] = DB::table('cart')->where('id_user', '=', $id)->count();
        return view('',[
            'count_cart' => $_SESSION['count_cart'],
        ]);
    }
}

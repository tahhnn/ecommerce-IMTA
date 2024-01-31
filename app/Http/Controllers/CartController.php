<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartInProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $cartinPR = DB::table('cartinproduct')
        ->join('products', 'products.id', '=', 'cartinproduct.product_id')
        ->join('users', 'users.id', '=', 'cartinproduct.user_id')
        ->join('carts', 'carts.id', '=', 'cartinproduct.cart_id')
        ->select('cartinproduct.*', 'products.name as product_name' , 'products.price as product_price')
        ->get();
    
        return view('admin.cart.carDetail',compact('cartinPR'));
    }
    public function deleteCart($id){
        $cart_delete = Cart::find($id);
        $cart_delete->delete();
        return route(redirect(''));
    }
    public function countCart($id){
        $_SESSION['count_cart'] = DB::table('cart')->where('id_user', '=', $id)->count();
        return view('',[
            'count_cart' => $_SESSION['count_cart'],
        ]);
    }
}

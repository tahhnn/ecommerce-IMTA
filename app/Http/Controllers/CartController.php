<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // cart trong admin
    public function getAllCart(){
        $cart = Cart::join('products', 'products.id', '=', 'cart.id_product')
            ->join('users', 'users.id', '=', 'cart.id_user')
            ->select('cart.*', 'users.name as user_name', 'products.name as product_name')
            ->get();
        return view('admin.cart.list',compact('cart'));
    }
    public function getCart(){
        $_SESSION['carts'] = Cart::where('id_user',$_SESSION['id'])->get();
        $cart = $_SESSION['carts'];
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

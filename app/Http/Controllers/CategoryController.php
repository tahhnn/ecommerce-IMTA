<?php

namespace App\Http\Controllers;

use App\Models\Cate;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function list(){
        $cate = DB::table('categories')->get();
        return view('admin.category.list',compact('cate'));
    }
    public function create(Request $request){
        $cate = new Category();
        if($request->post()){
            $cate->name = $request->name;
            $cate->save();
            return redirect(route('category.list'));
        }
        return view('admin.category.create');
    }
    public function update(Request $request,$id){
        $cateupdate = Category::find($id);
      
        if($request->post()){
            $cateupdate->name = $request->name;
            $cateupdate->save();
            return redirect(route('category.list'));
        }
        return view('admin.category.edit',compact('cateupdate'));
    }
    public function delete($id){
        $cateupdate = Category::find($id);
        $cateupdate->delete();
        return redirect(route('category.list'));

       
    }
}

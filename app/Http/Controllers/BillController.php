<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bills = DB::table('bills')
            ->join('users', 'users.id', '=', 'bills.id_user')
            ->select('users.name as user_name', 'bills.*')
            ->get();
        return view('admin.bill.listBill', compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $bill = Bill::join('users', 'users.id', '=', 'bills.id_user')
            ->select('users.name as user_name', 'bills.*')
            ->where('bills.id', $id)
            ->first();
        $billDetails = DB::table('bill_details')
            ->join('products', 'products.id', '=', 'bill_details.id_product')
            ->select('products.name as product_name', 'products.price as product_price', 'products.img as product_img', 'bill_details.*')
            ->where('id_bill', $id)->get();
        return view('admin.bill.billDetail', compact('bill', 'billDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bill = Bill::join('users', 'users.id', '=', 'bills.id_user')
            ->select('users.name as user_name', 'bills.*')
            ->where('bills.id', $id)
            ->first();
        $billDetails = DB::table('bill_details')
            ->join('products', 'products.id', '=', 'bill_details.id_product')
            ->select('products.name as product_name', 'products.price as product_price', 'products.img as product_img', 'bill_details.*')
            ->where('id_bill', $id)->get();
        return view('admin.bill.updateBill', compact('bill', 'billDetails'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bill $bill)
    {
        $message = 'Hóa đơn đã thanh toán không thể cập nhật!!!';
        if ($bill->status == 0) {

            $bill_new = $request->get('bill');

            $billDetails = $request->get('billDetails');
            $total_bill = 0;
            foreach ($billDetails as $billDetail) {
                // Lấy hóa đơn chi tiết theo $index
                $billDetail_orginer = BillDetail::find($billDetail['id']);
                // Cập nhật thông tin hóa đơn chi tiết
                $billDetail_orginer->fill($billDetail);
                $billDetail_orginer->save();

                $product = Product::find($billDetail_orginer->id_product);

                $total_bill += $billDetail_orginer->quantity * $product->price;
            }
            $bill_new['total_bill'] = $total_bill;
            // dd($bill_new);
            $bill->update($bill_new);

            $message = 'Hóa đơn đã được cập nhật!!!';
        }

        // Trả về route trước đó (back to the previous route)
        return Redirect::back()->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill $bill)
    {
        $message = 'Hóa đơn đã thanh toán, không thể xóa!!!';
        if ($bill->status == 0) {
            $message = 'Xóa hóa đơn thành công!!!';
            $bill->delete();
        }
        Session::flash('message', $message);
        return redirect()->route('bills.index');
    }
}

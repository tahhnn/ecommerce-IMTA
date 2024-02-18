<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class BillDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteBillDetail(Bill $bill, BillDetail $billDetail)
    {
        // dd($billDetail);
        $bill = Bill::find($billDetail->id_bill);
        $message = 'Hóa đơn đã thanh toán, không thể xóa!!!';
        if ($bill->status == 0) {
            $message = 'Xóa hóa đơn chi tiết thành công!!!';
            $billDetail->delete();
        }
        Session::flash('message', $message);
        return Redirect::back();
    }
}

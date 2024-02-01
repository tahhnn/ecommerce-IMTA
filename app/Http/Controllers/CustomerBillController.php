<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Product;
use Illuminate\Routing\Route;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class CustomerBillController extends Controller
{
    public function index()
    {
        $bills = DB::table('bills')
            ->join('users', 'users.id', '=', 'bills.id_user')
            ->select('users.name as user_name', 'bills.*')
            ->where('bills.id_user', '=', Auth::user()->id)
            ->get();
        return view('client.bill.listBill', compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function vnpay_payment(Request $request)
    {
        $bill_id = $request->get('id');
        $bill_total  = $request->get('total_bill');

        $bill = Bill::find($bill_id);
        $bill->status = 1;

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/bill-client";
        $vnp_TmnCode = "UW8YUL6R"; //Mã website tại VNPAY 
        $vnp_HashSecret = "SYAIJLPJMEXDCDLYDYEDQYKPPONBRDIO"; //Chuỗi bí mật

        $vnp_TxnRef = '$bill_id1234567' . "_bill_code"; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán hóa đơn';
        $vnp_OrderType = 'Thanh toán online';
        $vnp_Amount = $bill_total * 100;
        $vnp_Locale = 'VN';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            $bill->update();
            die();
        } else {
            echo json_encode($returnData);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $products = $request->get('cartinPR');
        $bill = [
            'paid_date' => Carbon::now()->format('Y-m-d'), 'status' => 0, 'total_bill' => 0, 'id_user' => Auth::user()->id
        ];
        $bill = Bill::create($bill);

        $total_bill = 0;
        foreach ($products as $p) {
            $product = Product::find($p['id']);
            $billDetail = ['id_bill' => $bill->id, 'id_product' => $p['id'], 'quantity' => 1];
            $billDetail = BillDetail::create($billDetail);
            $total_bill += $billDetail->quantity * $product->price;
        }

        $bill->total_bill = $total_bill;
        $bill->save();

        return redirect()->route('billClient.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $bill = Bill::join('users', 'users.id', '=', 'bills.id_user')
            ->select('users.name as user_name', 'bills.*')
            ->where('bills.id', $id)
            ->first();
        $billDetails = DB::table('bill_details')
            ->join('products', 'products.id', '=', 'bill_details.id_product')
            ->select('products.name as product_name', 'products.price as product_price', 'products.img as product_img', 'bill_details.*')
            ->where('id_bill', $id)->get();
        return view('client.bill.billDetail', compact('bill', 'billDetails'));
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
            ->where('bill_details.id_bill', $id)->get();
        return view('client.bill.updateBill', compact('bill', 'billDetails'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $bill_id = $request->get('id');
        $bill_status = $request->get('status');
        $bill = Bill::find($bill_id);

        $message = 'Hóa đơn đã thanh toán không thể cập nhật!!!';
        if ($bill_status == 0) {

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
            $bill->update($bill_new);

            $message = 'Hóa đơn đã được cập nhật!!!';
        }

        // Trả về route trước đó (back to the previous route)
        return Redirect::back()->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bill = Bill::find($id);
        $message = 'Hóa đơn đã thanh toán, không thể xóa!!!';
        if ($bill->status == 0) {

            $bill->delete();
            $message = 'Xóa hóa đơn thành công!!!';
        }
        Session::flash('message', $message);
        return redirect()->route('billClient.index');
    }
}

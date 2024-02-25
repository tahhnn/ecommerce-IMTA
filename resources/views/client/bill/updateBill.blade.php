<x-client-layout>
    @if(session('message'))
    <div class="ml-7 text-red-400">
        {{ session('message') }}
    </div>
@endif
    <div class="pt-14">
    <div>

    </div>
        <form class="mx-32 flex flex-col" action="{{ route('billClient.update', $bill->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input class="hidden" name="id" id="id" value="{{ $bill->id }}" readonly/>
              <div class="relative mb-5 group mx-11">
                  <label for="name" class="">Customer name</label>
                  <input type="text" name="" value="{{$bill->user_name}}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" readonly/>
              </div>
              <div class="relative  mb-5 group mx-11">
                  <label for="name" >Payment status</label>
                  <input type="text" name="status" id='status' value="{{ $bill->status == 0? "Chưa thanh toán": "Đã thanh toán" }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" readonly/>
            </div>
              <div class="relative  mb-5 group mx-11">
                  <label for="name" >Bill status</label>
                  <input type="text" name="status_bill" id='status_bill' value="{{ $bill->status_bill == 0? "Đơn không khả dụng":($bill->status_bill == 1? "Đang đặt hàng":($bill->status_bill == 2? "Đang chờ giao": ($bill->status_bill == 3? "Đang giao":($bill->status_bill == 4? "Đã giao": "Hoàn trả")))) }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" readonly/>
            </div>
              <div class="relative mb-5 group mx-11">
                  <label for="name">Paid date</label>
                <input type="date" name="bill[paid_date]" value="{{$bill->paid_date}}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" readonly/>
            </div>
                <button type="submit" class="flex w-20 items-center justify-center mr-12 bg-yellow-300">Update</button>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg m-5">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="row" class="px-6 py-3 text-center">
                                    ID
                                </th>
                                <th scope="row" class="px-6 py-3 text-center">
                                    Product Name 
                                </th>
                                <th scope="row" class="px-6 py-3 text-center">
                                    Image 
                                </th>
                                <th scope="row" class="px-6 py-3 text-center">
                                    Quantity 
                                </th>
                                <th scope="row" class="px-6 py-3 text-center">
                                    Price  
                                </th>
                                <th scope="row" class="px-6 py-3 text-center">
                                    Actions  
                                </th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $total_bill = 0
                        @endphp
                            @foreach($billDetails as $index => $billDetail)
                            <tr class="odd:bg-white text-center odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <input type="text" class="border-none w-10" name="billDetails[{{ $index }}][id]" id="billDetails[{{ $index }}][id]" value="{{$billDetail->id}}" readonly/>
                                </td>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$billDetail->product_name}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white flex items-center justify-center">
                                    <img width="50" height="50" src="{{ asset('image/' . $billDetail->product_img) }}" alt="">
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                   <input name="billDetails[{{ $index }}][quantity]" type="number" class="w-20 h-10" name="quantity" value="{{$billDetail->quantity}}"/>
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$billDetail->product_price}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <a href="/billDetail/{{ $billDetail->id }}" method="get">Delete
                                    </a>
                                </th>
                            </tr>
                            {{-- @php
                            $totalPrice += $p->product_price; // Cộng thêm giá của mỗi sản phẩm vào tổng tiền
                        @endphp --}}
                        @php
                        $total_bill += $billDetail->quantity*$billDetail->product_price
                        @endphp
                            @endforeach
                            
                        </tbody>
                    </table>
                    <h1 class="ml-4">Tổng Tiền:$ <input type="text" class="border-none" name="bill[total_bill]" id="bill[total_bill]" value="{{$total_bill}}" readonly/></h1>
                </div>
            </form>
    </div>    



</x-client-layout>
<x-app-layout>
    <div class="pt-14">
        <form class=" mx-32" method="POST" enctype="multipart/form-data">
            @csrf
              <div class="relative mb-5 group mx-11">
                  <label for="name" class="">Customer name</label>
                  <input type="text" value="{{$bill->user_name}}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" readonly/>
              </div>
              <div class="relative  mb-5 group mx-11">
                  <label for="name" >Status</label>
                <input type="text" value="{{$bill->status==0? 'Chưa thanh toán':'Đã thanh toán'}}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" readonly/>
            </div>
              <div class="relative mb-5 group mx-11">
                  <label for="name">Paid date</label>
                <input type="text" value="{{$bill->paid_date}}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" readonly/>
            </div>
    
            </form>
    </div>    

<div class="relative overflow-x-auto shadow-md sm:rounded-lg m-5">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3 text-center">
                    ID
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Product Name 
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Image 
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Quantity 
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Price  
                </th>
                
            </tr>
        </thead>
        <tbody>
            @php
            $total_bill = 0
        @endphp
            @foreach($billDetails as $billDetail)
            <tr class="odd:bg-white text-center odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{$billDetail->id}}
                </td>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$billDetail->product_name}}
                </th>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white flex items-center justify-center">
                    <img width="50" height="50" src="{{ asset('image/' . $billDetail->product_img) }}" alt="">
                </th>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$billDetail->quantity}}
                </th>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$billDetail->product_price}}
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
    
    <h1 class="ml-4">Tổng Tiền: {{$total_bill}} VNĐ</h1>
</div>

</x-app-layout>
<x-client-layout>
    

<div class="relative overflow-x-auto shadow-md sm:rounded-lg m-5">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Product Name 
                </th>
                <th scope="col" class="px-6 py-3">
                    Giá  
                </th>
                
            </tr>
        </thead>
        <tbody>
        @php
        $totalPrice = 0; // Khởi tạo biến tổng tiền
    @endphp
            @foreach($cartinPR as $p)
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <td class="px-6 py-4">
                {{$p->id}}
                </td>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$p->product_name}}
                </th>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$p->product_price}}
                </th>
            </tr>
            @php
            $totalPrice += $p->product_price; // Cộng thêm giá của mỗi sản phẩm vào tổng tiền
        @endphp
            @endforeach
            
        </tbody>
    </table>

    <h1 style="margin-left: 1150px;">Tổng Tiền :{{$totalPrice}} </h1>
</div>

</x-client-layout>
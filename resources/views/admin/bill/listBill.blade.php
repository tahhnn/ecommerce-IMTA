<x-app-layout>
    @if(session('message'))
    <div class="ml-7 text-red-400">
        {{ session('message') }}
    </div>
@endif

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg m-5 flex flex-col">
        <div class="w-full gap-40 m-6">
            <a href="{{ route('bills.find_bill_by_statusBill', 0) }}" class=" p-4 {{ $status_bill==0? 'bg-green-400':'bg-slate-100' }} hover:bg-slate-300">Đơn không khả dụng</a>
            <a href="{{ route('bills.find_bill_by_statusBill', 1) }}" class="p-4 {{ $status_bill==1? 'bg-green-400':'bg-slate-100' }} hover:bg-slate-300">Đang đặt hàng</a>
            <a href="{{ route('bills.find_bill_by_statusBill', 2) }}" class="p-4 {{ $status_bill==2? 'bg-green-400':'bg-slate-100' }} hover:bg-slate-300">Đang chờ giao</a>
            <a href="{{ route('bills.find_bill_by_statusBill', 3) }}" class="p-4 {{ $status_bill==3? 'bg-green-400':'bg-slate-100' }} hover:bg-slate-300">Đang giao</a>
            <a href="{{ route('bills.find_bill_by_statusBill', 4) }}" class="p-4 {{ $status_bill==4? 'bg-green-400':'bg-slate-100' }} hover:bg-slate-300">Đã giao</a>
            <a href="{{ route('bills.find_bill_by_statusBill', 5) }}" class="p-4 {{ $status_bill==5? 'bg-green-400':'bg-slate-100' }} hover:bg-slate-300">Hoàn trả</a>
            <a href="{{ route('bills.index') }}" class="p-4 {{ $status_bill==-1? 'bg-green-400':'bg-slate-100' }} hover:bg-slate-300">Tất cả đơn</a>
        </div>
        <table class="table table-striped w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-5 py-2 text-center">
                        ID
                    </th>
                    <th scope="col" class="px-5 py-2 text-center">
                        Customer name
                    </th>
                    
                    <th scope="col" class="px-5 py-2 text-center">
                       Total money
                    </th>
                    <th scope="col" class="px-5 py-2 text-center">
                        Payment status
                     </th>
                     <th scope="col" class="px-5 py-2 text-center">
                        Bill status
                     </th>
                    <th scope="col" class="px-5 py-2 text-center">
                       Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($bills as $bill)
                <tr>
                    <td scope="col" class="px-5 py-2 text-center">
                    {{$bill->id}}
                    </td>
                    <td scope="col" class="px-5 py-2 text-center">
                        {{$bill->user_name}}
                    </td>
                    
                    <td scope="col" class="px-5 py-2 text-center">
                        {{ $bill->total_bill }} VNĐ
                    </td>
                    <td class="px-5 py-2 text-center">
                        {{ $bill->status==0? "Chưa thanh toán":"Đã thanh toán" }}
                    </td>
                    <td class="px-5 py-2 text-center">
                        {{ $bill->status_bill == 0? "Đơn không khả dụng":($bill->status_bill == 1? "Đang đặt hàng":($bill->status_bill == 2? "Đang chờ giao": ($bill->status_bill == 3? "Đang giao":($bill->status_bill == 4? "Đã giao": "Hoàn trả")))) }}
                    </td>
                    <td class="px-5 py-2 text-center">
                        <a href="{{ route('bills.show', $bill->id) }}" class="font-medium p-1">Detail</a>
                        <form class="w-full" action="{{ route('bills.destroy', $bill->id) }}" method="POST">
                            <a href="{{ route('bills.edit', $bill->id) }}" class="font-medium p-1">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger m-1" type="submit">Cancel</button>
                        </form>

                    </td>
                    @if ($bill->status_bill != 0 && $bill->status_bill != 5)
                        <td><a href="{{ route('bills.Acept_bill', $bill->id) }}" class="font-medium p-1">Acept</a></td>
                    
                        
                    @endif
                </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>
    
    </x-app-layout>
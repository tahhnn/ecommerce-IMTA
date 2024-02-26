<x-client-layout>
    @if(session('message'))
    <div class="ml-7 text-red-400">
        {{ session('message') }}
    </div>
@endif
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg m-5">
        <div class="w-full gap-40 mb-4">
            <a href="{{ route('billClient.find_bill_by_statusBill', 0) }}" class="btn btn-{{ $status_bill==0? 'success':'light' }} hover:bg-slate-300">Đơn không khả dụng</a>
            <a href="{{ route('billClient.find_bill_by_statusBill', 1) }}" class="btn btn-{{ $status_bill==1? 'success':'light' }} hover:bg-slate-300">Đang đặt hàng</a>
            <a href="{{ route('billClient.find_bill_by_statusBill', 2) }}" class="btn btn-{{ $status_bill==2? 'success':'light' }} hover:bg-slate-300">Đang chờ giao</a>
            <a href="{{ route('billClient.find_bill_by_statusBill', 3) }}" class="btn btn-{{ $status_bill==3? 'success':'light' }} hover:bg-slate-300">Đang giao</a>
            <a href="{{ route('billClient.find_bill_by_statusBill', 4) }}" class="btn btn-{{ $status_bill==4? 'success':'light' }} hover:bg-slate-300">Đã giao</a>
            <a href="{{ route('billClient.find_bill_by_statusBill', 5) }}" class="btn btn-{{ $status_bill==5? 'success':'light' }} hover:bg-slate-300">Hoàn trả</a>
            <a href="{{ route('billClient.index') }}" class="btn btn-{{ $status_bill==-1? 'success':'light' }} hover:bg-slate-300">Tất cả đơn</a>
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
                       $ {{ $bill->total_bill }}
                    </td>
                    <td class="px-5 py-2 text-center">
                        {{ $bill->status==0? "Chưa thanh toán":"Đã thanh toán" }}
                    </td>
                    <td class="px-5 py-2 text-center">
                        {{ $bill->status_bill == 0? "Đơn không khả dụng":($bill->status_bill == 1? "Đang đặt hàng":($bill->status_bill == 2? "Đang chờ giao": ($bill->status_bill == 3? "Đang giao":($bill->status_bill == 4? "Đã giao": "Hoàn trả")))) }}
                    </td>
                    <td class="px-10 py-2 text-center">
                        <a href="{{ route('billClient.show', $bill->id) }}" class="font-medium p-1">Detail</a>
                        <form class=" mx-32 {{ $bill->status_bill == 0? "visible":"hidden" }}" action="{{ route('billClient.vnpay_payment', $bill->id) }}" method="POST" enctype="multipart/form-data">
                            <input name="id" id="id" value="{{ $bill->id }}" hidden/>
                            @csrf
                            <button name="redirect" type="submit" class="font-medium p-1">{{ $bill->status_bill == 0? "Order":"" }}</button>
                        </form>
                       
                                {{-- form --}}
                        <form class="w-full" action="{{ $bill->status_bill==0? route('billClient.destroy', $bill->id):route('billClient.cancel_bill', $bill->id) }}" method="POST">
                            <a href="{{ route('billClient.edit', $bill->id) }}" class="font-medium p-1">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button class="font-medium" type="submit">{{ $bill->status_bill==0? "Delete":"Cancel" }}</button>
                        </form>
                        {{-- <form class="w-full" action="{{ route('billClient.destroy', $bill->id) }}" method="POST">
                            <a href="{{ route('billClient.edit', $bill->id) }}" class="font-medium p-1">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button class="font-medium" type="submit">Delete</button>
                        </form> --}}
                    </td>
                </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>
    
    </x-client-layout>
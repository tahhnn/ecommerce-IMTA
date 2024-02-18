<x-client-layout>
    @if(session('message'))
    <div class="ml-7 text-red-400">
        {{ session('message') }}
    </div>
@endif
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg m-5">
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
                       Status
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
                        <a href="{{ route('billClient.show', $bill->id) }}" class="font-medium p-1">Detail</a>
                        <form class="w-full" action="{{ route('billClient.destroy', $bill->id) }}" method="POST">
                            <a href="{{ route('billClient.edit', $bill->id) }}" class="font-medium p-1">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button class="" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>
    
    </x-client-layout>
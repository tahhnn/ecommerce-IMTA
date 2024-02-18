<x-app-layout>
    

<div class="relative overflow-x-auto shadow-md sm:rounded-lg m-5">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    User name
                </th>
                
                <th scope="col" class="px-6 py-3">
                   Chi Tiết Giỏ 
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart as $p)
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <td class="px-6 py-4">
                {{$p->id}}
                </td>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$p->user_name}}
                </th>
                
                <td class="px-6 py-4">
                    <a href="/cartDetail/{{$p->id}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">CartDetail</a>
                   
                </td>
            </tr>
            @endforeach
            
        </tbody>
    </table>
</div>

</x-app-layout>
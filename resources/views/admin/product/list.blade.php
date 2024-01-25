<x-app-layout>
    

<div class="relative overflow-x-auto shadow-md sm:rounded-lg m-5">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Product name
                </th>
                <th scope="col" class="px-6 py-3">
                    Quantity
                </th>
                <th scope="col" class="px-6 py-3">
                    Image
                </th>
                <th scope="col" class="px-6 py-3">
                    Category
                </th>
                <th scope="col" class="px-6 py-3">
                    Price
                </th>
                <th scope="col" class="px-6 py-3">
                    Description
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($product as $p)
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <td class="px-6 py-4">
                {{$p->id}}
                </td>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$p->name}}
                </th>
                <td class="px-6 py-4">
                {{$p->quantity}}
                </td>
                <td class="px-6 py-4">
                <img width="200" src="{{ asset('image/' . $p->img) }}" alt="">
                </td>
                <td class="px-6 py-4">
                {{$p->cate_name}}
                </td>
                <td class="px-6 py-4">
                {{$p->price}}
                </td>
                <td class="px-6 py-4">
                {{$p->description}}
                </td>
                <td class="px-6 py-4">
                    <a href="/product-edit/{{$p->id}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    <a href="/product-delete/{{$p->id}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                </td>
            </tr>
            @endforeach
            
        </tbody>
    </table>
</div>

</x-app-layout>
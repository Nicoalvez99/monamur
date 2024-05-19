<div>
    @foreach($conver as $converItem)
    <div class="flex items-start gap-2.5">
    <img class="w-8 h-8 rounded-full" src="/docs/images/people/profile-picture-3.jpg" alt="Jese image">
    <div class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
        <div class="flex items-center space-x-2 rtl:space-x-reverse">
            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $converItem['username'] }}</span>
            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">11:46</span>
        </div>
        <p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">{{ $converItem['mensaje'] }}</p>
    </div>
    </div>
    @endforeach
    <form wire:submit="submitMensaje" class="flex">
        <input type="text" wire:model="mensajes" wire:key="{{now()}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 my-auto"><i class="bi bi-send-fill" style="font-size: 20px;"></i></button>
    </form>
</div>

@props(['columns', 'data'])

<div class="container mx-auto w-full mt-5">
    <h1 class="text-xl py-2 font-semibold text-gray-900 dark:text-gray-100 whitespace-nowrap overflow-hidden">Maintenance Schedule</h1>
    <div class="w-full h-32 overflow-x-auto
        scrollbar-thin
        scrollbar-thumb-rounded-full 
        scrollbar-thumb-slate-300 
        scrollbar-track-slate-100 
        dark:scrollbar-thumb-slate-300 
        dark:scrollbar-track-slate-500
        scrollbar-thumb-rounded-full 
        scrollbar-track-rounded-full">
        <table class="table-auto w-full text-left">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700 rounded-md">
                    @foreach ($columns as $column)
                        <th class="p-1 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $column }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)
                    <tr class="border-b border-gray-200 dark:border-gray-700 rounded-md">
                        @foreach ($row as $cell)
                            <td class="p-1 whitespace-nowrap max-w-[20ch] truncate text-gray-800 dark:text-gray-200">
                                {{ $cell }}
                            </td>
                        @endforeach
                        <td class="p-1 whitespace-nowrap max-w-[20ch] truncate">
                            <button class="py-1 px-4 border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white rounded-md">
                                do the task
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
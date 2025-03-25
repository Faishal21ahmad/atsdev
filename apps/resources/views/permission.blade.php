<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">
<x-btnback href="{{ route('role') }}" /> 
<div class="container mx-auto w-full">
    <form id="formRolePermission" class="p-3 md:p-4" action="{{ route('permission.update.action',$roles->id) }}" method="POST">
        @csrf
        <div class="mx-auto w-full h-28 dark:text-white flex justify-between items-start ">
            <div class="">
                <h1 class="text-xl"><span class="">Role : </span>{{ $roles->role_name }}</h1>
                <p><span>Deskripsi : </span>{{ $roles->description }}</p>
            </div>
            <div class="">
                <button type="submit" class="px-5 sm:px-10 py-2 text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md">
                    Save
                </button>
            </div>
        </div>
        <div class="grid gap-3 mb-3 grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
            @foreach($permissions as $item) 
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="permissions[]" value="{{ $item->id }}" class="sr-only peer"
                    {{ $roles->permissions->contains($item->id) ? 'checked' : '' }}
                    >
                    <div class="relative w-11 h-6 bg-slate-200 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
                    <span class="ms-3 text-sm font-medium text-slate-900 dark:text-slate-300">{{ $item->permission_name }}</span>
                </label>
            @endforeach
        </div>
    </form>
</div>
</x-layoutdsbd>
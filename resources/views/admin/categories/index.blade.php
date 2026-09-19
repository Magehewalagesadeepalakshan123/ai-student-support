@extends('admin.layout')

@section('title', 'Categories')

@section('page-title', 'Category Management')

@section('content')

<div class="flex justify-between items-center mb-6">

    <div>

        <h1 class="text-2xl font-bold text-gray-800">
            Support Categories
        </h1>

        <p class="text-gray-500 mt-1">
            Manage categories used by student support tickets.
        </p>

    </div>


    <a
        href="{{ route('admin.categories.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg"
    >
        + Add Category
    </a>

</div>


@if(session('success'))

    <div class="bg-green-100 border border-green-200 text-green-800 p-4 rounded-lg mb-6">

        {{ session('success') }}

    </div>

@endif


@if(session('error'))

    <div class="bg-red-100 border border-red-200 text-red-800 p-4 rounded-lg mb-6">

        {{ session('error') }}

    </div>

@endif


<div class="bg-white rounded-xl shadow-sm overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-50 border-b">

                <tr>

                    <th class="text-left p-4">
                        Category
                    </th>

                    <th class="text-left p-4">
                        Description
                    </th>

                    <th class="text-left p-4">
                        Tickets
                    </th>

                    <th class="text-left p-4">
                        Status
                    </th>

                    <th class="text-left p-4">
                        Actions
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y">

                @forelse($categories as $category)

                    <tr>

                        <td class="p-4 font-semibold">
                            {{ $category->name }}
                        </td>


                        <td class="p-4 text-gray-600">

                            {{ $category->description
                                ?? 'No description'
                            }}

                        </td>


                        <td class="p-4">

                            {{ $category->tickets_count }}

                        </td>


                        <td class="p-4">

                            @if($category->status)

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                    Active
                                </span>

                            @else

                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                                    Inactive
                                </span>

                            @endif

                        </td>


                        <td class="p-4">

                            <div class="flex flex-wrap gap-2">

                                <a
                                    href="{{ route(
                                        'admin.categories.edit',
                                        $category
                                    ) }}"
                                    class="bg-blue-600 text-white px-3 py-2 rounded-lg text-sm"
                                >
                                    Edit
                                </a>


                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.categories.status',
                                        $category
                                    ) }}"
                                >

                                    @csrf
                                    @method('PATCH')


                                    <button
                                        type="submit"
                                        class="bg-yellow-500 text-white px-3 py-2 rounded-lg text-sm"
                                    >

                                        {{ $category->status
                                            ? 'Deactivate'
                                            : 'Activate'
                                        }}

                                    </button>

                                </form>


                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.categories.destroy',
                                        $category
                                    ) }}"
                                    onsubmit="return confirm('Delete this category?')"
                                >

                                    @csrf
                                    @method('DELETE')


                                    <button
                                        type="submit"
                                        class="bg-red-600 text-white px-3 py-2 rounded-lg text-sm"
                                    >
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            class="text-center text-gray-500 p-10"
                        >
                            No categories found.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


<div class="mt-6">

    {{ $categories->links() }}

</div>

@endsection
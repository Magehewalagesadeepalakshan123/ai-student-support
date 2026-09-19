@extends('admin.layout')

@section('title', 'Notices')

@section('page-title', 'Notice Management')

@section('content')

<div class="flex justify-between items-center mb-6">

    <div>
        <h1 class="text-2xl font-bold">
            Notices
        </h1>

        <p class="text-gray-500 mt-1">
            Manage announcements for students.
        </p>
    </div>


    <a
        href="{{ route('admin.notices.create') }}"
        class="bg-blue-600 text-white px-5 py-3 rounded-lg"
    >
        + Add Notice
    </a>

</div>


@if(session('success'))

    <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6">
        {{ session('success') }}
    </div>

@endif


<div class="bg-white rounded-xl shadow-sm overflow-hidden">

    <table class="w-full">

        <thead class="bg-gray-50">

            <tr>
                <th class="text-left p-4">Title</th>
                <th class="text-left p-4">Published</th>
                <th class="text-left p-4">Status</th>
                <th class="text-left p-4">Actions</th>
            </tr>

        </thead>


        <tbody class="divide-y">

            @forelse($notices as $notice)

                <tr>

                    <td class="p-4">

                        <p class="font-semibold">
                            {{ $notice->title }}
                        </p>

                        <p class="text-sm text-gray-500">
                            {{ \Illuminate\Support\Str::limit(
                                $notice->content,
                                80
                            ) }}
                        </p>

                    </td>


                    <td class="p-4">

                        {{ $notice->published_at
                            ?->format('d M Y')
                            ?? '-'
                        }}

                    </td>


                    <td class="p-4">

                        {{ $notice->status
                            ? 'Active'
                            : 'Inactive'
                        }}

                    </td>


                    <td class="p-4">

                        <div class="flex gap-2">

                            <a
                                href="{{ route(
                                    'admin.notices.edit',
                                    $notice
                                ) }}"
                                class="bg-blue-600 text-white px-3 py-2 rounded"
                            >
                                Edit
                            </a>


                            <form
                                method="POST"
                                action="{{ route(
                                    'admin.notices.status',
                                    $notice
                                ) }}"
                            >

                                @csrf
                                @method('PATCH')

                                <button
                                    class="bg-yellow-500 text-white px-3 py-2 rounded"
                                >
                                    {{ $notice->status
                                        ? 'Deactivate'
                                        : 'Activate'
                                    }}
                                </button>

                            </form>


                            <form
                                method="POST"
                                action="{{ route(
                                    'admin.notices.destroy',
                                    $notice
                                ) }}"
                                onsubmit="return confirm('Delete this notice?')"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    class="bg-red-600 text-white px-3 py-2 rounded"
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
                        colspan="4"
                        class="text-center p-10 text-gray-500"
                    >
                        No notices found.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection
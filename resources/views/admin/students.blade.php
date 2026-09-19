@extends('admin.layout')

@section('title', 'Students')

@section('page-title', 'Student Management')

@section('content')

<div class="mb-6">

    <h1 class="text-2xl font-bold text-gray-800">
        Students
    </h1>

    <p class="text-gray-500 mt-1">
        Manage registered student accounts.
    </p>

</div>


@if(session('success'))

    <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6">
        {{ session('success') }}
    </div>

@endif


@if(session('error'))

    <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-6">
        {{ session('error') }}
    </div>

@endif


<div class="bg-white rounded-xl shadow-sm overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-50 border-b">

                <tr>

                    <th class="text-left p-4">
                        Student
                    </th>

                    <th class="text-left p-4">
                        Email
                    </th>

                    <th class="text-left p-4">
                        Status
                    </th>

                    <th class="text-left p-4">
                        Registered
                    </th>

                    <th class="text-left p-4">
                        Actions
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y">

                @forelse($students as $student)

                    <tr>

                        <td class="p-4 font-semibold">
                            {{ $student->name }}
                        </td>


                        <td class="p-4">
                            {{ $student->email }}
                        </td>


                        <td class="p-4">

                            @if($student->status)

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
                            {{ $student->created_at->format('d M Y') }}
                        </td>


                        <td class="p-4">

                            <div class="flex flex-wrap gap-2">

                                <a
                                    href="{{ route(
                                        'admin.users.edit',
                                        $student
                                    ) }}"
                                    class="bg-blue-600 text-white px-3 py-2 rounded-lg text-sm"
                                >
                                    Edit
                                </a>


                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.users.status',
                                        $student
                                    ) }}"
                                >

                                    @csrf
                                    @method('PATCH')


                                    <button
                                        class="bg-yellow-500 text-white px-3 py-2 rounded-lg text-sm"
                                    >
                                        {{ $student->status
                                            ? 'Deactivate'
                                            : 'Activate'
                                        }}
                                    </button>

                                </form>


                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.users.destroy',
                                        $student
                                    ) }}"
                                    onsubmit="return confirm('Delete this student?')"
                                >

                                    @csrf
                                    @method('DELETE')


                                    <button
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
                            class="text-center p-10 text-gray-500"
                        >
                            No students found.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


<div class="mt-6">

    {{ $students->links() }}

</div>

@endsection
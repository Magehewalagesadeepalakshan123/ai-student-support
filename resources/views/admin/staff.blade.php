@extends('admin.layout')

@section('title', 'Staff')

@section('page-title', 'Staff Management')

@section('content')

<div class="flex justify-between items-center mb-6">

    <div>

        <h1 class="text-2xl font-bold text-gray-800">
            Staff
        </h1>

        <p class="text-gray-500">
            Manage student support staff accounts.
        </p>

    </div>


    <a
        href="{{ route('admin.staff.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg"
    >
        + Add Staff
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

                <th class="text-left p-4">
                    Staff
                </th>

                <th class="text-left p-4">
                    Email
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

            @forelse($staff as $member)

                <tr>

                    <td class="p-4 font-semibold">
                        {{ $member->name }}
                    </td>


                    <td class="p-4">
                        {{ $member->email }}
                    </td>


                    <td class="p-4">

                        {{ $member->status
                            ? 'Active'
                            : 'Inactive'
                        }}

                    </td>


                    <td class="p-4">

                        <div class="flex gap-2">

                            <a
                                href="{{ route(
                                    'admin.users.edit',
                                    $member
                                ) }}"
                                class="bg-blue-600 text-white px-3 py-2 rounded-lg"
                            >
                                Edit
                            </a>


                            <form
                                method="POST"
                                action="{{ route(
                                    'admin.users.status',
                                    $member
                                ) }}"
                            >

                                @csrf
                                @method('PATCH')

                                <button
                                    class="bg-yellow-500 text-white px-3 py-2 rounded-lg"
                                >

                                    {{ $member->status
                                        ? 'Deactivate'
                                        : 'Activate'
                                    }}

                                </button>

                            </form>


                            <form
                                method="POST"
                                action="{{ route(
                                    'admin.users.destroy',
                                    $member
                                ) }}"
                                onsubmit="return confirm('Delete this staff account?')"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    class="bg-red-600 text-white px-3 py-2 rounded-lg"
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
                        No staff accounts found.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>


<div class="mt-6">
    {{ $staff->links() }}
</div>

@endsection
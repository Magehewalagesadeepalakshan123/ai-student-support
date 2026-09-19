@extends('student.layout')

@section('title', 'My Tickets')

@section('page-title', 'My Tickets')

@section('content')

<div class="flex justify-between items-center mb-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Support Tickets
        </h1>

        <p class="text-gray-500 mt-1">
            View and manage your support requests.
        </p>
    </div>


    <a
        href="{{ route('student.tickets.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg"
    >
        + Create Ticket
    </a>

</div>


@if(session('success'))

    <div class="bg-green-100 text-green-800 border border-green-200 p-4 rounded-lg mb-6">

        {{ session('success') }}

    </div>

@endif


<div class="bg-white rounded-xl shadow-sm overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-50 border-b">

                <tr>

                    <th class="text-left px-6 py-4">
                        Ticket
                    </th>

                    <th class="text-left px-6 py-4">
                        Category
                    </th>

                    <th class="text-left px-6 py-4">
                        Priority
                    </th>

                    <th class="text-left px-6 py-4">
                        Status
                    </th>

                    <th class="text-left px-6 py-4">
                        Date
                    </th>

                    <th class="text-left px-6 py-4">
                        Action
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y">

            @forelse($tickets as $ticket)

                <tr>

                    <td class="px-6 py-4">

                        <p class="font-semibold">
                            #TKT-{{ str_pad(
                                $ticket->id,
                                4,
                                '0',
                                STR_PAD_LEFT
                            ) }}
                        </p>

                        <p class="text-sm text-gray-500">
                            {{ $ticket->subject }}
                        </p>

                    </td>


                    <td class="px-6 py-4">
                        {{ $ticket->category->name }}
                    </td>


                    <td class="px-6 py-4 capitalize">
                        {{ $ticket->priority }}
                    </td>


                    <td class="px-6 py-4">

                        <span class="capitalize">
                            {{ str_replace(
                                '_',
                                ' ',
                                $ticket->status
                            ) }}
                        </span>

                    </td>


                    <td class="px-6 py-4">
                        {{ $ticket->created_at->format(
                            'd M Y'
                        ) }}
                    </td>


                    <td class="px-6 py-4">

                        <a
                            href="{{ route(
                                'student.tickets.show',
                                $ticket
                            ) }}"
                            class="text-blue-600 hover:underline"
                        >
                            View
                        </a>

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="6"
                        class="text-center p-12 text-gray-500"
                    >

                        No support tickets found.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
@extends('staff.layout')

@section('title', 'Staff Dashboard')

@section('page-title', 'Dashboard')

@section('content')

<div class="mb-8">

    <h1 class="text-3xl font-bold text-gray-800">
        Welcome, {{ auth()->user()->name }} 👋
    </h1>

    <p class="text-gray-500 mt-2">
        Manage student support requests.
    </p>

</div>


<!-- STATISTICS -->

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    <div class="bg-white p-6 rounded-xl shadow-sm">

        <p class="text-gray-500">
            Total Tickets
        </p>

        <h2 class="text-3xl font-bold mt-2">
            {{ $totalTickets }}
        </h2>

    </div>


    <div class="bg-white p-6 rounded-xl shadow-sm">

        <p class="text-gray-500">
            Pending
        </p>

        <h2 class="text-3xl font-bold mt-2 text-yellow-600">
            {{ $pendingTickets }}
        </h2>

    </div>


    <div class="bg-white p-6 rounded-xl shadow-sm">

        <p class="text-gray-500">
            In Progress
        </p>

        <h2 class="text-3xl font-bold mt-2 text-blue-600">
            {{ $inProgressTickets }}
        </h2>

    </div>


    <div class="bg-white p-6 rounded-xl shadow-sm">

        <p class="text-gray-500">
            Resolved
        </p>

        <h2 class="text-3xl font-bold mt-2 text-green-600">
            {{ $resolvedTickets }}
        </h2>

    </div>

</div>


<!-- QUICK ACTION -->

<div class="mt-10">

    <h2 class="text-xl font-bold mb-5">
        Quick Actions
    </h2>


    <a
        href="{{ route('staff.tickets') }}"
        class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 rounded-xl"
    >
        Manage Support Tickets
    </a>

</div>


<!-- RECENT TICKETS -->

<div class="mt-10">

    <h2 class="text-xl font-bold mb-5">
        Recent Support Requests
    </h2>


    <div class="bg-white rounded-xl shadow-sm overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-50">

                <tr>

                    <th class="text-left p-4">
                        Ticket
                    </th>

                    <th class="text-left p-4">
                        Student
                    </th>

                    <th class="text-left p-4">
                        Category
                    </th>

                    <th class="text-left p-4">
                        Status
                    </th>

                    <th class="text-left p-4">
                        Action
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y">

                @forelse($recentTickets as $ticket)

                    <tr>

                        <td class="p-4">

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


                        <td class="p-4">
                            {{ $ticket->user->name }}
                        </td>


                        <td class="p-4">
                            {{ $ticket->category->name }}
                        </td>


                        <td class="p-4 capitalize">

                            {{ str_replace(
                                '_',
                                ' ',
                                $ticket->status
                            ) }}

                        </td>


                        <td class="p-4">

                            <a
                                href="{{ route(
                                    'staff.tickets.show',
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
                            colspan="5"
                            class="text-center p-8 text-gray-500"
                        >
                            No support tickets available.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
@extends('student.layout')

@section('title', 'Ticket Details')

@section('page-title', 'Ticket Details')

@section('content')

<div class="max-w-4xl">

    <div class="mb-5">

        <a
            href="{{ route('student.tickets') }}"
            class="text-blue-600 hover:underline"
        >
            ← Back to My Tickets
        </a>

    </div>


    <div class="bg-white rounded-xl shadow-sm p-8">

        <div class="flex justify-between mb-8">

            <div>

                <p class="text-sm text-gray-500">
                    Ticket
                </p>

                <h1 class="text-2xl font-bold">
                    #TKT-{{ str_pad(
                        $ticket->id,
                        4,
                        '0',
                        STR_PAD_LEFT
                    ) }}
                </h1>

            </div>


            <div>

                <span class="capitalize bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full">

                    {{ str_replace(
                        '_',
                        ' ',
                        $ticket->status
                    ) }}

                </span>

            </div>

        </div>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <div>

                <p class="text-sm text-gray-500">
                    Category
                </p>

                <p class="font-medium mt-1">
                    {{ $ticket->category->name }}
                </p>

            </div>


            <div>

                <p class="text-sm text-gray-500">
                    Priority
                </p>

                <p class="font-medium capitalize mt-1">
                    {{ $ticket->priority }}
                </p>

            </div>


            <div>

                <p class="text-sm text-gray-500">
                    Created
                </p>

                <p class="font-medium mt-1">
                    {{ $ticket->created_at->format(
                        'd M Y h:i A'
                    ) }}
                </p>

            </div>

        </div>


        <div class="border-t pt-6">

            <h2 class="text-xl font-bold">
                {{ $ticket->subject }}
            </h2>

            <p class="text-gray-700 mt-4 whitespace-pre-line">
                {{ $ticket->description }}
            </p>

        </div>


        <div class="border-t mt-8 pt-6">

            <p class="text-sm text-gray-500">
                Assigned Staff
            </p>

            <p class="font-medium mt-1">

                {{ $ticket->assignedStaff?->name
                    ?? 'Not assigned yet' }}

            </p>

        </div>

    </div>

</div>

@endsection
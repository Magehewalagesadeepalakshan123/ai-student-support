@extends('staff.layout')

@section('title', 'Ticket Details')

@section('page-title', 'Ticket Details')

@section('content')

<div class="max-w-5xl">

    <!-- BACK BUTTON -->
    <div class="mb-5">

        <a
            href="{{ route('staff.tickets') }}"
            class="text-blue-600 hover:underline"
        >
            ← Back to Support Tickets
        </a>

    </div>


    <!-- SUCCESS MESSAGE -->
    @if(session('success'))

        <div class="bg-green-100 text-green-800 border border-green-200 p-4 rounded-lg mb-6">

            {{ session('success') }}

        </div>

    @endif


    <!-- TICKET DETAILS CARD -->
    <div class="bg-white shadow-sm rounded-xl p-8">

        <div class="flex justify-between items-start">

            <div>

                <p class="text-sm text-gray-500">
                    Ticket
                </p>

                <h1 class="text-2xl font-bold text-gray-800">

                    #TKT-{{ str_pad(
                        $ticket->id,
                        4,
                        '0',
                        STR_PAD_LEFT
                    ) }}

                </h1>

            </div>


            <div>

                @if($ticket->status === 'pending')

                    <span class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full text-sm font-medium">
                        Pending
                    </span>

                @elseif($ticket->status === 'in_progress')

                    <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-medium">
                        In Progress
                    </span>

                @elseif($ticket->status === 'resolved')

                    <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-medium">
                        Resolved
                    </span>

                @else

                    <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm font-medium">
                        Closed
                    </span>

                @endif

            </div>

        </div>


        <!-- TICKET INFORMATION -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">

            <div>

                <p class="text-sm text-gray-500">
                    Student
                </p>

                <p class="font-semibold mt-1">
                    {{ $ticket->user->name }}
                </p>

                <p class="text-sm text-gray-500">
                    {{ $ticket->user->email }}
                </p>

            </div>


            <div>

                <p class="text-sm text-gray-500">
                    Category
                </p>

                <p class="font-semibold mt-1">
                    {{ $ticket->category->name }}
                </p>

            </div>


            <div>

                <p class="text-sm text-gray-500">
                    Priority
                </p>

                <p class="font-semibold capitalize mt-1">
                    {{ $ticket->priority }}
                </p>

            </div>


            <div>

                <p class="text-sm text-gray-500">
                    Assigned To
                </p>

                <p class="font-semibold mt-1">

                    {{ $ticket->assignedStaff?->name ?? 'Not assigned' }}

                </p>

            </div>

        </div>


        <!-- CREATED DATE -->
        <div class="mt-6">

            <p class="text-sm text-gray-500">
                Created
            </p>

            <p class="font-medium mt-1">

                {{ $ticket->created_at->format('d M Y h:i A') }}

            </p>

        </div>


        <!-- SUBJECT AND DESCRIPTION -->
        <div class="border-t mt-8 pt-6">

            <p class="text-sm text-gray-500">
                Subject
            </p>

            <h2 class="text-xl font-bold text-gray-800 mt-1">

                {{ $ticket->subject }}

            </h2>


            <p class="text-sm text-gray-500 mt-6">
                Description
            </p>

            <div class="bg-gray-50 rounded-lg p-5 mt-2">

                <p class="text-gray-700 whitespace-pre-line">

                    {{ $ticket->description }}

                </p>

            </div>

        </div>


        <!-- ASSIGN TICKET -->
        @if(!$ticket->assigned_to)

            <div class="border-t mt-8 pt-6">

                <form
                    method="POST"
                    action="{{ route(
                        'staff.tickets.assign',
                        $ticket
                    ) }}"
                >

                    @csrf
                    @method('PATCH')


                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg"
                    >
                        Assign Ticket To Me
                    </button>

                </form>

            </div>

        @endif


        <!-- UPDATE STATUS -->
        <div class="border-t mt-8 pt-6">

            <h3 class="text-lg font-bold text-gray-800 mb-4">
                Update Ticket Status
            </h3>


            <form
                method="POST"
                action="{{ route(
                    'staff.tickets.status',
                    $ticket
                ) }}"
                class="flex flex-col sm:flex-row gap-3"
            >

                @csrf
                @method('PATCH')


                <select
                    name="status"
                    class="rounded-lg border-gray-300"
                    required
                >

                    <option
                        value="pending"
                        @selected($ticket->status === 'pending')
                    >
                        Pending
                    </option>


                    <option
                        value="in_progress"
                        @selected($ticket->status === 'in_progress')
                    >
                        In Progress
                    </option>


                    <option
                        value="resolved"
                        @selected($ticket->status === 'resolved')
                    >
                        Resolved
                    </option>


                    <option
                        value="closed"
                        @selected($ticket->status === 'closed')
                    >
                        Closed
                    </option>

                </select>


                <button
                    type="submit"
                    class="bg-slate-800 hover:bg-slate-900 text-white px-6 py-2 rounded-lg"
                >
                    Update Status
                </button>

            </form>

        </div>

    </div>


    <!-- ===================================== -->
    <!-- CONVERSATION -->
    <!-- ===================================== -->

    <div class="bg-white shadow-sm rounded-xl p-8 mt-6">

        <h2 class="text-xl font-bold text-gray-800 mb-6">
            Conversation
        </h2>


        <div class="space-y-4">

            @forelse($ticket->replies as $reply)

                <div
                    class="
                        p-5
                        rounded-xl
                        {{ $reply->user->role === 'staff'
                            ? 'bg-blue-50 border border-blue-100'
                            : 'bg-gray-100'
                        }}
                    "
                >

                    <div class="flex justify-between items-start gap-4">

                        <div>

                            <p class="font-semibold text-gray-800">

                                {{ $reply->user->name }}

                            </p>

                            <p class="text-xs text-gray-500 capitalize">

                                {{ $reply->user->role }}

                            </p>

                        </div>


                        <span class="text-sm text-gray-500">

                            {{ $reply->created_at->format(
                                'd M Y h:i A'
                            ) }}

                        </span>

                    </div>


                    <p class="mt-4 text-gray-700 whitespace-pre-line">

                        {{ $reply->message }}

                    </p>

                </div>

            @empty

                <div class="bg-gray-50 rounded-lg p-6 text-center">

                    <p class="text-gray-500">
                        No replies yet.
                    </p>

                </div>

            @endforelse

        </div>


        <!-- REPLY FORM -->
        <div class="border-t mt-8 pt-6">

            <form
                method="POST"
                action="{{ route(
                    'staff.tickets.reply',
                    $ticket
                ) }}"
            >

                @csrf


                <div>

                    <label
                        for="message"
                        class="block font-medium text-gray-700 mb-2"
                    >
                        Reply to Student
                    </label>


                    <textarea
                        id="message"
                        name="message"
                        rows="5"
                        class="w-full rounded-lg border-gray-300"
                        placeholder="Write your reply to the student..."
                        required
                    >{{ old('message') }}</textarea>


                    @error('message')

                        <p class="text-red-600 text-sm mt-2">

                            {{ $message }}

                        </p>

                    @enderror

                </div>


                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg mt-4"
                >
                    Send Reply
                </button>

            </form>

        </div>

    </div>

</div>

@endsection
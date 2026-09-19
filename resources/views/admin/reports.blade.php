@extends('admin.layout')

@section('title', 'Reports & Analytics')

@section('page-title', 'Reports & Analytics')

@section('content')

<div class="mb-8">

    <h1 class="text-3xl font-bold text-gray-800">
        System Reports & Analytics
    </h1>

    <p class="text-gray-500 mt-2">
        Overview of users, support tickets and AI Assistant activity.
    </p>

</div>


<!-- USER STATISTICS -->

<div class="mb-10">

    <h2 class="text-xl font-bold text-gray-800 mb-4">
        User Statistics
    </h2>


    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white rounded-xl shadow-sm p-6">

            <p class="text-sm text-gray-500">
                Students
            </p>

            <h2 class="text-3xl font-bold mt-2 text-blue-600">
                {{ $studentsCount }}
            </h2>

        </div>


        <div class="bg-white rounded-xl shadow-sm p-6">

            <p class="text-sm text-gray-500">
                Staff
            </p>

            <h2 class="text-3xl font-bold mt-2 text-purple-600">
                {{ $staffCount }}
            </h2>

        </div>

    </div>

</div>


<!-- TICKET STATISTICS -->

<div class="mb-10">

    <h2 class="text-xl font-bold text-gray-800 mb-4">
        Ticket Statistics
    </h2>


    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-5">

        <div class="bg-white rounded-xl shadow-sm p-5">

            <p class="text-gray-500 text-sm">
                Total
            </p>

            <h2 class="text-3xl font-bold mt-2">
                {{ $totalTickets }}
            </h2>

        </div>


        <div class="bg-white rounded-xl shadow-sm p-5">

            <p class="text-gray-500 text-sm">
                Pending
            </p>

            <h2 class="text-3xl font-bold mt-2 text-yellow-600">
                {{ $pendingTickets }}
            </h2>

        </div>


        <div class="bg-white rounded-xl shadow-sm p-5">

            <p class="text-gray-500 text-sm">
                In Progress
            </p>

            <h2 class="text-3xl font-bold mt-2 text-blue-600">
                {{ $inProgressTickets }}
            </h2>

        </div>


        <div class="bg-white rounded-xl shadow-sm p-5">

            <p class="text-gray-500 text-sm">
                Resolved
            </p>

            <h2 class="text-3xl font-bold mt-2 text-green-600">
                {{ $resolvedTickets }}
            </h2>

        </div>


        <div class="bg-white rounded-xl shadow-sm p-5">

            <p class="text-gray-500 text-sm">
                Closed
            </p>

            <h2 class="text-3xl font-bold mt-2 text-gray-600">
                {{ $closedTickets }}
            </h2>

        </div>

    </div>

</div>


<!-- AI STATISTICS -->

<div class="mb-10">

    <h2 class="text-xl font-bold text-gray-800 mb-4">
        AI Assistant Statistics
    </h2>


    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-white rounded-xl shadow-sm p-6">

            <p class="text-sm text-gray-500">
                AI Questions
            </p>

            <h2 class="text-3xl font-bold mt-2 text-purple-600">
                {{ $totalAiQuestions }}
            </h2>

        </div>


        <div class="bg-white rounded-xl shadow-sm p-6">

            <p class="text-sm text-gray-500">
                Answers Found
            </p>

            <h2 class="text-3xl font-bold mt-2 text-green-600">
                {{ $answeredAiQuestions }}
            </h2>

        </div>


        <div class="bg-white rounded-xl shadow-sm p-6">

            <p class="text-sm text-gray-500">
                No Answer Found
            </p>

            <h2 class="text-3xl font-bold mt-2 text-red-600">
                {{ $unansweredAiQuestions }}
            </h2>

        </div>


        <div class="bg-white rounded-xl shadow-sm p-6">

            <p class="text-sm text-gray-500">
                AI Success Rate
            </p>

            <h2 class="text-3xl font-bold mt-2 text-blue-600">
                {{ $aiSuccessRate }}%
            </h2>

        </div>

    </div>

</div>


<!-- POPULAR CATEGORIES -->

<div class="mb-10">

    <h2 class="text-xl font-bold text-gray-800 mb-4">
        Popular Support Categories
    </h2>


    <div class="bg-white rounded-xl shadow-sm overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-50">

                <tr>

                    <th class="text-left p-4">
                        Category
                    </th>

                    <th class="text-left p-4">
                        Tickets
                    </th>

                    <th class="text-left p-4">
                        Status
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y">

                @forelse($popularCategories as $category)

                    <tr>

                        <td class="p-4 font-semibold">
                            {{ $category->name }}
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

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="3"
                            class="text-center p-8 text-gray-500"
                        >
                            No category information available.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


<!-- RECENT TICKETS -->

<div class="mb-10">

    <h2 class="text-xl font-bold text-gray-800 mb-4">
        Recent Support Tickets
    </h2>


    <div class="bg-white rounded-xl shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

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
                            Date
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
                                {{ $ticket->user?->name ?? '-' }}
                            </td>


                            <td class="p-4">
                                {{ $ticket->category?->name ?? '-' }}
                            </td>


                            <td class="p-4 capitalize">

                                {{ str_replace(
                                    '_',
                                    ' ',
                                    $ticket->status
                                ) }}

                            </td>


                            <td class="p-4 text-sm text-gray-500">

                                {{ $ticket->created_at->format(
                                    'd M Y'
                                ) }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="text-center p-8 text-gray-500"
                            >
                                No tickets available.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


<!-- UNANSWERED AI QUESTIONS -->

<div>

    <h2 class="text-xl font-bold text-gray-800 mb-4">
        Unanswered AI Questions
    </h2>


    <div class="bg-white rounded-xl shadow-sm overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-50">

                <tr>

                    <th class="text-left p-4">
                        Student
                    </th>

                    <th class="text-left p-4">
                        Question
                    </th>

                    <th class="text-left p-4">
                        Date
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y">

                @forelse(
                    $recentUnansweredQuestions
                    as $item
                )

                    <tr>

                        <td class="p-4">

                            {{ $item->user?->name
                                ?? 'Unknown Student'
                            }}

                        </td>


                        <td class="p-4">

                            {{ $item->question }}

                        </td>


                        <td class="p-4 text-gray-500 text-sm">

                            {{ $item->created_at->format(
                                'd M Y, h:i A'
                            ) }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="3"
                            class="text-center p-8 text-gray-500"
                        >
                            No unanswered AI questions.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
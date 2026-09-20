@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('page-title', 'Dashboard')

@section('content')

<!-- WELCOME -->

<div class="mb-8">

    <h1 class="text-3xl font-bold text-gray-800">
        Welcome, {{ auth()->user()->name }} 👋
    </h1>

    <p class="text-gray-500 mt-2">
        Overview of the AI Student Support System.
    </p>

</div>


<!-- MAIN STATISTICS -->

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    <!-- STUDENTS -->

    <div class="bg-white rounded-xl shadow-sm p-6">

        <p class="text-gray-500 text-sm">
            Students
        </p>

        <h2 class="text-3xl font-bold mt-2 text-blue-600">
            {{ $studentsCount }}
        </h2>

    </div>


    <!-- STAFF -->

    <div class="bg-white rounded-xl shadow-sm p-6">

        <p class="text-gray-500 text-sm">
            Staff
        </p>

        <h2 class="text-3xl font-bold mt-2 text-purple-600">
            {{ $staffCount }}
        </h2>

    </div>


    <!-- TOTAL TICKETS -->

    <div class="bg-white rounded-xl shadow-sm p-6">

        <p class="text-gray-500 text-sm">
            Total Tickets
        </p>

        <h2 class="text-3xl font-bold mt-2">
            {{ $totalTickets }}
        </h2>

    </div>


    <!-- PENDING -->

    <div class="bg-white rounded-xl shadow-sm p-6">

        <p class="text-gray-500 text-sm">
            Pending Tickets
        </p>

        <h2 class="text-3xl font-bold mt-2 text-yellow-600">
            {{ $pendingTickets }}
        </h2>

    </div>


    <!-- AI QUESTIONS -->

    <div class="bg-white rounded-xl shadow-sm p-6">

        <p class="text-gray-500 text-sm">
            AI Questions
        </p>

        <h2 class="text-3xl font-bold mt-2 text-indigo-600">
            {{ $aiQuestionsCount }}
        </h2>

    </div>


    <!-- UNANSWERED AI -->

    <div class="bg-white rounded-xl shadow-sm p-6">

        <p class="text-gray-500 text-sm">
            Unanswered AI
        </p>

        <h2 class="text-3xl font-bold mt-2 text-red-600">
            {{ $unansweredAiCount }}
        </h2>

    </div>


    <!-- KNOWLEDGE BASE -->

    <div class="bg-white rounded-xl shadow-sm p-6">

        <p class="text-gray-500 text-sm">
            Knowledge Articles
        </p>

        <h2 class="text-3xl font-bold mt-2 text-green-600">
            {{ $knowledgeArticlesCount }}
        </h2>

    </div>


    <!-- NOTICES -->

    <div class="bg-white rounded-xl shadow-sm p-6">

        <p class="text-gray-500 text-sm">
            Notices
        </p>

        <h2 class="text-3xl font-bold mt-2 text-orange-600">
            {{ $noticesCount }}
        </h2>

    </div>

</div>


<!-- SMALL SYSTEM INFO -->

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">

    <div class="bg-white rounded-xl shadow-sm p-6">

        <p class="text-gray-500">
            Categories
        </p>

        <h2 class="text-2xl font-bold mt-2">
            {{ $categoriesCount }}
        </h2>

    </div>


    <div class="bg-white rounded-xl shadow-sm p-6">

        <p class="text-gray-500">
            FAQs
        </p>

        <h2 class="text-2xl font-bold mt-2">
            {{ $faqsCount }}
        </h2>

    </div>

</div>


<!-- CHARTS -->

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-10">

    <!-- TICKET STATUS CHART -->

    <div class="bg-white rounded-xl shadow-sm p-6">

        <h2 class="text-xl font-bold text-gray-800 mb-6">
            Ticket Status Overview
        </h2>

        <div class="h-80">
            <canvas id="ticketStatusChart"></canvas>
        </div>

    </div>


    <!-- CATEGORY CHART -->

    <div class="bg-white rounded-xl shadow-sm p-6">

        <h2 class="text-xl font-bold text-gray-800 mb-6">
            Tickets by Category
        </h2>

        <div class="h-80">
            <canvas id="categoryChart"></canvas>
        </div>

    </div>

</div>


<!-- QUICK MANAGEMENT -->

<div class="mt-10">

    <h2 class="text-xl font-bold text-gray-800 mb-5">
        Quick Management
    </h2>


    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">


        <a
            href="{{ route('admin.students') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl p-6"
        >

            <h3 class="font-bold text-lg">
                Students
            </h3>

            <p class="mt-2 text-blue-100">
                Manage student accounts.
            </p>

        </a>


        <a
            href="{{ route('admin.staff') }}"
            class="bg-purple-600 hover:bg-purple-700 text-white rounded-xl p-6"
        >

            <h3 class="font-bold text-lg">
                Staff
            </h3>

            <p class="mt-2 text-purple-100">
                Manage staff accounts.
            </p>

        </a>


        <a
            href="{{ route('admin.knowledge.index') }}"
            class="bg-green-600 hover:bg-green-700 text-white rounded-xl p-6"
        >

            <h3 class="font-bold text-lg">
                Knowledge Base
            </h3>

            <p class="mt-2 text-green-100">
                Manage AI knowledge.
            </p>

        </a>


        <a
            href="{{ route('admin.reports') }}"
            class="bg-orange-600 hover:bg-orange-700 text-white rounded-xl p-6"
        >

            <h3 class="font-bold text-lg">
                Reports
            </h3>

            <p class="mt-2 text-orange-100">
                View analytics and reports.
            </p>

        </a>

    </div>

</div>


<!-- RECENT TICKETS -->

<div class="mt-10">

    <h2 class="text-xl font-bold text-gray-800 mb-5">
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

                                {{ $ticket->user?->name
                                    ?? 'Unknown'
                                }}

                            </td>


                            <td class="p-4">

                                {{ $ticket->category?->name
                                    ?? '-'
                                }}

                            </td>


                            <td class="p-4">

                                <span class="capitalize">

                                    {{ str_replace(
                                        '_',
                                        ' ',
                                        $ticket->status
                                    ) }}

                                </span>

                            </td>


                            <td class="p-4 text-gray-500">

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
                                No support tickets available.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


<!-- RECENT AI ACTIVITY -->

<div class="mt-10">

    <div class="flex justify-between items-center mb-5">

        <h2 class="text-xl font-bold text-gray-800">
            Recent AI Questions
        </h2>

        <a
            href="{{ route('admin.reports') }}"
            class="text-blue-600 hover:underline"
        >
            View Reports
        </a>

    </div>


    <div class="bg-white rounded-xl shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

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
                            Result
                        </th>

                        <th class="text-left p-4">
                            Date
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y">

                    @forelse($recentAiQuestions as $item)

                        <tr>

                            <td class="p-4">

                                {{ $item->user?->name
                                    ?? 'Unknown'
                                }}

                            </td>


                            <td class="p-4">

                                {{ \Illuminate\Support\Str::limit(
                                    $item->question,
                                    70
                                ) }}

                            </td>


                            <td class="p-4">

                                @if($item->found_answer)

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                        Answer Found
                                    </span>

                                @else

                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                                        No Answer
                                    </span>

                                @endif

                            </td>


                            <td class="p-4 text-gray-500">

                                {{ $item->created_at->format(
                                    'd M Y'
                                ) }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="4"
                                class="text-center p-8 text-gray-500"
                            >
                                No AI activity available.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


<!-- CHART.JS -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        // =========================================
        // TICKET STATUS CHART
        // =========================================

        const ticketCanvas =
            document.getElementById(
                'ticketStatusChart'
            );


        if (ticketCanvas) {

            new Chart(
                ticketCanvas,
                {

                    type: 'doughnut',

                    data: {

                        labels: [
                            'Pending',
                            'In Progress',
                            'Resolved',
                            'Closed'
                        ],

                        datasets: [{

                            data: [
                                {{ $pendingTickets }},
                                {{ $inProgressTickets }},
                                {{ $resolvedTickets }},
                                {{ $closedTickets }}
                            ],

                            backgroundColor: [
                                '#f59e0b',
                                '#3b82f6',
                                '#10b981',
                                '#64748b'
                            ],

                            borderWidth: 0

                        }]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false

                    }

                }
            );
        }


        // =========================================
        // CATEGORY CHART
        // =========================================

        const categoryCanvas =
            document.getElementById(
                'categoryChart'
            );


        if (categoryCanvas) {

            new Chart(
                categoryCanvas,
                {

                    type: 'bar',

                    data: {

                        labels:
                            @json($categoryNames),

                        datasets: [{

                            label: 'Tickets',

                            data:
                                @json($categoryTicketCounts),

                            backgroundColor:
                                '#2563eb',

                            borderRadius: 6

                        }]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        scales: {

                            y: {

                                beginAtZero: true,

                                ticks: {

                                    precision: 0

                                }

                            }

                        }

                    }

                }
            );
        }

    }
);

</script>

@endsection
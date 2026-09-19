<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Support Tickets
        </h2>
    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">

                <div class="p-6 border-b">

                    <h1 class="text-2xl font-bold">
                        Student Support Tickets
                    </h1>

                    <p class="text-gray-500 mt-1">
                        View and manage student support requests.
                    </p>

                </div>


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
                                Priority
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

                        @forelse($tickets as $ticket)

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
                                    {{ $ticket->priority }}
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
                                    colspan="6"
                                    class="p-10 text-center text-gray-500"
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

    </div>

</x-app-layout>
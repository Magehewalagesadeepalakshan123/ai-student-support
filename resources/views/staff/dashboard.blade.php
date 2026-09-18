<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Staff Dashboard
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900">

                    <h1 class="text-2xl font-bold">
                        Welcome, {{ auth()->user()->name }}
                    </h1>

                    <p class="mt-3">
                        You are logged in as
                        <strong>Staff</strong>.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">

                        <div class="bg-green-100 p-5 rounded-lg">
                            New Tickets
                        </div>

                        <div class="bg-yellow-100 p-5 rounded-lg">
                            Pending Tickets
                        </div>

                        <div class="bg-blue-100 p-5 rounded-lg">
                            Resolved Tickets
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
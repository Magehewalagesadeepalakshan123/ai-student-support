<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Student Portal')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

<div class="min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-slate-900 text-white min-h-screen">

        <div class="p-6 border-b border-slate-700">
            <h1 class="text-xl font-bold">
                AI Student Support
            </h1>

            <p class="text-sm text-slate-400 mt-1">
                Student Portal
            </p>
        </div>


        <nav class="p-4 space-y-2">

            <a href="{{ route('student.dashboard') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700">
                Dashboard
            </a>

            <a href="{{ route('student.ai') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700">
                AI Assistant
            </a>

            <a href="{{ route('student.tickets') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700">
                My Tickets
            </a>

            <a href="{{ route('student.faqs') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700">
                FAQs
            </a>

            <a href="{{ route('student.notices') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700">
                Notices
            </a>

            <a href="{{ route('profile.edit') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700">
                Profile
            </a>

        </nav>


        <div class="p-4 mt-10">

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 px-4 py-3 rounded-lg">
                    Logout
                </button>
            </form>

        </div>

    </aside>


    <!-- MAIN AREA -->
    <main class="flex-1">

        <!-- TOP BAR -->
        <header class="bg-white shadow-sm px-8 py-5 flex justify-between items-center">

            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    @yield('page-title')
                </h2>
            </div>

            <div class="text-right">

                <p class="font-medium text-gray-800">
                    {{ auth()->user()->name }}
                </p>

                <p class="text-sm text-gray-500">
                    Student
                </p>

            </div>

        </header>


        <!-- CONTENT -->
        <section class="p-8">

            @yield('content')

        </section>

    </main>

</div>

</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Admin Portal')
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="bg-gray-100">

<div class="min-h-screen flex">

    <!-- SIDEBAR -->

    <aside class="w-64 bg-slate-900 text-white min-h-screen flex flex-col">

        <div class="p-6 border-b border-slate-700">

            <h1 class="text-xl font-bold">
                AI Student Support
            </h1>

            <p class="text-sm text-slate-400 mt-1">
                Admin Portal
            </p>

        </div>


        <nav class="p-4 space-y-2 flex-1">

            <a
                href="{{ route('admin.dashboard') }}"
                class="block px-4 py-3 rounded-lg hover:bg-slate-700"
            >
                Dashboard
            </a>


            <a
    href="{{ route('admin.students') }}"
    class="block px-4 py-3 rounded-lg hover:bg-slate-700"
>
    Students
</a>


            <a
    href="{{ route('admin.staff') }}"
    class="block px-4 py-3 rounded-lg hover:bg-slate-700"
>
    Staff
</a>


            <a
    href="{{ route('admin.categories.index') }}"
    class="block px-4 py-3 rounded-lg hover:bg-slate-700"
>
    Categories
</a>


            <a
                href="#"
                class="block px-4 py-3 rounded-lg hover:bg-slate-700"
            >
                Support Tickets
            </a>


           <a
    href="{{ route('admin.faqs.index') }}"
    class="block px-4 py-3 rounded-lg hover:bg-slate-700"
>
    FAQs
</a>


            <a
    href="{{ route('admin.notices.index') }}"
    class="block px-4 py-3 rounded-lg hover:bg-slate-700"
>
    Notices
</a>
            <a
    href="{{ route('admin.knowledge.index') }}"
    class="block px-4 py-3 rounded-lg hover:bg-slate-700"
>
    Knowledge Base
</a>


            <a
                href="#"
                class="block px-4 py-3 rounded-lg hover:bg-slate-700"
            >
                Reports
            </a>


            <a
                href="{{ route('profile.edit') }}"
                class="block px-4 py-3 rounded-lg hover:bg-slate-700"
            >
                Profile
            </a>

        </nav>


        <div class="p-4">

            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 px-4 py-3 rounded-lg"
                >
                    Logout
                </button>

            </form>

        </div>

    </aside>


    <!-- MAIN CONTENT -->

    <main class="flex-1">

        <header
            class="bg-white shadow-sm px-8 py-5 flex justify-between items-center"
        >

            <h2 class="text-xl font-semibold text-gray-800">
                @yield('page-title')
            </h2>


            <div class="text-right">

                <p class="font-medium text-gray-800">
                    {{ auth()->user()->name }}
                </p>

                <p class="text-sm text-gray-500">
                    Administrator
                </p>

            </div>

        </header>


        <section class="p-8">

            @yield('content')

        </section>

    </main>

</div>

</body>

</html>
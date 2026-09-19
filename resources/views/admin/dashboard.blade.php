@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('page-title', 'Dashboard')

@section('content')

<div class="mb-8">

    <h1 class="text-3xl font-bold text-gray-800">
        Welcome, {{ auth()->user()->name }} 👋
    </h1>

    <p class="text-gray-500 mt-2">
        Manage the AI Student Support System.
    </p>

</div>


<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    <div class="bg-white rounded-xl shadow-sm p-6">

        <p class="text-gray-500">
            Students
        </p>

        <h2 class="text-3xl font-bold mt-2">
            0
        </h2>

    </div>


    <div class="bg-white rounded-xl shadow-sm p-6">

        <p class="text-gray-500">
            Staff
        </p>

        <h2 class="text-3xl font-bold mt-2">
            0
        </h2>

    </div>


    <div class="bg-white rounded-xl shadow-sm p-6">

        <p class="text-gray-500">
            Total Tickets
        </p>

        <h2 class="text-3xl font-bold mt-2">
            0
        </h2>

    </div>


    <div class="bg-white rounded-xl shadow-sm p-6">

        <p class="text-gray-500">
            Pending Tickets
        </p>

        <h2 class="text-3xl font-bold mt-2 text-yellow-600">
            0
        </h2>

    </div>

</div>


<div class="mt-10">

    <h2 class="text-xl font-bold mb-5">
        System Management
    </h2>


    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">


        <div class="bg-blue-600 text-white p-6 rounded-xl">

            <h3 class="text-xl font-bold">
                User Management
            </h3>

            <p class="mt-2">
                Manage students and staff accounts.
            </p>

        </div>


        <div class="bg-emerald-600 text-white p-6 rounded-xl">

            <h3 class="text-xl font-bold">
                Support Management
            </h3>

            <p class="mt-2">
                Monitor support tickets and categories.
            </p>

        </div>


        <div class="bg-violet-600 text-white p-6 rounded-xl">

            <h3 class="text-xl font-bold">
                Knowledge Base
            </h3>

            <p class="mt-2">
                Manage AI support information.
            </p>

        </div>


    </div>

</div>

@endsection
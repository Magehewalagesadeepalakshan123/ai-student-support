@extends('student.layout')

@section('title', 'FAQs')

@section('page-title', 'Frequently Asked Questions')

@section('content')

<div class="space-y-4">

    <div class="bg-white rounded-xl shadow-sm p-6">

        <h3 class="font-bold text-lg">
            How can I reset my password?
        </h3>

        <p class="text-gray-600 mt-2">
            Use the Forgot Password option on the login page.
        </p>

    </div>


    <div class="bg-white rounded-xl shadow-sm p-6">

        <h3 class="font-bold text-lg">
            How do I submit a support request?
        </h3>

        <p class="text-gray-600 mt-2">
            Open My Tickets and select Create Ticket.
        </p>

    </div>


    <div class="bg-white rounded-xl shadow-sm p-6">

        <h3 class="font-bold text-lg">
            How can I contact student support?
        </h3>

        <p class="text-gray-600 mt-2">
            You can create a support ticket through this system.
        </p>

    </div>

</div>

@endsection
@extends('student.layout')

@section('title', 'AI Assistant')

@section('page-title', 'AI Assistant')

@section('content')

<div class="max-w-4xl">

    <div class="bg-white rounded-xl shadow-sm">

        <div class="border-b p-5">

            <h2 class="text-xl font-bold">
                AI Student Assistant
            </h2>

            <p class="text-gray-500 text-sm mt-1">
                Ask questions about university services and academic support.
            </p>

        </div>


        <div class="p-6 min-h-[400px] bg-gray-50">

            <div class="bg-blue-100 p-4 rounded-xl max-w-xl">

                <p class="font-medium">
                    AI Assistant
                </p>

                <p class="mt-1">
                    Hello! How can I help you today?
                </p>

            </div>

        </div>


        <div class="p-5 border-t">

            <form class="flex gap-3">

                <input
                    type="text"
                    placeholder="Type your question..."
                    class="flex-1 rounded-lg border-gray-300"
                >

                <button
                    type="button"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg">

                    Send

                </button>

            </form>

        </div>

    </div>

</div>

@endsection
@extends('student.layout')

@section('title', 'Create Ticket')

@section('page-title', 'Create Support Ticket')

@section('content')

<div class="max-w-3xl">

    <div class="bg-white rounded-xl shadow-sm p-8">

        <div class="mb-6">

            <h1 class="text-2xl font-bold text-gray-800">
                Create Support Ticket
            </h1>

            <p class="text-gray-500 mt-1">
                Describe your issue and our support team will help you.
            </p>

        </div>


        @if($errors->any())

            <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-6">

                <ul class="list-disc ml-5">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        <form
            method="POST"
            action="{{ route('student.tickets.store') }}"
            class="space-y-6"
        >

            @csrf


            <div>

                <label class="block font-medium mb-2">
                    Category
                </label>

                <select
                    name="category_id"
                    class="w-full rounded-lg border-gray-300"
                    required
                >

                    <option value="">
                        Select Category
                    </option>

                    @foreach($categories as $category)

                        <option
                            value="{{ $category->id }}"
                            @selected(
                                old('category_id')
                                == $category->id
                            )
                        >
                            {{ $category->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div>

                <label class="block font-medium mb-2">
                    Subject
                </label>

                <input
                    type="text"
                    name="subject"
                    value="{{ old('subject') }}"
                    class="w-full rounded-lg border-gray-300"
                    placeholder="Enter ticket subject"
                    required
                >

            </div>


            <div>

                <label class="block font-medium mb-2">
                    Priority
                </label>

                <select
                    name="priority"
                    class="w-full rounded-lg border-gray-300"
                    required
                >

                    <option value="low">
                        Low
                    </option>

                    <option
                        value="normal"
                        selected
                    >
                        Normal
                    </option>

                    <option value="high">
                        High
                    </option>

                </select>

            </div>


            <div>

                <label class="block font-medium mb-2">
                    Description
                </label>

                <textarea
                    name="description"
                    rows="7"
                    class="w-full rounded-lg border-gray-300"
                    placeholder="Describe your problem..."
                    required
                >{{ old('description') }}</textarea>

            </div>


            <div class="flex gap-3">

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg"
                >
                    Submit Ticket
                </button>


                <a
                    href="{{ route('student.tickets') }}"
                    class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg"
                >
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection
@extends('student.layout')

@section('title', 'FAQs')

@section('page-title', 'Frequently Asked Questions')

@section('content')

<div class="mb-8">

    <h1 class="text-2xl font-bold text-gray-800">
        Frequently Asked Questions
    </h1>

    <p class="text-gray-500 mt-1">
        Find quick answers to common student support questions.
    </p>

</div>


<!-- SEARCH -->

<form
    method="GET"
    action="{{ route('student.faqs') }}"
    class="bg-white p-5 rounded-xl shadow-sm mb-6"
>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="md:col-span-2">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search FAQs..."
                class="w-full rounded-lg border-gray-300"
            >

        </div>


        <div>

            <select
                name="category"
                class="w-full rounded-lg border-gray-300"
            >

                <option value="">
                    All Categories
                </option>


                @foreach($categories as $category)

                    <option
                        value="{{ $category->id }}"
                        @selected(
                            request('category')
                            == $category->id
                        )
                    >
                        {{ $category->name }}
                    </option>

                @endforeach

            </select>

        </div>

    </div>


    <div class="mt-4">

        <button
            type="submit"
            class="bg-blue-600 text-white px-5 py-2 rounded-lg"
        >
            Search
        </button>


        <a
            href="{{ route('student.faqs') }}"
            class="ml-3 text-gray-500 hover:underline"
        >
            Clear
        </a>

    </div>

</form>


<!-- FAQ LIST -->

<div class="space-y-4">

    @forelse($faqs as $faq)

        <details class="bg-white rounded-xl shadow-sm p-6">

            <summary
                class="font-bold text-lg cursor-pointer"
            >
                {{ $faq->question }}
            </summary>


            <div class="mt-4">

                @if($faq->category)

                    <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm mb-3">

                        {{ $faq->category->name }}

                    </span>

                @endif


                <p class="text-gray-600 whitespace-pre-line">

                    {{ $faq->answer }}

                </p>

            </div>

        </details>

    @empty

        <div class="bg-white rounded-xl p-10 text-center">

            <p class="text-gray-500">
                No FAQs found.
            </p>

        </div>

    @endforelse

</div>

@endsection
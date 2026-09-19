@extends('student.layout')

@section('title', 'AI Assistant')

@section('page-title', 'AI Assistant')

@section('content')

<div class="max-w-5xl">

    <!-- PAGE HEADER -->

    <div class="mb-8">

        <h1 class="text-3xl font-bold text-gray-800">
            AI Student Assistant
        </h1>

        <p class="text-gray-500 mt-2">
            Ask a question about university services,
            IT support, examinations, payments,
            registration, or other student services.
        </p>

    </div>


    <!-- AI CARD -->

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

        <!-- HEADER -->

        <div class="bg-blue-600 text-white p-6">

            <div class="flex items-center gap-4">

                <div class="bg-white/20 w-12 h-12 rounded-full flex items-center justify-center text-2xl">
                    🤖
                </div>

                <div>

                    <h2 class="text-xl font-bold">
                        Student Support AI
                    </h2>

                    <p class="text-blue-100 text-sm">
                        Powered by the university knowledge base
                    </p>

                </div>

            </div>

        </div>


        <div class="p-6 md:p-8">

            <!-- QUESTION FORM -->

            <form
                method="POST"
                action="{{ route('student.ai.ask') }}"
            >

                @csrf

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    What would you like to know?
                </label>


                <textarea
                    name="question"
                    rows="4"
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Example: How can I reset my student portal password?"
                    required
                >{{ old('question', $question ?? '') }}</textarea>


                @error('question')

                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>

                @enderror


                <div class="mt-4 flex flex-wrap gap-3">

                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium"
                    >
                        Ask Assistant
                    </button>


                    <a
                        href="{{ route('student.ai') }}"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg"
                    >
                        Clear
                    </a>

                </div>

            </form>


            <!-- ANSWER -->

            @isset($answer)

                <div class="mt-8 border-t pt-8">

                    <div class="flex gap-4">

                        <div class="flex-shrink-0">

                            <div class="bg-blue-100 text-blue-700 w-10 h-10 rounded-full flex items-center justify-center">
                                🤖
                            </div>

                        </div>


                        <div class="flex-1">

                            <p class="font-semibold text-gray-800 mb-3">
                                AI Assistant
                            </p>


                            <div class="bg-blue-50 border border-blue-100 rounded-xl p-5">

                                <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                                    {{ $answer }}
                                </p>

                            </div>


                            @if($article)

    <div class="mt-5 border-t border-blue-100 pt-4">

        <div class="flex flex-wrap items-center gap-3">

            <div>

                <p class="text-sm text-gray-500">
                    Knowledge Source
                </p>

                <p class="font-semibold text-gray-800">
                    {{ $article->title }}
                </p>

            </div>


            @if($article->category)

                <span
                    class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm"
                >
                    {{ $article->category->name }}
                </span>

            @endif


            @isset($confidenceLabel)

                @if($confidenceLabel === 'High')

                    <span
                        class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm"
                    >
                        High Confidence
                    </span>

                @elseif($confidenceLabel === 'Medium')

                    <span
                        class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm"
                    >
                        Medium Confidence
                    </span>

                @else

                    <span
                        class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm"
                    >
                        Low Confidence
                    </span>

                @endif

            @endisset

        </div>


        @isset($confidencePercent)

            <div class="mt-4">

                <div class="flex justify-between text-sm mb-1">

                    <span class="text-gray-500">
                        Match confidence
                    </span>

                    <span class="font-semibold">
                        {{ $confidencePercent }}%
                    </span>

                </div>


                <div class="w-full bg-gray-200 rounded-full h-2">

                    <div
                        class="bg-blue-600 h-2 rounded-full"
                        style="width: {{ $confidencePercent }}%"
                    ></div>

                </div>

            </div>

        @endisset

    </div>

@endif

                        </div>

                    </div>

                </div>

            @endisset


            <!-- RELATED ARTICLES -->

            @isset($relatedArticles)

                @if($relatedArticles->isNotEmpty())

                    <div class="mt-8 border-t pt-6">

                        <h3 class="font-bold text-gray-800 mb-4">
                            Related Information
                        </h3>


                        <div class="space-y-3">

                            @foreach($relatedArticles as $related)

                                <div class="bg-gray-50 rounded-lg p-4">

                                    <p class="font-semibold text-gray-800">
                                        {{ $related->title }}
                                    </p>

                                    <p class="text-sm text-gray-500 mt-1">

                                        {{ \Illuminate\Support\Str::limit(
                                            $related->content,
                                            120
                                        ) }}

                                    </p>

                                </div>

                            @endforeach

                        </div>

                    </div>

                @endif

            @endisset

        </div>

    </div>


    <!-- SUGGESTIONS -->

    <div class="mt-8">

        <h2 class="text-lg font-bold text-gray-800 mb-4">
            Try asking
        </h2>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div class="bg-white rounded-xl p-5 shadow-sm">
                How can I reset my student portal password?
            </div>

            <div class="bg-white rounded-xl p-5 shadow-sm">
                How can I contact IT support?
            </div>

            <div class="bg-white rounded-xl p-5 shadow-sm">
                How do I register for a semester?
            </div>

            <div class="bg-white rounded-xl p-5 shadow-sm">
                Where can I find examination information?
            </div>

        </div>

    </div>


    <!-- HELP -->

    <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-xl p-6">

        <h3 class="font-bold text-gray-800">
            Can't find the answer?
        </h3>

        <p class="text-gray-600 mt-2">
            Create a support ticket and a staff member can assist you.
        </p>

        <a
            href="{{ route('student.tickets.create') }}"
            class="inline-block mt-4 bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg"
        >
            Create Support Ticket
        </a>

    </div>

</div>

@endsection
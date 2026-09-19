@extends('student.layout')

@section('title', 'AI History')

@section('page-title', 'AI Question History')

@section('content')

<div class="mb-8">

    <h1 class="text-2xl font-bold text-gray-800">
        AI Question History
    </h1>

    <p class="text-gray-500 mt-1">
        View your previous questions and answers.
    </p>

</div>


<div class="mb-6">

    <a
        href="{{ route('student.ai') }}"
        class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg"
    >
        Ask New Question
    </a>

</div>


<div class="space-y-5">

    @forelse($questions as $item)

        <div class="bg-white rounded-xl shadow-sm p-6">


            <!-- QUESTION -->

            <div>

                <p class="text-sm text-gray-500">
                    Your Question
                </p>

                <h2 class="text-lg font-bold text-gray-800 mt-1">
                    {{ $item->question }}
                </h2>

            </div>


            <!-- ANSWER -->

            <div class="mt-5 bg-blue-50 border border-blue-100 rounded-xl p-5">

                <p class="text-sm font-semibold text-blue-700 mb-2">
                    Assistant Answer
                </p>


                <p class="text-gray-700 whitespace-pre-line">
                    {{ $item->answer }}
                </p>

            </div>


            <!-- INFORMATION -->

            <div class="mt-5 flex flex-wrap gap-3 items-center">

                @if($item->found_answer)

                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                        Answer Found
                    </span>

                @else

                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                        No Matching Article
                    </span>

                @endif


                @if($item->knowledgeArticle)

                    <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm">

                        Source:
                        {{ $item->knowledgeArticle->title }}

                    </span>

                @endif


                <span class="text-sm text-gray-400">

                    {{ $item->created_at->format(
                        'd M Y, h:i A'
                    ) }}

                </span>

            </div>

        </div>

    @empty

        <div class="bg-white rounded-xl p-10 text-center shadow-sm">

            <h2 class="font-semibold text-gray-700">
                No AI questions yet
            </h2>

            <p class="text-gray-500 mt-2">
                Ask the AI Assistant your first question.
            </p>

        </div>

    @endforelse

</div>


<div class="mt-8">

    {{ $questions->links() }}

</div>

@endsection
@extends('admin.layout')

@section('title', 'Edit FAQ')

@section('page-title', 'Edit FAQ')

@section('content')

<div class="max-w-3xl">

    <div class="mb-5">

        <a
            href="{{ route('admin.faqs.index') }}"
            class="text-blue-600 hover:underline"
        >
            ← Back to FAQs
        </a>

    </div>


    <div class="bg-white rounded-xl shadow-sm p-8">

        <h1 class="text-2xl font-bold mb-6">
            Edit FAQ
        </h1>


        <form
            method="POST"
            action="{{ route(
                'admin.faqs.update',
                $faq
            ) }}"
            class="space-y-6"
        >

            @csrf
            @method('PUT')


            <div>

                <label class="block font-medium mb-2">
                    Category
                </label>


                <select
                    name="category_id"
                    class="w-full rounded-lg border-gray-300"
                >

                    <option value="">
                        General
                    </option>


                    @foreach($categories as $category)

                        <option
                            value="{{ $category->id }}"
                            @selected(
                                old(
                                    'category_id',
                                    $faq->category_id
                                )
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
                    Question
                </label>


                <input
                    type="text"
                    name="question"
                    value="{{ old(
                        'question',
                        $faq->question
                    ) }}"
                    class="w-full rounded-lg border-gray-300"
                    required
                >

            </div>


            <div>

                <label class="block font-medium mb-2">
                    Answer
                </label>


                <textarea
                    name="answer"
                    rows="7"
                    class="w-full rounded-lg border-gray-300"
                    required
                >{{ old(
                    'answer',
                    $faq->answer
                ) }}</textarea>

            </div>


            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg"
            >
                Save Changes
            </button>

        </form>

    </div>

</div>

@endsection
@extends('admin.layout')

@section('title', 'Add FAQ')

@section('page-title', 'Create FAQ')

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
            Add FAQ
        </h1>


        <form
            method="POST"
            action="{{ route('admin.faqs.store') }}"
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
                >

                    <option value="">
                        General
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
                    Question
                </label>


                <input
                    type="text"
                    name="question"
                    value="{{ old('question') }}"
                    class="w-full rounded-lg border-gray-300"
                    placeholder="Enter FAQ question"
                    required
                >


                @error('question')

                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            <div>

                <label class="block font-medium mb-2">
                    Answer
                </label>


                <textarea
                    name="answer"
                    rows="7"
                    class="w-full rounded-lg border-gray-300"
                    placeholder="Enter the answer..."
                    required
                >{{ old('answer') }}</textarea>


                @error('answer')

                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg"
            >
                Create FAQ
            </button>

        </form>

    </div>

</div>

@endsection
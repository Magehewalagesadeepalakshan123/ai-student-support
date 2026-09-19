@extends('admin.layout')

@section('title', 'Add Knowledge Article')

@section('page-title', 'Add Knowledge Article')

@section('content')

<div class="max-w-3xl">

    <div class="mb-5">

        <a
            href="{{ route('admin.knowledge.index') }}"
            class="text-blue-600 hover:underline"
        >
            ← Back to Knowledge Base
        </a>

    </div>


    <div class="bg-white rounded-xl shadow-sm p-8">

        <h1 class="text-2xl font-bold mb-6">
            Create Knowledge Article
        </h1>


        <form
            method="POST"
            action="{{ route('admin.knowledge.store') }}"
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
                    Article Title
                </label>

                <input
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
                    class="w-full rounded-lg border-gray-300"
                    placeholder="Example: How to reset your portal password"
                    required
                >

                @error('title')
                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            <div>

                <label class="block font-medium mb-2">
                    Content
                </label>

                <textarea
                    name="content"
                    rows="10"
                    class="w-full rounded-lg border-gray-300"
                    placeholder="Enter detailed information..."
                    required
                >{{ old('content') }}</textarea>

                @error('content')
                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            <div>

                <label class="block font-medium mb-2">
                    Keywords
                </label>

                <input
                    type="text"
                    name="keywords"
                    value="{{ old('keywords') }}"
                    class="w-full rounded-lg border-gray-300"
                    placeholder="password, reset, login, account"
                >

                <p class="text-sm text-gray-500 mt-1">
                    Separate keywords using commas.
                </p>

            </div>


            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg"
            >
                Save Article
            </button>

        </form>

    </div>

</div>

@endsection
@extends('admin.layout')

@section('title', 'Add Category')

@section('page-title', 'Create Category')

@section('content')

<div class="max-w-2xl">

    <div class="mb-5">

        <a
            href="{{ route('admin.categories.index') }}"
            class="text-blue-600 hover:underline"
        >
            ← Back to Categories
        </a>

    </div>


    <div class="bg-white rounded-xl shadow-sm p-8">

        <h1 class="text-2xl font-bold mb-6">
            Add Support Category
        </h1>


        <form
            method="POST"
            action="{{ route('admin.categories.store') }}"
            class="space-y-6"
        >

            @csrf


            <div>

                <label class="block font-medium mb-2">
                    Category Name
                </label>


                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full rounded-lg border-gray-300"
                    placeholder="Example: IT Support"
                    required
                >


                @error('name')

                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            <div>

                <label class="block font-medium mb-2">
                    Description
                </label>


                <textarea
                    name="description"
                    rows="5"
                    class="w-full rounded-lg border-gray-300"
                    placeholder="Describe this category..."
                >{{ old('description') }}</textarea>


                @error('description')

                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg"
            >
                Create Category
            </button>

        </form>

    </div>

</div>

@endsection
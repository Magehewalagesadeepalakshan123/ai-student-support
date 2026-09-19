@extends('admin.layout')

@section('title', 'Add Notice')

@section('page-title', 'Create Notice')

@section('content')

<div class="max-w-3xl">

    <div class="mb-5">
        <a
            href="{{ route('admin.notices.index') }}"
            class="text-blue-600 hover:underline"
        >
            ← Back to Notices
        </a>
    </div>


    <div class="bg-white rounded-xl shadow-sm p-8">

        <h1 class="text-2xl font-bold mb-6">
            Create New Notice
        </h1>


        <form
            method="POST"
            action="{{ route('admin.notices.store') }}"
            class="space-y-6"
        >

            @csrf


            <div>

                <label class="block font-medium mb-2">
                    Notice Title
                </label>

                <input
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
                    class="w-full rounded-lg border-gray-300"
                    placeholder="Example: Semester Registration Notice"
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
                    Notice Content
                </label>

                <textarea
                    name="content"
                    rows="8"
                    class="w-full rounded-lg border-gray-300"
                    placeholder="Enter notice details..."
                    required
                >{{ old('content') }}</textarea>

                @error('content')
                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>

                    <label class="block font-medium mb-2">
                        Publish Date & Time
                    </label>

                    <input
                        type="datetime-local"
                        name="published_at"
                        value="{{ old('published_at') }}"
                        class="w-full rounded-lg border-gray-300"
                    >

                    <p class="text-sm text-gray-500 mt-1">
                        Leave empty to publish immediately.
                    </p>

                    @error('published_at')
                        <p class="text-red-600 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <div>

                    <label class="block font-medium mb-2">
                        Expiry Date & Time
                    </label>

                    <input
                        type="datetime-local"
                        name="expires_at"
                        value="{{ old('expires_at') }}"
                        class="w-full rounded-lg border-gray-300"
                    >

                    <p class="text-sm text-gray-500 mt-1">
                        Leave empty if the notice should not expire.
                    </p>

                    @error('expires_at')
                        <p class="text-red-600 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>


            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg"
            >
                Publish Notice
            </button>

        </form>

    </div>

</div>

@endsection
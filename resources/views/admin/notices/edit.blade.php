@extends('admin.layout')

@section('title', 'Edit Notice')

@section('page-title', 'Edit Notice')

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
            Edit Notice
        </h1>


        <form
            method="POST"
            action="{{ route(
                'admin.notices.update',
                $notice
            ) }}"
            class="space-y-6"
        >

            @csrf
            @method('PUT')


            <div>

                <label class="block font-medium mb-2">
                    Notice Title
                </label>

                <input
                    type="text"
                    name="title"
                    value="{{ old(
                        'title',
                        $notice->title
                    ) }}"
                    class="w-full rounded-lg border-gray-300"
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
                    required
                >{{ old(
                    'content',
                    $notice->content
                ) }}</textarea>

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
                        value="{{ old(
                            'published_at',
                            $notice->published_at
                                ? $notice->published_at->format('Y-m-d\TH:i')
                                : ''
                        ) }}"
                        class="w-full rounded-lg border-gray-300"
                    >

                </div>


                <div>

                    <label class="block font-medium mb-2">
                        Expiry Date & Time
                    </label>

                    <input
                        type="datetime-local"
                        name="expires_at"
                        value="{{ old(
                            'expires_at',
                            $notice->expires_at
                                ? $notice->expires_at->format('Y-m-d\TH:i')
                                : ''
                        ) }}"
                        class="w-full rounded-lg border-gray-300"
                    >

                </div>

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
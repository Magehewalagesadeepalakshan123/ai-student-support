@extends('student.layout')

@section('title', 'Notices')

@section('page-title', 'Notices')

@section('content')

<div class="mb-8">

    <h1 class="text-2xl font-bold text-gray-800">
        Student Notices
    </h1>

    <p class="text-gray-500 mt-1">
        Latest announcements and important updates.
    </p>

</div>


<div class="space-y-5">

    @forelse($notices as $notice)

        <div class="bg-white rounded-xl shadow-sm p-6">

            <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">

                <div>

                    <h2 class="text-xl font-bold text-gray-800">
                        {{ $notice->title }}
                    </h2>


                    <p class="text-sm text-gray-500 mt-2">

                        Published:

                        {{ $notice->published_at
                            ?->format('d M Y, h:i A')
                            ?? 'Recently'
                        }}

                    </p>

                </div>


                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm self-start">
                    Notice
                </span>

            </div>


            <div class="mt-5">

                <p class="text-gray-700 whitespace-pre-line leading-relaxed">
                    {{ $notice->content }}
                </p>

            </div>


            @if($notice->expires_at)

                <div class="mt-5 pt-4 border-t">

                    <p class="text-sm text-gray-500">

                        Available until:

                        {{ $notice->expires_at->format(
                            'd M Y, h:i A'
                        ) }}

                    </p>

                </div>

            @endif

        </div>

    @empty

        <div class="bg-white rounded-xl shadow-sm p-10 text-center">

            <h2 class="text-lg font-semibold text-gray-700">
                No notices available
            </h2>

            <p class="text-gray-500 mt-2">
                There are currently no active announcements.
            </p>

        </div>

    @endforelse

</div>

@endsection
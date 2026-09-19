@extends('admin.layout')

@section('title', 'FAQs')

@section('page-title', 'FAQ Management')

@section('content')

<div class="flex justify-between items-center mb-6">

    <div>

        <h1 class="text-2xl font-bold text-gray-800">
            Frequently Asked Questions
        </h1>

        <p class="text-gray-500 mt-1">
            Manage student support FAQs.
        </p>

    </div>


    <a
        href="{{ route('admin.faqs.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg"
    >
        + Add FAQ
    </a>

</div>


@if(session('success'))

    <div class="bg-green-100 border border-green-200 text-green-800 p-4 rounded-lg mb-6">

        {{ session('success') }}

    </div>

@endif


<div class="bg-white rounded-xl shadow-sm overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-50 border-b">

                <tr>

                    <th class="text-left p-4">
                        Question
                    </th>

                    <th class="text-left p-4">
                        Category
                    </th>

                    <th class="text-left p-4">
                        Status
                    </th>

                    <th class="text-left p-4">
                        Actions
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y">

                @forelse($faqs as $faq)

                    <tr>

                        <td class="p-4">

                            <p class="font-semibold">
                                {{ $faq->question }}
                            </p>

                            <p class="text-sm text-gray-500 mt-1">

                                {{ \Illuminate\Support\Str::limit(
                                    $faq->answer,
                                    80
                                ) }}

                            </p>

                        </td>


                        <td class="p-4">

                            {{ $faq->category?->name
                                ?? 'General'
                            }}

                        </td>


                        <td class="p-4">

                            @if($faq->status)

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                    Active
                                </span>

                            @else

                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                                    Inactive
                                </span>

                            @endif

                        </td>


                        <td class="p-4">

                            <div class="flex flex-wrap gap-2">

                                <a
                                    href="{{ route(
                                        'admin.faqs.edit',
                                        $faq
                                    ) }}"
                                    class="bg-blue-600 text-white px-3 py-2 rounded-lg text-sm"
                                >
                                    Edit
                                </a>


                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.faqs.status',
                                        $faq
                                    ) }}"
                                >

                                    @csrf
                                    @method('PATCH')


                                    <button
                                        type="submit"
                                        class="bg-yellow-500 text-white px-3 py-2 rounded-lg text-sm"
                                    >

                                        {{ $faq->status
                                            ? 'Deactivate'
                                            : 'Activate'
                                        }}

                                    </button>

                                </form>


                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.faqs.destroy',
                                        $faq
                                    ) }}"
                                    onsubmit="return confirm('Delete this FAQ?')"
                                >

                                    @csrf
                                    @method('DELETE')


                                    <button
                                        type="submit"
                                        class="bg-red-600 text-white px-3 py-2 rounded-lg text-sm"
                                    >
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="4"
                            class="text-center p-10 text-gray-500"
                        >
                            No FAQs found.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


<div class="mt-6">

    {{ $faqs->links() }}

</div>

@endsection
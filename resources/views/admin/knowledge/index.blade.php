@extends('admin.layout')

@section('title', 'Knowledge Base')

@section('page-title', 'Knowledge Base')

@section('content')

<div class="flex justify-between items-center mb-6">

    <div>

        <h1 class="text-2xl font-bold text-gray-800">
            Knowledge Base
        </h1>

        <p class="text-gray-500 mt-1">
            Manage information used by the student support system.
        </p>

    </div>


    <a
        href="{{ route('admin.knowledge.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg"
    >
        + Add Article
    </a>

</div>


@if(session('success'))

    <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6">

        {{ session('success') }}

    </div>

@endif


<div class="bg-white rounded-xl shadow-sm overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-50 border-b">

                <tr>

                    <th class="text-left p-4">
                        Article
                    </th>

                    <th class="text-left p-4">
                        Category
                    </th>

                    <th class="text-left p-4">
                        Keywords
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

                @forelse($articles as $article)

                    <tr>

                        <td class="p-4">

                            <p class="font-semibold">
                                {{ $article->title }}
                            </p>

                            <p class="text-sm text-gray-500 mt-1">

                                {{ \Illuminate\Support\Str::limit(
                                    $article->content,
                                    100
                                ) }}

                            </p>

                        </td>


                        <td class="p-4">

                            {{ $article->category?->name
                                ?? 'General'
                            }}

                        </td>


                        <td class="p-4 text-sm text-gray-600">

                            {{ $article->keywords
                                ?? '-'
                            }}

                        </td>


                        <td class="p-4">

                            @if($article->status)

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
                                        'admin.knowledge.edit',
                                        $article
                                    ) }}"
                                    class="bg-blue-600 text-white px-3 py-2 rounded-lg text-sm"
                                >
                                    Edit
                                </a>


                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.knowledge.status',
                                        $article
                                    ) }}"
                                >

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="bg-yellow-500 text-white px-3 py-2 rounded-lg text-sm"
                                    >
                                        {{ $article->status
                                            ? 'Deactivate'
                                            : 'Activate'
                                        }}
                                    </button>

                                </form>


                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.knowledge.destroy',
                                        $article
                                    ) }}"
                                    onsubmit="return confirm('Delete this article?')"
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
                            colspan="5"
                            class="text-center p-10 text-gray-500"
                        >
                            No knowledge articles found.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


<div class="mt-6">
    {{ $articles->links() }}
</div>

@endsection
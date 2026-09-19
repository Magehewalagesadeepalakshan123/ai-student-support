@extends('admin.layout')

@section('title', 'Add Staff')

@section('page-title', 'Create Staff Account')

@section('content')

<div class="max-w-2xl">

    <div class="bg-white rounded-xl shadow-sm p-8">

        <h1 class="text-2xl font-bold mb-6">
            Add Staff Member
        </h1>


        <form
            method="POST"
            action="{{ route('admin.staff.store') }}"
            class="space-y-6"
        >

            @csrf


            <div>

                <label class="block font-medium mb-2">
                    Name
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full rounded-lg border-gray-300"
                    required
                >

                @error('name')
                    <p class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            <div>

                <label class="block font-medium mb-2">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full rounded-lg border-gray-300"
                    required
                >

                @error('email')
                    <p class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            <div>

                <label class="block font-medium mb-2">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="w-full rounded-lg border-gray-300"
                    required
                >

            </div>


            <div>

                <label class="block font-medium mb-2">
                    Confirm Password
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="w-full rounded-lg border-gray-300"
                    required
                >

            </div>


            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg"
            >
                Create Staff Account
            </button>

        </form>

    </div>

</div>

@endsection
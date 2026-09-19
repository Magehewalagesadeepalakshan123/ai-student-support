@extends('admin.layout')

@section('title', 'Edit User')

@section('page-title', 'Edit User')

@section('content')

<div class="max-w-2xl">

    <div class="bg-white rounded-xl shadow-sm p-8">

        <h1 class="text-2xl font-bold mb-6">
            Edit User
        </h1>


        <form
            method="POST"
            action="{{ route(
                'admin.users.update',
                $user
            ) }}"
            class="space-y-6"
        >

            @csrf
            @method('PUT')


            <div>

                <label class="block font-medium mb-2">
                    Name
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    class="w-full rounded-lg border-gray-300"
                    required
                >

            </div>


            <div>

                <label class="block font-medium mb-2">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    class="w-full rounded-lg border-gray-300"
                    required
                >

            </div>


            <div>

                <label class="block font-medium mb-2">
                    Role
                </label>

                <select
                    name="role"
                    class="w-full rounded-lg border-gray-300"
                >

                    <option
                        value="student"
                        @selected($user->role === 'student')
                    >
                        Student
                    </option>

                    <option
                        value="staff"
                        @selected($user->role === 'staff')
                    >
                        Staff
                    </option>

                </select>

            </div>


            <div>

                <label class="block font-medium mb-2">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full rounded-lg border-gray-300"
                >

                    <option
                        value="1"
                        @selected($user->status)
                    >
                        Active
                    </option>

                    <option
                        value="0"
                        @selected(!$user->status)
                    >
                        Inactive
                    </option>

                </select>

            </div>


            <button
                type="submit"
                class="bg-blue-600 text-white px-6 py-3 rounded-lg"
            >
                Save Changes
            </button>

        </form>

    </div>

</div>

@endsection
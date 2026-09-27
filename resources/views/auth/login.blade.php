<x-guest-layout>

    <div class="mb-6 text-center">

        <h1 class="text-2xl font-bold text-gray-800">
            AI Student Support System
        </h1>

        <p class="text-gray-500 mt-2">
            Sign in to your account
        </p>

    </div>


    <!-- Session Status -->

    <x-auth-session-status
        class="mb-4"
        :status="session('status')"
    />


    <form
        method="POST"
        action="{{ route('login') }}"
    >

        @csrf


        <!-- Email Address -->

        <div>

            <x-input-label
                for="email"
                :value="__('Email')"
            />

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
            />

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />

        </div>


        <!-- Password -->

        <div class="mt-4">

            <x-input-label
                for="password"
                :value="__('Password')"
            />

            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            />

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"
            />

        </div>


        <!-- Remember Me -->

        <div class="block mt-4">

            <label
                for="remember_me"
                class="inline-flex items-center"
            >

                <input
                    id="remember_me"
                    type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    name="remember"
                >

                <span class="ms-2 text-sm text-gray-600">
                    Remember me
                </span>

            </label>

        </div>


        <!-- Login Actions -->

        <div class="flex items-center justify-between mt-6">

            @if (Route::has('password.request'))

                <a
                    class="underline text-sm text-gray-600 hover:text-gray-900"
                    href="{{ route('password.request') }}"
                >
                    Forgot your password?
                </a>

            @endif


            <x-primary-button>
                Log In
            </x-primary-button>

        </div>


        <!-- REGISTER -->

        @if (Route::has('register'))

            <div class="mt-8 pt-6 border-t text-center">

                <p class="text-sm text-gray-600">
                    Don't have a student account?
                </p>


                <a
                    href="{{ route('register') }}"
                    class="inline-block mt-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg"
                >
                    Create Student Account
                </a>

            </div>

        @endif

    </form>

</x-guest-layout>
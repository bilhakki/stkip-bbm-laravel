<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
                {{ session('status') }}
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('login') }}"
        >
            @csrf

            <div>
                <x-label
                    for="username"
                    value="{{ __('Nomor Induk / Email') }}"
                />
                <x-input
                    class="mt-1 block w-full"
                    id="username"
                    type="text"
                    name="username"
                    :value="old('username')"
                    required
                    autofocus
                    autocomplete="username"
                />
            </div>

            <div class="mt-4">
                <x-label
                    for="password"
                    value="{{ __('Password') }}"
                />
                <x-input
                    class="mt-1 block w-full"
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                />
            </div>

            <div class="mt-4 block">
                <label
                    class="flex items-center"
                    for="remember_me"
                >
                    <x-checkbox
                        id="remember_me"
                        name="remember"
                    />
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="mt-4 flex items-center justify-end">
                @if (Route::has('password.request'))
                    <a
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                        href="{{ route('password.request') }}"
                    >
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>

        @if (config('app.env') != 'production' || true)
            @php
                $academic_university = App\Models\User::where('role', UserRole::ACADEMIC_UNIVERSITY)->first();
                $academic_faculty = App\Models\User::where('role', UserRole::ACADEMIC_FACULTY)->first();
                $academic_major = App\Models\User::where('role', UserRole::ACADEMIC_MAJOR)->inRandomOrder()->first();
                $lecturer = App\Models\User::where('role', UserRole::LECTURER)->first();
                $student = App\Models\User::where('role', UserRole::STUDENT)->first();
            @endphp
            <hr class="my-4">
            <h6 class="mb-1">Akun Dummy : </h6>
            <ol class="list-inside list-disc text-sm">
                <li><span class="font-medium">admin:</span> admin@adm.campus.com</li>
                <li><span class="font-medium">staff university:</span> {{ $academic_university->email }}</li>
                <li><span class="font-medium">staff faculty:</span> {{ $academic_faculty->email }}</li>
                <li><span class="font-medium">staff major:</span> {{ $academic_major->email }}</li>
                <li><span class="font-medium">lecturer:</span> {{ $lecturer->email }}</li>
                <li><span class="font-medium">mahasiswa:</span> {{ $student->email }}</li>
            </ol>

            <script>
                document.querySelectorAll('.list-inside li').forEach((item, index) => {
                    item.addEventListener('click', () => {
                        const email = item.innerText.split(": ")[1]
                        document.querySelector("#username").value = email
                    })
                })
            </script>
        @endif
    </x-authentication-card>
</x-guest-layout>

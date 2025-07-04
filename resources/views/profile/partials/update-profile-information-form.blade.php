<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="mb-4">
            <x-input-label for="name" :value="__('Name')" class="form-label fw-bold" />
            <x-text-input id="name" name="name" type="text" class="form-control form-control-lg" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-danger" :messages="$errors->get('name')" />
        </div>

        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" class="form-label fw-bold" />
            <x-text-input id="email" name="email" type="email" class="form-control form-control-lg" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2 text-danger" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>



        <!-- Role (only for Admin) -->
        @if ($user->role == 'Admin')
        <div class="mb-4">
            <x-input-label for="role" :value="__('Role')" class="form-label fw-bold" />
            <select id="role" name="role" class="form-select form-select-lg">
                <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="Data Entry" {{ $user->role == 'Data Entry' ? 'selected' : '' }}>Data Entry</option>
                <option value="Viewer" {{ $user->role == 'Viewer' ? 'selected' : '' }}>Viewer</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2 text-danger" />
        </div>
        @endif




        <div class="d-flex justify-content-end gap-3 mt-4">
            <button type="submit" class="btn btn-primary btn-lg px-5">{{ __('Save') }}</button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-success fw-bold ms-3 mt-2">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

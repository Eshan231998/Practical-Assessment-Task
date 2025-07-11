<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="mb-4">
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="form-label fw-bold" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="form-control form-control-lg" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-danger" />
        </div>

        <div class="mb-4">
            <x-input-label for="update_password_password" :value="__('New Password')" class="form-label fw-bold" />
            <x-text-input id="update_password_password" name="password" type="password" class="form-control form-control-lg" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-danger" />
        </div>

        <div class="mb-4">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="form-label fw-bold" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control form-control-lg" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-danger" />
        </div>

        <div class="d-flex justify-content-end gap-3 mt-4">
            <button type="submit" class="btn btn-secondary btn-lg px-5">{{ __('Save') }}</button>
            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-success fw-bold ms-3 mt-2">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

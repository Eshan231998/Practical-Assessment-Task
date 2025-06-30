<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>


    <div class="d-flex justify-content-end mb-3">
        <button type="button" class="btn btn-danger btn-lg px-5 fw-bold" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
            <i class="bi bi-trash me-2"></i>{{ __('Delete Account') }}
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mb-4">
                <x-input-label for="password" value="{{ __('Password') }}" class="form-label fw-bold" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control form-control-lg"
                    placeholder="{{ __('Password') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-danger" />
            </div>

            <div class="d-flex justify-content-end gap-3 mt-4">
                <button type="button" class="btn btn-secondary btn-lg px-4" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </button>
                <button type="submit" class="btn btn-danger btn-lg px-5 fw-bold">
                    <i class="bi bi-trash me-2"></i>{{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>

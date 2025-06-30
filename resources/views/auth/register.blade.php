<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            {{-- <x-input-label for="role" :value="__('Role')" />
            <div x-data="{ selectedRole: '{{ old('role') ? old('role') : '' }}' }">
                <x-dropdown align="left" width="48">
                    <x-slot name="trigger">
                        <button type="button" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-white text-left" x-text="selectedRole ? selectedRole : '{{ __('Select Role') }}'"></button>
                    </x-slot>
                    <x-slot name="content">
                        <ul>
                            <li>
                                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-gray-100" @click="selectedRole = 'Admin'; $refs.roleInput.value = 'Admin'; $dispatch('close')">{{ __('Admin') }}</button>
                            </li>
                            <li>
                                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-gray-100" @click="selectedRole = 'Data Entry'; $refs.roleInput.value = 'Data Entry'; $dispatch('close')">{{ __('Data Entry') }}</button>
                            </li>
                            <li>
                                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-gray-100" @click="selectedRole = 'Viewer'; $refs.roleInput.value = 'Viewer'; $dispatch('close')">{{ __('Viewer') }}</button>
                            </li>
                        </ul>
                        <input type="hidden" name="role" x-ref="roleInput" :value="selectedRole">
                    </x-slot>
                </x-dropdown>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div> --}}

            <x-input-label for="role" :value="__('Role')" class="block mt-1 w-full" />
            <select id="role" name="role" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 form-select form-select-lg">
                <option value="" disabled selected>{{ __('Select Role') }}</option>
                <option value="Admin">Admin</option>
                <option value="Data Entry">Data Entry</option>
                <option value="Viewer">Viewer</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2 text-danger" />
        </div>


        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('dashboard') }}">
                {{ __('Back to Dashboard!') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

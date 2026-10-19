<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text"
                          class="mt-1 block w-full"
                          :value="old('name', $user->name)"
                          required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email"
                          class="mt-1 block w-full"
                          :value="old('email', $user->email)"
                          required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Neo4j ID -->
        <div>
            <x-input-label for="neo4j_id" value="Neo4j ID (ex: U1)" />
            <x-text-input id="neo4j_id" name="neo4j_id" type="text"
                          class="mt-1 block w-full"
                          value="{{ old('neo4j_id', $user->neo4j_id) }}"
                          placeholder="U1" />
            <x-input-error class="mt-2" :messages="$errors->get('neo4j_id')" />
        </div>

        <!-- Budget Min -->
        <div>
            <x-input-label for="budgetMin" value="Budget Min (DH)" />
            <x-text-input id="budgetMin" name="budgetMin" type="number"
                          class="mt-1 block w-full"
                          value="{{ old('budgetMin', $user->budgetMin) }}"
                          placeholder="2500" />
            <x-input-error class="mt-2" :messages="$errors->get('budgetMin')" />
        </div>

        <!-- Budget Max -->
        <div>
            <x-input-label for="budgetMax" value="Budget Max (DH)" />
            <x-text-input id="budgetMax" name="budgetMax" type="number"
                          class="mt-1 block w-full"
                          value="{{ old('budgetMax', $user->budgetMax) }}"
                          placeholder="6500" />
            <x-input-error class="mt-2" :messages="$errors->get('budgetMax')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

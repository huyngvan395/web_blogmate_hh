<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';
    public $avatar;
    public $avatarPreview;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function updatedAvatar($value)
    {
        // Update the avatarPreview when a new file is selected
        $this->avatarPreview = $value ? $value->temporaryUrl() : null;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'avatar' => ['nullable', 'image'],
        ]);

        $user->fill($validated);

        if ($user->avatar) {
            Storage::delete($user->avatar);
        }

        if ($this->avatar) {
            $avatarName = md5($this->name) . '.' . $this->avatar->getClientOriginalExtension();
            $path = $this->avatar->storeAs('images/user', $avatarName, 'public'); 
            $validated['avatar'] = $path; // Lưu đường dẫn để lưu vào DB
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Thông tin hồ sơ') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Cập nhật thông tin hồ sơ và địa chỉ email của tài khoản của bạn.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div>
            <x-input-label for="name" :value="__('Tên')" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Địa chỉ email của bạn chưa được xác minh.') }}

                        <button wire:click.prevent="sendVerification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Bấm vào đây để gửi lại email xác minh.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Một liên kết xác minh mới đã được gửi đến địa chỉ email của bạn.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex justify-start items-center">
            <x-input-label for="name" :value="__('Ảnh đại diện')" class="mr-8"/>
            <div class="flex flex-col justify-center items-center">
                <div class="flex justify-center ">
                    <img src="{{ $avatarPreview ? $avatarPreview : asset('storage/'.auth()->user()->avatar)}}" alt="Ảnh đại diện" class="w-14 h-14 rounded-full mb-3">
                </div>
                <div class="flex justify-center">
                    <x-input-label for="avatar" class='inline-flex items-center px-4 py-2 w-auto h-8 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white tracking-widest hover:bg-green-700 focus:bg-green-800 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150'>
                        <svg wire:loading wire:target="avatar" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{__('Thay đổi')}}
                    </x-input-label>
                </div>
                <x-text-input wire:model="avatar" id="avatar" class="block w-full" type="file" name="avatar" class="hidden"
                            wire:change="$emit('updatedAvatar', $event.target.files[0])"/>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>
                <svg wire:loading wire:target="updateProfileInformation" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ __('Lưu') }}
            </x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Lưu.') }}
            </x-action-message>
        </div>
    </form>
</section>

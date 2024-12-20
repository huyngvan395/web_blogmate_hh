<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new #[Layout('layouts.guest')] class extends Component
{
    use WithFileUploads;
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public $avatar;

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'avatar' => ['image'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // if($this->avatar){

        //     $avatarName=md5($this->name).'.'.$this->avatar->getClientOriginalExtension();

        //     $this->avatar->move(public_path("images/user"), $avatarName);
            
        //     $validated['avatar']="images/user/". $avatarName;
        // }

        if ($this->avatar) {
            $avatarName = md5($this->name) . '.' . $this->avatar->getClientOriginalExtension();
            $path = $this->avatar->storeAs('images/user', $avatarName, 'public'); 
            $validated['avatar'] = $path; 
            $this->avatar->delete();
        }

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('home', absolute: false), navigate: true);
    }
}; ?>
<div>
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Tên')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mật khẩu')" />

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password"
                required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Xác nhận mật khẩu')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                type="password" name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- chọn ảnh --}}
        <div class="mt-8 flex items-center">
            <x-input-label for="avatar"
                class='inline-flex items-center px-4 py-2 w-auto h-8 mr-5 bg-sky-500 border border-transparent rounded-md font-semibold text-xs text-white tracking-widest hover:bg-sky-600 focus:bg-sky-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition ease-in-out duration-150'>
                <svg wire:loading wire:target="avatar" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{__('Chọn ảnh đại diện')}}
            </x-input-label>
            <x-text-input wire:model="avatar" id="avatar" class="block w-full" type="file" name="avatar"
                class="hidden" />

            <!-- Preview ảnh -->
            @if ($avatar)
            <div class="mt-4">
                <img src="{{$avatar->temporaryUrl()}}" alt="Ảnh đại diện" class="w-20 h-20 rounded-full">
            </div>
            @endif

            <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}" wire:navigate>
                {{ __('Đã có tài khoản?') }}
            </a>

            <x-primary-button class="ms-4">
                <svg wire:loading wire:target="register" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ __('Đăng kí') }}
            </x-primary-button>
        </div>
    </form>
</div>
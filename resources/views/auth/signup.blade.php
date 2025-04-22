@extends('layouts.main')

@section('content')
<div class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center justify-center min-h-screen flex-col bg-center bg-no-repeat">
    <img src="{{ asset('images/favicon.png') }}" alt="Logo" class="absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 h-[90%] z-20 pointer-events-none">
    <div class="z-20 p-6 sm:p-8 bg-white dark:bg-[#1b1b1b]/90 rounded-lg shadow-xl max-w-xl w-full 3xl:max-w-2xl">
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif
        
        <h2 class="text-center text-2xl font-bold text-gray-900">
            Register your account
        </h2>
        <form class="mt-8 space-y-6" method="POST" action="{{ route('signup.submit') }}">
            @csrf
            <div class="space-y-4 border-0">
                <div>
                    <label for="email" class="font-medium">Email address</label>
                    <input id="email" name="email" type="text"
                        class="appearance-none rounded-md relative block w-full px-3 mt-2 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="Email address" value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="font-medium">Password</label>
                    <input id="password" name="password" type="password"
                        class="appearance-none rounded-md relative block w-full px-3 py-2 mt-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-[#334b8c] focus:border-[#334b8c] focus:z-10 sm:text-sm"
                        placeholder="Password"  value="{{ old('password') }}">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="font-medium">Password Confirmation</label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                        class="appearance-none rounded-md relative block w-full px-3 py-2 mt-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-[#334b8c] focus:border-[#334b8c] focus:z-10 sm:text-sm"
                        placeholder="Password Confirmation"  value="{{ old('password_confirmation') }}">
                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <button type="submit"
                    class="group cursor-pointer relative w-1/2 mx-auto flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#334b8c] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#334b8c]">
                    Register
                </button>
                <div class="flex items-center justify-center mt-2">
                    <div class="text-sm">
                        <p class="font-medium text-neutral-600">
                            Already have an account. 
                            <a href="{{ route('login') }}" class="font-medium text-blue-600 underline">
                                Go to login
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

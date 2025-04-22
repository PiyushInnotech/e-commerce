@extends('layouts.main')

@section('content')
<div class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center justify-center min-h-screen flex-col bg-center bg-no-repeat">
    <img src="{{ asset('images/favicon.png') }}" alt="Logo" class="absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 h-[90%] z-20 pointer-events-none">
    <div class="z-20 p-6 sm:p-8 bg-white dark:bg-[#1b1b1b]/90 rounded-lg shadow-xl max-w-xl w-full 3xl:max-w-2xl">
        <div class="text-center">
            <h1 class="text-center text-2xl font-bold text-gray-900">
                Forgot password?
            </h1>
            <p class="mt-2 text-sm font-medium text-neutral-600">
                Remember your password?
                <a class="text-blue-700 decoration-2 font-medium underline" href="{{ route('login') }}">
                    Login here
                </a>
            </p>
        </div>
        <form class="mt-8 space-y-6" method="POST" action="{{ route('forgot-password.submit') }}">
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
            </div>

            <div>
                <button type="submit"
                    class="group cursor-pointer relative w-1/2 mx-auto flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#334b8c] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#334b8c]">
                    Get verification code
                </button>
            </div>
        </form>
      </div>
    </div>
</div>
@endsection
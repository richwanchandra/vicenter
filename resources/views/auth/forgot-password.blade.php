@extends('layouts.app')

@section('page_title', 'Forgot Password')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-blue-600">Reset your password</h1>
                <p class="text-gray-600 text-sm mt-1">Enter your email to receive a reset link</p>
            </div>

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Send Reset Link
                </button>
            </form>

            <p class="text-center text-gray-600 text-sm mt-4">
                Remembered your password?
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-semibold">Back to login</a>
            </p>
        </div>
    </div>
@endsection

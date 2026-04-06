@extends('layouts.app')

@section('page_title', 'Email Verified')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-blue-600">Email Verified</h1>
                <p class="text-gray-600 text-sm mt-1">Your email has been successfully verified. You can now access all the features of our application.</p>
            </div>

            <div class="mt-4 flex items-center justify-center">
                <a href="{{ route('user.home') }}" class="text-sm text-blue-600 hover:text-blue-700 font-semibold">
                    Go to Home
                </a>
            </div>
        </div>
    </div>
@endsection

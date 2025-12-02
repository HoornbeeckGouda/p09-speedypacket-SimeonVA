@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md p-6 bg-white rounded shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Code invoeren</h2>

        @if (session('status'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('status') }}
        </div>
        @endif

        @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('verify') }}">
            @csrf

            <div class="mb-6">
                <p class="text-gray-600 text-sm">
                    We hebben een code naar je geregistreerde email gestuurd. Heb je deze niet ontvangen? 
                    <a href="{{ route('verify.resend') }}" class="text-blue-600 hover:text-blue-800 underline">
                        Klik hier om opnieuw te versturen
                    </a>.
                </p>
            </div>

            <!-- Verificatiecode -->
            <div class="mb-6">
                <label for="code" class="block text-gray-700 font-semibold mb-2">
                    Verificatiecode
                </label>
                <input 
                    id="code" 
                    type="text" 
                    name="code" 
                    value="{{ old('code') }}" 
                    required 
                    autofocus 
                    maxlength="6" 
                    placeholder="000000"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('code') border-red-500 @enderror" 
                />
                @error('code')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="mb-4">
                <button 
                    type="submit" 
                    class="w-full px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200"
                >
                    Verificeer Code
                </button>
            </div>

            <!-- Terug naar login link -->
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-800 underline">
                    Terug naar login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
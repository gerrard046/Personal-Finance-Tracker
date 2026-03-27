@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="flex justify-center items-center">
    <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <i class="fas fa-user-plus text-purple-600 text-4xl mb-4"></i>
            <h1 class="text-3xl font-bold text-gray-800">Daftar</h1>
            <p class="text-gray-600 mt-2">Buat akun baru untuk memulai</p>
        </div>

        <form action="{{ route('auth.register.post') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                <input 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500"
                    placeholder="John Doe"
                    required
                >
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500"
                    placeholder="example@email.com"
                    required
                >
                @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Password</label>
                <input 
                    type="password" 
                    name="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500"
                    placeholder="••••••••"
                    required
                >
                @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Konfirmasi Password</label>
                <input 
                    type="password" 
                    name="password_confirmation"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500"
                    placeholder="••••••••"
                    required
                >
            </div>

            <button 
                type="submit"
                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded-lg transition"
            >
                <i class="fas fa-user-check mr-2"></i>Daftar
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('auth.login') }}" class="text-purple-600 hover:text-purple-700 font-semibold">
                    Login di sini
                </a>
            </p>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Login</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="email" name="email" placeholder="Email" class="w-full mb-3 p-2 border rounded" required>
        <input type="password" name="password" placeholder="Password" class="w-full mb-3 p-2 border rounded" required>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Login</button>
        <div class="text-center text-sm text-gray-600 mb-4">
    Belum punya akun? 
    <a href="register" class="text-violet-600 hover:underline transition duration-200">Daftar dulu yuk</a>
</div>

    </form>
</div>
@endsection

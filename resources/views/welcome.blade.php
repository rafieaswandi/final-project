@extends('layouts.app')


@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-purple-100 px-4 py-12">
        <div class="text-center max-w-2xl bg-white bg-opacity-80 backdrop-blur-md rounded-2xl shadow-2xl p-10 border border-gray-200">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-800 drop-shadow-lg mb-4">Selamat Datang di <span class="text-blue-600">EventEase</span></h2>
            <p class="text-lg text-gray-600 mb-6">Platform manajemen event terbaik untuk seminar, workshop, dan acara komunitas.</p>
            @guest
                <div class="mt-6">
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-5 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
    🚀 Daftar Sekarang
</a>

                </div>
            @endguest
        </div>
    </div>
@endsection

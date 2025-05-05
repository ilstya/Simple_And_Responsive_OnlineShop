@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        {{-- Update Profile Information --}}
        <div class="bg-white shadow-sm p-6 rounded-lg">
            <h2 class="text-lg font-semibold mb-4">Informasi Profil</h2>
            @include('profile.partials.update-profile-information-form')
        </div>

        {{-- Update Password --}}
        <div class="bg-white shadow-sm p-6 rounded-lg">
            <h2 class="text-lg font-semibold mb-4">Ubah Password</h2>
            @include('profile.partials.update-password-form')
        </div>

        {{-- Delete User --}}
        <div class="bg-white shadow-sm p-6 rounded-lg">
            <h2 class="text-lg font-semibold mb-4 text-red-600">Hapus Akun</h2>
            @include('profile.partials.delete-user-form')
        </div>
    </div>
@endsection

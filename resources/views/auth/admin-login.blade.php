@extends('layouts.guest')

@section('content')
<div class="max-w-md mx-auto mt-16 p-6 bg-white shadow rounded">
    <h2 class="text-xl font-bold mb-4">Admin Login</h2>
    <form method="POST" action="{{ route('admin.login') }}">
        @csrf
        <x-input label="Username" name="username" required autofocus />
        <x-input label="Password" name="password" type="password" required />
        <button type="submit" class="mt-4 btn-primary w-full">Login</button>
    </form>
</div>
@endsection

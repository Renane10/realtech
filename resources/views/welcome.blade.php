@extends('layouts.layout')

@section('content')
    <div class="login-form">
        <h1>Login</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <label for="login">Usuário:</label>
                <input type="text" id="login" name="login" value="{{ old('login') }}" required autofocus />
            </div>
            <div>
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required />
            </div>
            <button type="submit">Entrar</button>
        </form>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

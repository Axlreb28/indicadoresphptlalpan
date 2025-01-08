@extends('layouts.base')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="login-page">
    <!-- Título principal -->
    <h1>Bienvenid@!</h1>

    <!-- Formulario centrado -->
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <h1>Bienvenid@!</h1>
            <!-- Logo centrado -->
            <div class="logo">
                <img src="{{ asset('image/logo.png') }}" id="imagen" alt="Logo">
            </div>

            <!-- Formulario -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <input type="text" id="username" class="fadeIn second form-control" name="username" placeholder="Usuario" required>
                </div>
                <div class="form-group">
                    <input type="password" id="password" class="fadeIn third form-control" name="password" placeholder="Contraseña" required>
                </div>
                <input type="submit" class="fadeIn fourth btn button" value="Iniciar Sesión">
            </form>

            <!-- Botón de Registro centrado -->
            <div id="formFooter">
                <a class="underlineHover btn button button-secondary" href="{{ route('register') }}">Registrarse</a>
            </div>
        </div>
    </div>
</div>
@endsection

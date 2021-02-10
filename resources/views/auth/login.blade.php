@extends('layouts.custom')

@section('content')
<div id="signin-body" class="text-center">
    <form method="POST" action="{{ route('login') }}" class="form-signin">
    @csrf
        <h1 class="h3 mb-3 font-weight-normal">Iniciar Sesión</h1>

        <label for="email" class="sr-only">{{ __('E-Mail') }}</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="E-Mail" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
                            
        <label for="password" class="sr-only">{{ __('Contraseña') }}</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña" name="password" required autocomplete="current-password">

        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
                            

        <div class="checkbox mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">
                {{ __('Recordar Sesión') }}
            </label>
        </div>
        
        <button type="submit" class="btn btn-outline-primary btn-block">
            {{ __('Ingresar') }}
        </button>

        {{-- @if (Route::has('password.request'))
        <a class="btn btn-link" href="{{ route('password.request') }}">
            {{ __('¿olvidaste tu contraseña?') }}
        </a>
        @endif --}}

                        
    </form>
    
    </div>
@endsection

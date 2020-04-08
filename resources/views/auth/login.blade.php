@extends('layout')


@section('content')


    <form action="{{ route('login') }}" method="POST">
        @csrf


        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" id="email"
                   class="form-control {{ $errors->has('email')? 'is-invalid' : ''}}" required>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password"
                   class="form-control {{ $errors->has('password')? 'is-invalid' : ''}}" required>
            @if($errors->has('password'))
                <div class="invalid-feedback">
                    {{ $errors->first('password') }}
                </div>
            @endif
        </div>


        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input"
                value="{{ old('remember') ? 'checked' : '' }}">
                <label for="remember" class="form-check-label">
                    Remember Me
                </label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>

    </form>

@endsection

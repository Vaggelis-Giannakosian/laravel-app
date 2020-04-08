@extends('layout')

@section('content')

    <h3 class="mb-4">Login Form</h3>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name"r value="{{ old('name') }}" id="name"  required
                   class="form-control {{ $errors->has('name')? 'is-invalid' : ''}}" >
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>



        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" id="email" class="form-control {{ $errors->has('email')? 'is-invalid' : ''}}" required>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>



        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control {{ $errors->has('password')? 'is-invalid' : ''}}" required>
            @if($errors->has('password'))
                <div class="invalid-feedback">
                    {{ $errors->first('password') }}
                </div>
            @endif
        </div>


        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation"  id="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary ">Register</button>

    </form>

@endsection

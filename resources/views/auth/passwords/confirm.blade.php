@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
<<<<<<< HEAD
                <div class="card-header">{{ __('Confirm Password') }}</div>
=======
                <div class="card-header">{{ __('パスワード確認') }}</div>
>>>>>>> 95c97ed (Initial Commit)

                <div class="card-body">
                    {{ __('Please confirm your password before continuing.') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="row mb-3">
<<<<<<< HEAD
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
=======
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('パスワード') }}</label>
>>>>>>> 95c97ed (Initial Commit)

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
<<<<<<< HEAD
                                    {{ __('Confirm Password') }}
=======
                                    {{ __('パスワード確認') }}
>>>>>>> 95c97ed (Initial Commit)
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
<<<<<<< HEAD
                                        {{ __('Forgot Your Password?') }}
=======
                                        {{ __('パスワードを忘れましたか?') }}
>>>>>>> 95c97ed (Initial Commit)
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title',"ユーザー新規登録画面")
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>
                <div class="card-header">{{ __('ユーザー新規登録') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">

                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('名前') }}</label>


                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
<<<<<<< HEAD
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

=======
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email アドレス') }}</label>
>>>>>>> 95c97ed (Initial Commit)
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
<<<<<<< HEAD
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
=======
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('パスワード') }}</label>
>>>>>>> 95c97ed (Initial Commit)

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">

                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('パスワード確認') }}</label>


                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}

                            <div class="col-md-6 offset-md-4 d-flex gap-3">
                                <button type="submit" class="btn btn-info">
                                    {{ __('新規登録') }}
                                </button>
                                <button type="submit" class="btn btn-warning">
                                    {{ __('戻る') }}

                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

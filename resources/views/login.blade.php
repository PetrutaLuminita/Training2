<?php
/** @var \Illuminate\Support\ViewErrorBag $errors */
?>

@extends('layout')

@section('title')
    {{__('Login') }}
@endsection

@section('content')
    <div class="container">
        <?php if ($errors->any()) : ?>
            <?php foreach ($errors->all() as $error) : /** @var \Illuminate\Support\MessageBag $error */ ?>
                    <div class="help-is-danger">{{ $error }}</div>
            <?php endforeach ?>
        <?php endif ?>

        <form method ="post" action="{{ route('login') }}" class="text-center border-0">
            @csrf

            <div class="form-group">
                <input type="text" name="email" placeholder="{{ __('Email') }}" class="input form-control" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="{{ __('Password') }}" class="input form-control">
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
        </form>
    </div>
@endsection

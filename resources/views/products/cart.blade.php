<?php
    /** @var \Illuminate\Database\Eloquent\Collection $products */
?>

@extends('layout')

@section('title')
     {{__('Cart') }}
@endsection

@section('scripts')
    <script async src="{{ asset('js/checkout.js') }}"></script>
@endsection

@section('content')
    <div class="products-in-cart"></div>
        <a href="{{ route('product.index') }}" class="btn btn-primary mb-2">{{ __('Go to index') }}</a>

    <div class="checkout d-none">
            <h4>{{ __('Contact details') }}</h4>

            <form method="POST" action="" class="form-group checkout-form">
                @csrf

                <input class="input form-control" type="text" placeholder="{{ __('Name') }}" name="name">
                <div class="help-is-danger d-none name-err"></div>

                <input class="input form-control" type="text" placeholder="{{ __('Email') }}" name="email">
                <div class="help-is-danger d-none email-err"></div>

                <textarea class="textarea form-control" placeholder="{{ __('Comments') }}" name="comments"></textarea>
                <div class="help-is-danger d-none comments-err"></div>

                <button class="btn btn-primary mt-2 checkout-btn" type="submit">{{ __('Checkout') }}</button>
            </form>
    </div>
@endsection

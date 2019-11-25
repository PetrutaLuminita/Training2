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
                @component('partials.error', ['fieldName' => 'name']) @endcomponent

                <input class="input form-control" type="text" placeholder="{{ __('Email') }}" name="email">
                @component('partials.error', ['fieldName' => 'email']) @endcomponent

                <textarea class="textarea form-control" placeholder="{{ __('Comments') }}" name="comments"></textarea>
                @component('partials.error', ['fieldName' => 'comments']) @endcomponent

                <button class="btn btn-primary mt-2" type="submit">{{ __('Checkout') }}</button>
            </form>
    </div>
@endsection

<?php
    /** @var \Illuminate\Database\Eloquent\Collection $products */
?>

@extends('layout')

@section('title')
    {{ __('Products') }}
@endsection

@section('scripts')
    <script async src="{{ asset('js/homepage.js') }}"></script>
@endsection

@section('content')
    <table class="table products-table"></table>

    <a href="{{ route('products.cart.checkout') }}" target="_blank" class="btn btn-primary ml-1">{{ __('Go to checkout') }}</a>
@endsection

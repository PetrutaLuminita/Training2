<?php
    /** @var \Illuminate\Database\Eloquent\Collection $products */
?>

@extends('layout')

@section('title')
    <div class="title index-title"></div>
@endsection

@section('scripts')
    <script async src="{{ asset('js/homepage.js') }}"></script>
@endsection

@section('content')
    <div class="products-list-table"></div>
    <div class="navigate-buttons">
        <a href="{{ route('product.cart') }}" class="btn btn-primary ml-1">{{ __('Go to checkout') }}</a>
    </div>
@endsection

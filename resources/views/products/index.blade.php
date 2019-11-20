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
    <table class="table products-table"></table>

    <a href="{{ route('product.cart') }}" class="btn btn-primary ml-1">{{ __('Go to checkout') }}</a>
@endsection

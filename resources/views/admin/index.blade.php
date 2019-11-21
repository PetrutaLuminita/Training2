<?php
    /** @var \Illuminate\Database\Eloquent\Collection $products */
?>

@extends('layout')

@section('title')
    <div class="admin-title"></div>
@endsection

@section('scripts')
    <script async src="{{ asset('js/products.js') }}"></script>
@endsection

@section('content')

    <div class="content products-listing">@csrf</div>

    <a href="{{ route('products.create') }}" class="btn btn-primary mb-2 mr-2 product-add-btn">{{ __('Add') }}</a>
    <a href="{{ route('logout') }}" class="btn btn-primary mb-2">{{ __('Logout') }}</a>
@endsection

<?php
    /** @var \App\Product $product */
?>

@extends('layout')

@section('title')
    <div class="admin-title-edit"></div>
@endsection

@section('scripts')
    <script async src="{{ asset('js/edit.js') }}"></script>
@endsection

@section('content')

    <div class="container mt-3">
        <form method="POST" action="" class="form-group form" enctype="multipart/form-data">
            @csrf

            <input class="input form-control mb-2 prod-title" type="text" placeholder="{{ __('Title') }}" name="title">
            <textarea class="textarea form-control mb-2 description" placeholder="{{ __('Description') }}" name="description"></textarea>
            <input class="input form-control price" type="text" placeholder="{{ __('Price') }}" name="price">
            <input class="input form control text-left mb-2 image" type="file" name="image"><br>
            <button class="btn btn-primary product-btn" type="submit"></button>

        </form>

        <div class="text-left">
            <button class="btn btn-info ml-3 back">{{ __('Go back') }}</button>
        </div>
    </div>

@endsection

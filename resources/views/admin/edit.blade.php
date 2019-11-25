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
    <div class="container mt-3 edit-product-form">
        <form method="POST" action="{{ $product->getKey() ? route('products.update', ['product' => $product->getKey()]) : route('products.store') }}" class="form-group form with-token" enctype="multipart/form-data" product="{{ $product->getKey() }}">
            @csrf

            <?php if ($product->getKey()) : ?>
            @method('PUT')
            <?php endif ?>

            <input class="input form-control mb-2 prod-title" type="text" placeholder="{{ __('Title') }}" name="title">
            @component('partials.error', ['fieldName' => 'title']) @endcomponent

            <textarea class="textarea form-control mb-2 prod-description" placeholder="{{ __('Description') }}" name="description"></textarea>
            @component('partials.error', ['fieldName' => 'description']) @endcomponent

            <input class="input form-control prod-price" type="text" placeholder="{{ __('Price') }}" name="price">
            @component('partials.error', ['fieldName' => 'price']) @endcomponent

            <input class="input form control text-left mb-2 prod-image" type="file" name="image"><br>
            @component('partials.error', ['fieldName' => 'image']) @endcomponent

            <button class="btn btn-primary product-btn" type="submit"></button>
        </form>

        <div class="text-left">
            <button class="btn btn-info ml-3 back-to-products">{{ __('Go back') }}</button>
        </div>
    </div>

@endsection

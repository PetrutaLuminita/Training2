<?php
    /** @var \App\Product $product */
?>

@extends('layout')

@section('title')
    {{ $product->getKey() ? __('Update product') : __('Add a product') }}
@endsection

@section('content')

    <div class="container mt-3">
        <form method="POST" action="" class="form-group" enctype="multipart/form-data">
            @csrf

            <?php if ($product->getKey()) : ?>
                @method('PUT')
            <?php endif ?>

            <input class="input form-control mb-2" type="text" placeholder="{{ __('Title') }}" name="title" value="{{ old('title', $product->title) }}">
            @component('partials.error', ['fieldName' => 'title']) @endcomponent

            <textarea class="textarea form-control mb-2" placeholder="{{ __('Description') }}" name="description">{{ old('description', $product->description) }}</textarea>
            @component('partials.error', ['fieldName' => 'description']) @endcomponent

            <input class="input form-control" type="text" placeholder="{{ __('Price') }}" name="price" value="{{ old('price', $product->price) }}">
            @component('partials.error', ['fieldName' => 'price']) @endcomponent

            <?php if (!empty($product->image)) : ?>
                <img src="{{ $product->image }}">
            <?php else : ?>
                <div class="text-left">{{ __('No image uploaded') }}</div>
            <?php endif ?>

            <input class="input form control text-left mb-2" type="file" name="image" value="{{ old('image', $product->image_url) }}">
            @component('partials.error', ['fieldName' => 'image']) @endcomponent

            <button class="btn btn-primary" type="submit">{{ $product->getKey() ? __('Update') : __('Add') }}</button>
        </form>
    </div>

@endsection

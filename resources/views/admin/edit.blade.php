<?php
    /** @var \App\Product $product */
?>

@extends('layout')

@section('title')
    {{ ($product->getKey()) ? __('Update product') : __('Add a product') }}
@endsection

@section('content')

    <div class="container mt-3">
        <form method="POST" action="" class="form-group" enctype='multipart/form-data'>
            @csrf

            <?php if ($product->getKey()) : ?>
                @method('PUT')
            <?php endif ?>

            <input class="input form-control mb-2" type="text" placeholder="{{ __('Title') }}"  name="title" value="{{ old('title', $product->title) }}">
            @component('partials.error', ['field_name' => 'title']) @endcomponent

            <textarea class="textarea form-control mb-2" placeholder="{{ __('Description') }}"  name="description">{{ old('description', $product->description) }}</textarea>
            @component('partials.error', ['field_name' => 'description']) @endcomponent

            <input class="input form-control" type="text" placeholder="{{ __('Price') }}" name="price" value="{{ old('price', $product->price) }}">
            @component('partials.error', ['field_name' => 'price']) @endcomponent

            @if (!empty($product->image_url))
                <img src="{{ $product->image() }}" height="250px" width="250px">
            @else
                <div class="text-left">{{ __('No image uploaded') }}</div>
            @endif

            <input class="input form control text-left" type="file" name="image" value="{{ old('image', $product->image_url) }}"><br>
            @component('partials.error', ['field_name' => 'image']) @endcomponent

            <button class="btn btn-primary" type="submit">{{ ($product->getKey()) ? __('Update') : __('Add') }}</button>
        </form>
    </div>

@endsection

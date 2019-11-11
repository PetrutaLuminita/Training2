<?php
    /** @var \App\Product $products */
?>

@extends('layout')

@section('title')
     {{ __('Products') }}
@endsection

@section('content')
    <table class="table">
        <?php if (empty($products)) : ?>
            <div>{{ __('All products are in cart') }}</div>
        <?php else: ?>
            <?php foreach ($products as $product) : /** @var \App\Product $product */ ?>
                <tr>
                    <td rowspan="3">
                        <?php if (!$product->image_url) : ?>
                            <div>{{ __('No image available') }}</div>
                        <?php else : ?>
                            <img src="{{ $product->image() }}" height="250px" width="250px">
                        <?php endif ?>
                    </td>
                    <td>
                        <h5>{{ $product->title }}</h5>
                    </td>
                    <td rowspan="3" class="text-center">
                        <a href="{{ route('products.add_to_cart', ['product' => $product->getKey()]) }}"  class="btn btn-primary">{{ __('Add to cart') }}</a>
                    </td>
                </tr>

                <tr>
                    <td>{{ __('Description ') . $product->description }}</td>
                </tr>
                <tr>
                    <td>
                        <strong>{{ __('Price ') . $product->price }}</strong>
                    </td>
                </tr>

            <?php endforeach ?>
        <?php endif ?>

    </table>

    <a href="{{ route('products.cart') }}" class="btn btn-primary mb-4">{{ __('Go to cart') }}</a>
@endsection

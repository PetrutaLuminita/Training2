<?php
    /** @var \Illuminate\Database\Eloquent\Collection $products */
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
                    <td class="align-middle">
                        <?php if (!$product->image) : ?>
                            <div>{{ __('No image available') }}</div>
                        <?php else : ?>
                            <img src="{{ $product->image }}">
                        <?php endif ?>
                    </td>

                    <td class="align-middle">
                        <h5 class="font-weight-bold mb-2">{{ $product->title }}</h5>

                        <div class="font-weight-normal mb-2">{{ __('Description') . ': ' . $product->description }}</div>

                        <div class="font-italic">{{ __('Price') . ': ' . $product->price }}</div>
                    </td>

                    <td class="text-center align-middle">
                        <a href="{{ route('products.add_to_cart', ['product' => $product]) }}" class="btn btn-primary">{{ __('Add to cart') }}</a>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>
    </table>

    <a href="{{ route('products.cart') }}" class="btn btn-primary mb-4">{{ __('Go to cart') }}</a>
@endsection

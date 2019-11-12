<?php
    /** @var \App\Product $products */
?>

@extends('layout')

@section('title')
    {{__('All products') }}
@endsection

@section('content')
    <table class="table">
        <?php if (empty($products)) : ?>
            <div>{{ __('No products available') }}</div>
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

                    <div class="font-weight-normal mb-2">{{ __('Description ') . $product->description }}</div>

                    <div class="font-italic">{{ __('Price ') . $product->price }}</div>
                </td>

                <td class="text-center align-middle">
                    <a href="{{ route('admin.products.edit', ['product' => $product->getKey()]) }}" class="btn btn-primary">{{ __('Edit') }}</a>
                    <a href="{{ route('admin.products.delete', ['product' => $product->getKey()]) }}" class="btn btn-primary">{{ __('Delete') }}</a>
                </td>
            </tr>
            <?php endforeach ?>
        <?php endif ?>
    </table>

    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">{{ __('Add') }}</a>
    <a href="{{ route('logout') }}" class="btn btn-primary">{{ __('Logout') }}</a><br><br>

@endsection

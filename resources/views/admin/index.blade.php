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
                        <a href="{{ route('admin.products.edit', ['product' => $product->getKey()]) }}"  class="btn btn-primary">{{ __('Edit') }}</a>
                    </td>
                    <td rowspan="3" class="text-center">
                        <a href="{{ route('admin.products.delete', ['product' => $product->getKey()]) }}"  class="btn btn-primary">{{ __('Delete') }}</a>
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

    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">{{ __('Add') }}</a>
    <a href="{{ route('logout') }}" class="btn btn-primary">{{ __('Logout') }}</a><br><br>


@endsection

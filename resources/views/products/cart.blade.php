<?php
    /** @var \App\Product $products */
?>

@extends('layout')

@section('title')
     {{__('Cart') }}
@endsection

@section('content')
    <table class="table">
        <?php if (empty($products)) : ?>
            <div>{{ __('There are no products in cart.') }}</div>
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
                        <a href="{{ route('products.remove_from_cart', ['product' => $product->getKey()]) }}"  class="btn btn-primary">{{ __('Remove from cart') }}</a>
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

    <a href="{{ route('products.index') }}" class="btn btn-primary">{{ __('Go to index') }}</a><br><br>

    <?php if (!empty($products)) : ?>
        <h4>{{ __('Contact details:') }}</h4>

        <form method="POST" action="" class="form-group">
            @csrf

            <input class="input form-control @error('title') is-invalid @enderror" type="text" placeholder="{{ __('Name') }}" name="name" value="{{ old('name') }}">
            @component('partials.error', ['field_name' => 'name']) @endcomponent


            <input class="input form-control" type="text" placeholder="{{ __('Email') }}" name="email" value="{{ old('email') }}">
            @component('partials.error', ['field_name' => 'email']) @endcomponent

            <textarea class="textarea form-control" placeholder="{{ __('Comments') }}" name="comments">{{ old('comments') }}</textarea>
            @component('partials.error', ['field_name' => 'comments']) @endcomponent

            <button class="btn btn-primary" type="submit">{{ __('Checkout') }}</button>
        </form>
    <?php endif ?>
@endsection

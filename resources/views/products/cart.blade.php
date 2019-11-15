<?php
    /** @var \Illuminate\Database\Eloquent\Collection $products */
?>

@extends('layout')

@section('title')
     {{__('Cart') }}
@endsection

@section('content')
    <table class="table">
        <?php if ($products->isEmpty()) : ?>
            <div>{{ __('There are no products in cart') }}</div>
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

                    <td class="text-center align-middle to-center">
                        <a href="{{ route('products.remove_from_cart', ['product' => $product]) }}" class="btn btn-primary">{{ __('Remove from cart') }}</a>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>
    </table>

    <a href="{{ route('products.index') }}" class="btn btn-primary mb-2">{{ __('Go to index') }}</a>

    <?php if (!$products->isEmpty()) : ?>
        <h4>{{ __('Contact details') }}</h4>

        <form method="POST" action="" class="form-group">
            @csrf

            <input class="input form-control" type="text" placeholder="{{ __('Name') }}" name="name" value="{{ old('name') }}">
            @component('partials.error', ['fieldName' => 'name']) @endcomponent

            <input class="input form-control" type="text" placeholder="{{ __('Email') }}" name="email" value="{{ old('email') }}">
            @component('partials.error', ['fieldName' => 'email']) @endcomponent

            <textarea class="textarea form-control" placeholder="{{ __('Comments') }}" name="comments">{{ old('comments') }}</textarea>
            @component('partials.error', ['fieldName' => 'comments']) @endcomponent

            <button class="btn btn-primary mt-2" type="submit">{{ __('Checkout') }}</button>
        </form>
    <?php endif ?>
@endsection

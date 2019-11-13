<?php
/** @var \App\Product $products */
/** @var \App\Product $product */
?>

@component('mail::message')

<h4>{{ __('Hello') . '!' }}</h4><br>
{{ __('Order from') . ': ' }}<div>{{ $customer }}</div><br>
{{ __('Email') . ': ' }}<div>{{ $email }}</div><br>
{{ __('Comments regarding the order') . ': ' }}<div>{{ $comments ? $comments : __('No comments') }}</div><br>
{{ __('Products ordered') . ': '}} <br>

<table class="table">
    <?php foreach ($products as $product) : ?>
        <tr>
            <td rowspan="3">
                <img src="{{ $product->image }}">
             </td>
             <td>
                 <h5>{{ $product->title }}</h5>
             </td>
         </tr>
         <tr>
             <td>{{ __('Description') . ': ' . $product->description }}</td>
         </tr>
         <tr>
             <td>
                 <div>{{ __('Price ') . ': ' . $product->price }}</div>
             </td>
         </tr>
    <?php endforeach ?>
</table>

@endcomponent

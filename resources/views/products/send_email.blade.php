<?php
/** @var \App\Product $products */
/** @var  \App\Product $product */
?>

@component('mail::message')

<h4>{{ __('Hello!') }}</h4><br>
{{ __('Order from: ') }}<strong>{{ $customer }}</strong><br>
{{ __('Email: ')  }}<strong>{{ $email }}</strong><br>
{{ __('Comments regarding the order: ') }}<strong>{{ ($comments) ? $comments : __('No comment')  }}</strong><br>
{{ __('Products ordered:') }} <br>

<table class="table">
    <?php foreach ($products as $product) : ?>
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
     </table>

@endcomponent

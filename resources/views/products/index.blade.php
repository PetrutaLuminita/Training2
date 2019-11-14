<?php
    /** @var \Illuminate\Database\Eloquent\Collection $products */
?>

@extends('layout')

@section('title')
    {{ __('Products') }}
@endsection

@section('scripts')
    <script src="{{ mix('js/homepage.js') }}"></script>
@endsection

@section('content')
    <table id="products-table" class="table"></table>
@endsection

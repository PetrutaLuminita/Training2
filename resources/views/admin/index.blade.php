<?php
    /** @var \Illuminate\Database\Eloquent\Collection $products */
?>

@extends('layout')

@section('title')
    <div class="admin-title"></div>
@endsection

@section('scripts')
    <script async src="{{ asset('js/productsCRUD.js') }}"></script>
@endsection

@section('content')
    <div class="content"></div>
    @csrf
@endsection

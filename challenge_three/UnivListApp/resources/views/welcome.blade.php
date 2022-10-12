<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
@extends('layouts.app')
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
<h3>Universities in Canada and USA</h3>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">State</th>
            <th scope="col">Two Code Country</th>
            <th scope="col">Country</th>
        </tr>
    </thead>
    <tbody>
    @foreach($universities as $univ)
        <tr>
            <td scope="row">{{$univ->name}}</td>
            <td>{{$univ->name}}</td>
            <td>{{$univ->alpha_two_code}}</td>
            <td>{{$univ->country}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>

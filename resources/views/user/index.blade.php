@extends('layouts.app')

@section('content')
    <h1>Merchant Dashboard</h1>
    <p>Welcome to your dashboard, {{ auth()->user()->name }}!</p>
    <ul>
        <li><a href="{{ route('profile') }}">View Profile</a></li>
        <li><a href="{{ route('orders') }}">View Orders</a></li>
    </ul>
@endsection
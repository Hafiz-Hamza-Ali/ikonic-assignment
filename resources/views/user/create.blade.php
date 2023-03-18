@extends('layouts.app')

@section('content')
    <h1>User Profile</h1>
    <p>Here you can update your user profile information:</p>
    <form action="{{ route('profile.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="display_name"> Name:</label>
            <input type="text" name="name" id="display_name" value="{{ $user->name }}">
        </div>
        <div class="form-group">
            <label for="domain">Email:</label>
            <input type="text" name="email" id="email" value="{{ $user->email }}">
        </div>
        <div class="form-group">
            <label for="default_commission_rate">Password:</label>
            <input type="password" step="0.01" name="password" id="password" value="{{ $user->password }}">
        </div>
        <div class="form-group">
            <label for="default_commission_rate">Type:</label>
            <input type="text" step="0.01" name="type" id="type" value="{{ $user->type }}">
        </div>
        <button type="submit">Submit User</button>
    </form>
@endsection
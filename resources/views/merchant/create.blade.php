@extends('layouts.app')

@section('content')
    <h1>Merchant Profile</h1>
    <p>Here you can update your merchant profile information:</p>
    <form action="{{ route('profile.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="display_name">Display Name:</label>
            <input type="text" name="display_name" id="display_name" value="{{ $merchant->display_name }}">
        </div>
        <div class="form-group">
            <label for="domain">Domain:</label>
            <input type="text" name="domain" id="domain" value="{{ $merchant->domain }}">
        </div>
        <div class="form-group">
            <label for="default_commission_rate">Default Commission Rate:</label>
            <input type="number" step="0.01" name="default_commission_rate" id="default_commission_rate" value="{{ $merchant->default_commission_rate }}">
        </div>
        <button type="submit">Submit Profile</button>
    </form>
@endsection
@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/address_edit.css') }}">
@endsection

@section('content')
<div class="address-edit-container">
    <h1>住所の変更</h1>

    <form action="{{ route('address.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $address->postal_code ?? '') }}">
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address" id="address" value="{{ old('address', $address->address ?? '') }}">
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" name="building" id="building" value="{{ old('building', $address->building ?? '') }}">
        </div>

        <div class="form-group">
            <button type="submit" class="update-button">更新する</button>
        </div>
    </form>
</div>
@endsection
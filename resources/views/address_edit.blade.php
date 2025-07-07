@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/address_edit.css') }}">
@endsection

@section('content')
<div class="address-edit-container">
    <h1>住所の変更</h1>

    <form action="{{ route('address.update') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="postcode">郵便番号</label>
            <input type="text" name="postcode" id="postcode" value="{{ old('postcode', $user->postcode ?? '') }}">
            @error('postcode')
            <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror

        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address" id="address" value="{{ old('address', $user->address ?? '') }}">
            @error('address')
            <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror

        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" name="building" id="building" value="{{ old('building', $user->building ?? '') }}">
            @error('building')
            <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror

        </div>

        <div class="form-group">
            <button type="submit" class="update-button">更新する</button>
        </div>
    </form>
</div>
@endsection
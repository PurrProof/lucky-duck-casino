@extends('layouts.app')

@section('title', 'Registration')
@section('header')
<h1 class="title">Registration Form</h1>
@endsection

@section('content')
@if (session('success'))
<div class="notification is-success">
    <button class="delete"></button>
    {{ session('success') }}
</div>
@endif

@if (session('link'))
<div class="notification is-info">
    <button class="delete"></button>
    <p>Your unique login link:</p>
    <a href="{{ route('user.login', ['uuid' => session('link')]) }}">
        {{ route('user.login', ['uuid' => session('link')]) }}
    </a>
    <p class="has-text-gray is-size-7">Link displayed after registration is <span class="tag">for demo</span> only. In production, SMS queues will be used for sending links.</p>
</div>
@endif

@if ($errors->any())
<div class="notification is-danger">
    <button class="delete"></button>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="columns">
    <div class="column is-tree-quarters">
        <form action="{{ route('user.register.submit') }}" method="POST" class="box">
            @csrf

            <div class="field">
                <label class="label" for="login">Username:</label>
                <div class="control">
                    <input class="input" type="text" id="login" name="login"
                        value="{{ old('login') }}"
                        placeholder="Username"
                        ___minlength="3" ___maxlength="50"
                        ___pattern1="^[a-zA-Z0-9_\-]+$"
                        ___required>
                </div>
                <p class="help">Username must be 3-50 characters long and can contain only letters, numbers, dashes (-), and underscores (_).</p>
            </div>

            <div class="field">
                <label class="label" for="phone">Phone:</label>
                <div class="control">
                    <input class="input" type="tel" id="phone" name="phone"
                        value="{{ old('phone') }}"
                        placeholder="+1234567890"
                        ___pattern="^\+?[1-9]\d{7,15}$"
                        ___required>
                </div>
                <p class="help">Enter phone number in international format, e.g., +1234567890.</p>
            </div>

            <div class="field">
                <div class="control">
                    <button type="submit" class="button is-primary">Register</button>
                </div>
            </div>

            @include('partials.comments')

        </form>
    </div>
    <div class="column is-one-quarter">
        <div class="box is-rounded mb-5 content">
            <h5>Existing Users (for test)</h5>
            <ul class="menu-list is-size-7">
                @foreach (\App\Models\User::all() as $user)
                <li>
                    <a href="#" class="user-link" data-login="{{ $user->login }}" data-phone="{{ $user->phone }}">
                        {{ $user->login }} / {{ $user->phone }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

@if (session('success'))
<div class="notification is-success">
    {{ session('success') }}
</div>
@endif

@if ($errors->any())
<div class="notification is-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="tabs is-boxed">
    <ul>
        <li class="is-active">
            <a href="#games">
                <span class="icon is-small"><i class="fas fa-dice" aria-hidden="true"></i></span>
                <span>Games</span>
            </a>
        </li>
        <li>
            <a href="#links">
                <span class="icon is-small"><i class="fas fa-link" aria-hidden="true"></i></span>
                <span>Links</span>
            </a>
        </li>
    </ul>
</div>

<div id="tabs-content">
    <!-- Links Content -->
    <div id="links" class="tab-content">
        @include('partials.games', ['games' => $games])
    </div>

    <!-- Games Content -->
    <div id="games" class="tab-content" style="display: none;">
        @include('partials.links', ['links' => $links])
    </div>
</div>

@endsection
@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card p-4 text-center">
        <h2>Wil je uitloggen?</h2>
        <p>Je staat op het punt om je sessie te beëindigen.</p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">Uitloggen</button>
            <a href="{{ route('home') }}" class="btn btn-secondary">Annuleren</a>
        </form>
    </div>
</div>
@endsection

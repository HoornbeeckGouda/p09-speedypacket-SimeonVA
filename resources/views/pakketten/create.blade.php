@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row vh-100">
        <aside class="col-12 col-md-2 text-white d-flex flex-column justify-content-between p-3" style="background-color: #1e3a8a;">
            <div>
                <h1 class="h4 mb-4">SPEEDYPACKET</h1>
                <nav class="nav flex-column">
                    <a href="{{ route('dashboard') }}" class="nav-link text-white rounded mb-2">Dashboard</a>
                    <a href="{{ route('pakketten.index') }}" class="nav-link text-white rounded mb-2">Pakketten</a>
                    <a href="{{ route('pakketten.create') }}" class="nav-link text-white rounded mb-2 active">Nieuw Pakket</a>
                    <a href="{{ route('logout') }}" class="nav-link text-white rounded mb-2"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Uitloggen</a>
                </nav>
            </div>
            <div class="text-white">
                <strong>{{ Auth::user()->name }}</strong>
                <div class="small"><span class="text-success"></span></div>
            </div>
        </aside>

        <main class="col-12 col-md-10 p-4 bg-light">
            <h2 style="color: #1e3a8a;">Nieuw Pakket Aanmaken</h2>

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Fout bij aanmaken:</strong>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="card border-0 shadow-sm mt-3">
                <div class="card-header text-white" style="background-color:#1e3a8a;">
                    Pakketgegevens
                </div>
                <div class="card-body">
                    <form action="{{ route('pakketten.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ontvanger <span class="text-danger">*</span></label>
                                <select name="ontvanger_id" class="form-select @error('ontvanger_id') is-invalid @enderror" required>
                                    <option value="">Selecteer ontvanger</option>
                                    @foreach($ontvangers as $ontvanger)
                                        <option value="{{ $ontvanger->id }}" {{ old('ontvanger_id') == $ontvanger->id ? 'selected' : '' }}>
                                            {{ $ontvanger->name }} ({{ $ontvanger->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('ontvanger_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Product</label>
                                <select name="product_id" class="form-select @error('product_id') is-invalid @enderror">
                                    <option value="">Selecteer product</option>
                                    @foreach($producten as $product)
                                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                            {{ $product->naam }} 
                                            @if($product->prijs) - €{{ number_format($product->prijs, 2, ',', '.') }} @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="besteld" {{ old('status') == 'besteld' ? 'selected' : '' }}>Besteld</option>
                                    <option value="onderweg" {{ old('status') == 'onderweg' ? 'selected' : '' }}>Onderweg</option>
                                    <option value="afgeleverd" {{ old('status') == 'afgeleverd' ? 'selected' : '' }}>Afgeleverd</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Verwachte Leverdatum</label>
                                <input type="date" name="verwachte_leverdatum" 
                                       class="form-control @error('verwachte_leverdatum') is-invalid @enderror" 
                                       value="{{ old('verwachte_leverdatum') }}">
                                @error('verwachte_leverdatum')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <strong>Let op:</strong> QR-code en Track & Trace worden automatisch gegenereerd.
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-lg text-white px-5" style="background-color:#1e3a8a;">
                                Pakket Aanmaken
                            </button>
                            <a href="{{ route('pakketten.index') }}" class="btn btn-lg btn-secondary ms-2">
                                Annuleren
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>

<style>
    .nav-link:hover { background-color: rgba(255,255,255,0.1); }
    .active { background-color: rgba(255,255,255,0.2); }
</style>
@endsection
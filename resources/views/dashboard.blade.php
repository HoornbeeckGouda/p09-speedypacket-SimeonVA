@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row vh-100">
        <aside class="col-12 col-md-2 text-white d-flex flex-column justify-content-between p-3" style="background-color: #1e3a8a;">
            <div>
                <h1 class="h4 mb-4">SPEEDYPACKET</h1>
                <nav class="nav flex-column">
                    <a href="{{ route('dashboard') }}" class="nav-link text-white rounded mb-2 active">Dashboard</a>
                    <a href="{{ route('pakketten.index') }}" class="nav-link text-white rounded mb-2">Pakketten</a>
                    <a href="{{ route('pakketten.create') }}" class="nav-link text-white rounded mb-2">Nieuw Pakket</a>
                    <a href="{{ route('logout') }}" class="nav-link text-white rounded mb-2"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Uitloggen</a>
                </nav>
            </div>
            <div class="text-white">
                <strong>{{ Auth::user()->name }}</strong>
            </div>
        </aside>

        <main class="col-12 col-md-10 p-4 bg-light">
            <h2 style="color: #1e3a8a;">Overzicht Pakketten</h2>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('pakketten.index') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Zoek product" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Alle statussen</option>
                                <option value="besteld" {{ request('status') == 'besteld' ? 'selected' : '' }}>Besteld</option>
                                <option value="verwerkt" {{ request('status') == 'verwerkt' ? 'selected' : '' }}>Verwerkt</option>
                                <option value="onderweg" {{ request('status') == 'onderweg' ? 'selected' : '' }}>Onderweg</option>
                                <option value="afgeleverd" {{ request('status') == 'afgeleverd' ? 'selected' : '' }}>Afgeleverd</option>
                                <option value="geannuleerd" {{ request('status') == 'geannuleerd' ? 'selected' : '' }}>Geannuleerd</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="datum" class="form-control" value="{{ request('datum') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn text-white w-100" style="background-color: #1e3a8a;">Zoeken</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #1e3a8a;">
                    <span>Pakketten</span>
                    <a href="{{ route('pakketten.create') }}" class="btn btn-light btn-sm">+ Nieuw</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr style="background-color: #f1f5f9;">
                                    <th>QR Code</th>
                                    <th>Track & Trace</th>
                                    <th>Ontvanger</th>
                                    <th>Product</th>
                                    <th>Status</th>
                                    <th>Leverdatum</th>
                                    <th>Acties</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pakketten as $pakket)
                                <tr>
                                    <td><span class="badge bg-secondary">{{ $pakket->qr_code }}</span></td>
                                    <td>{{ $pakket->track_and_trace }}</td>
                                    <td>{{ $pakket->ontvanger->name }}</td>
                                    <td>
                                        @if($pakket->product)
                                            <strong>{{ $pakket->product->naam }}</strong>
                                            @if($pakket->product->prijs)
                                                <br><small class="text-muted">€{{ number_format($pakket->product->prijs, 2, ',', '.') }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted">Geen product</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                        $colors = ['besteld' => 'warning', 'verwerkt' => 'info', 'onderweg' => 'primary', 'afgeleverd' => 'success', 'geannuleerd' => 'danger'];
                                        @endphp
                                        <span class="badge bg-{{ $colors[$pakket->status] ?? 'secondary' }}">{{ ucfirst($pakket->status) }}</span>
                                    </td>
                                    <td>{{ $pakket->verwachte_leverdatum ? $pakket->verwachte_leverdatum->format('d-m-Y') : '-' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('pakketten.show', $pakket) }}" class="btn btn-sm btn-outline-primary" title="Bekijken">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('pakketten.edit', $pakket) }}" class="btn btn-sm text-white" style="background-color: #1e3a8a;" title="Bewerken">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                                </svg>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{ $pakket->id }}" title="Verwijderen">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="modal fade" id="delete{{ $pakket->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">Pakket Verwijderen</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Weet je zeker dat je pakket <strong>{{ $pakket->qr_code }}</strong> wilt verwijderen?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                                                        <form action="{{ route('pakketten.destroy', $pakket) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Verwijderen</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Geen pakketten gevonden</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($pakketten->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $pakketten->links() }}
                    </div>
                    @endif
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
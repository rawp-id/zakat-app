@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        {{-- <div class="d-flex align-items-center justify-content-between">
            <h2 class="mb-4">Konfirmasi Zakat</h2>
        </div> --}}
        <x-navbar title="Konfirmasi Zakat" />

        <div class="d-flex align-items-center justify-content-end mt-3">
            {{-- <h2 class="mb-4">Daftar Zakat</h2> --}}
            <a href="{{ route('zakats.create') }}" class="btn btn-primary mb-3">Tambah Zakat</a>
        </div>

        <div class="card">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($pendingZakats->count() > 0)
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Nama</th>
                                    {{-- <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Telepon</th> --}}
                                    <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Jumlah</th>
                                    <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendingZakats as $zakat)
                                    <tr>
                                        <td>{{ ucwords($zakat->name) }}</td>
                                        {{-- <td>{{ $zakat->phone }}</td> --}}
                                        <td>{{ number_format($zakat->amount) }}</td>
                                        <td>
                                            <form action="{{ route('zakats.approve', $zakat->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success btn-sm"
                                                    onclick="return confirm('Setujui zakat ini?')">ACC</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $pendingZakats->links() }}
                @else
                    <p class="text-muted">Tidak ada zakat yang perlu dikonfirmasi.</p>
                @endif
            </div>
        </div>


    </div>
@endsection

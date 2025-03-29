@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        <x-navbar title="Daftar Zakat" />

        <div class="row mb-2">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">Zakat Sah</h5>
                    </div>

                    <div class="card-body">
                        <h2>{{ $approve_zakat }} ({{ $approve_zakat * 2.5 }})</h2>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">Tidak Sah Zakat</h5>
                    </div>

                    <div class="card-body">
                        <h2>{{ $cancel_zakat }}</h2>
                    </div>
                </div>
            </div>

        </div>

        <div class="d-flex align-items-center justify-content-end mt-3">
            {{-- <h2 class="mb-4">Daftar Zakat</h2> --}}
            <a href="{{ route('zakats.create') }}" class="btn btn-primary mb-3">Tambah Zakat</a>
        </div>

        <div class="card">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Nama</th>
                                {{-- <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Telepon</th> --}}
                                <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Jumlah</th>
                                <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Status</th>
                                @if (Auth::user()->master)
                                    <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($zakats as $zakat)
                                <tr>
                                    <td>{{ ucwords($zakat->name) }}</td>
                                    {{-- <td>{{ $zakat->phone }}</td> --}}
                                    <td>{{ number_format($zakat->amount) }}</td>
                                    <td><span
                                            class="badge bg-{{ $zakat->status == 'pending' ? 'warning' : ($zakat->status == 'approved' ? 'success' : 'danger') }}">
                                            {{ ucfirst($zakat->status) }}
                                        </span></td>
                                    @if (Auth::user()->master)
                                        <td>
                                            <div class="mt-3">
                                                {{-- <a href="{{ route('zakats.show', $zakat) }}" --}}
                                                {{--     class="btn btn-info btn-sm">Lihat</a> --}}
                                                <a href="{{ route('zakats.edit', $zakat) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('zakats.destroy', $zakat) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Hapus zakat ini?')">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $zakats->links() }}
            </div>
        </div>


    </div>
@endsection

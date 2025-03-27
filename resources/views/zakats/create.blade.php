@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        @if (Auth::user()->is_admin)
            <x-navbar title="Tambah Zakat" />
            {{-- <h2>Tambah Zakat</h2> --}}
            <div class="card mt-2">
                <div class="card-body">
                    <form action="{{ isset($zakat) ? route('zakats.update', $zakat) : route('zakats.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @if (isset($zakat))
                            @method('PUT')
                        @endif
                        @include('zakats.form')
                    </form>
                </div>
            </div>
        @else
            <x-navbar title="{{ isset($zakat) ? 'Data Zakat' : 'Tambah Zakat' }}" />
            <div class="card mt-2">
                <div class="card-body">
                    @if (isset($zakat))
                        <h5>Nama: {{ $zakat->name }}</h5>
                        <h5>Telepon: {{ $zakat->phone }}</h5>
                        <h5>Alamat: {{ $zakat->address }}</h5>
                        <h5>Jumlah Zakat: {{ $zakat->amount }}</h5>
                        @php
                            $partOfZakat = json_decode($zakat->part_of_zakat, true) ?? [];
                        @endphp

                        @if (!empty($partOfZakat))
                            <h5>Bagian dari Zakat:</h5>
                            <ul>
                                @foreach ($partOfZakat as $person)
                                    <li>{{ $person }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p><i>Tidak ada data zakat lain.</i></p>
                        @endif
                    @endif

                    @if (!isset($zakat))
                        <form action="{{ isset($zakat) ? route('zakats.update', $zakat) : route('zakats.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @if (isset($zakat))
                                @method('PUT')
                            @endif
                            @include('zakats.form')
                        </form>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection

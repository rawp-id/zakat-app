@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">Zakat Sah</h5>
                    </div>

                    <div class="card-body">
                        <h2>{{ $approve_zakat }}</h2>
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
    </div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mt-2">
    <x-navbar title="Edit Zakat" />
    {{-- <h2>Edit Zakat</h2> --}}
    <form action="{{ isset($zakat) ? route('zakats.update', $zakat) : route('zakats.store') }}" method="POST" enctype="multipart/form-data">
        @if(isset($zakat)) @method('PUT') @endif
        @include('zakats.form')
    </form>
</div>
@endsection

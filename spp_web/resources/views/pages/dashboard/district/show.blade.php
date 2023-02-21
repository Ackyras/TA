@extends('layouts.app')

@section('title', 'Detail Kecamatan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Kecamatan {{ $district->name }}</h3>
        <div class="card-tools">
            <span class="badge badge-primary">Label</span>
        </div>
    </div>
    <div class="card-body">
        {{--
        <x-table.datatable :table="$districtTable" /> --}}
        <table class="table table-sm w-auto table-borderless">
            <tr scope="row">
                <th class="w-auto" scope="col">Nama Kecamatan</th>
                <th class="w-auto" scope="col">:</th>
                <td class="w-auto" scope="col">{{ $district->name }}</td>
            </tr>
            <tr scope="row">
                <th class="w-auto" scope="col">Jumlah Desa</th>
                <th class="w-auto" scope="col">:</th>
                <td class="w-auto" scope="col">{{ $district->villages_count }}</td>
            </tr>
            <tr scope="row">
                <th class="w-auto" scope="col">Jumlah Kelompok Tani</th>
                <th class="w-auto" scope="col">:</th>
                <td class="w-auto" scope="col">{{ $district->farmers_count }}</td>
            </tr>
        </table>
        <x-table.datatable :table="$table" />
    </div>
</div>
@endsection
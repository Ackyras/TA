@extends('layouts.app')

@section('title', 'Detail Kecamatan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Kecamatan {{ $district->name }}</h3>
        <div class="card-tools">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editDistrictModal">
                Perbarui Kecamatan
            </button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createVillageModal">
                Tambah Desa
            </button>
            <!-- Edit District Modal -->
            <div class="modal fade" id="editDistrictModal" tabindex="-1" role="dialog"
                aria-labelledby="editDistrictModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editDistrictModalLabel">Edit Kecamatan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('dashboard.district.update', $district) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <x-form.input.text name="name" title="Nama Kecamatan" value="{{ $district->name }}" />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="createVillageModal" tabindex="-1" role="dialog"
                aria-labelledby="createVillageModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createVillageModalLabel">Tambah Desa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('dashboard.village.store') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <p>Tambah desa untuk Kecamatan {{ $district->name }}</p>
                                <x-form.input.text name="name" title="Nama Desa" />
                                <x-form.input.hidden name="district_id" value="{{ $district->id }}" />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{--
        <x-table.datatable :table="$districtTable" /> --}}
        <table class="table w-auto table-sm table-borderless">
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

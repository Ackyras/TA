@extends('layouts.app')

@section('title', 'Detail Desa')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detail Desa {{ $village->name }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editVillageModal">
                    Perbarui Desa
                </button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createVillageModal">
                    Tambah Kelompok Tani
                </button>
                <!-- Add Farmer Modal -->
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
                            <form action="{{ route('dashboard.farmer.store') }}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <p>Tambah desa untuk Kecamatan {{ $village->name }}</p>
                                    <x-form.input.text name="name" title="Nama Kelompok Tani" />
                                    <x-form.input.text name="address" title="Alamat" />
                                    <x-form.input.text name="pic" title="Kepala Kelompok Tani" />
                                    <x-form.input.hidden name="village_id" value="{{ $village->id }}" />
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Edit District Modal -->
                <div class="modal fade" id="editVillageModal" tabindex="-1" role="dialog"
                    aria-labelledby="editVillageModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editVillageModalLabel">Edit Desa</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('dashboard.village.update', $village) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <x-form.input.text name="name" title="Nama Desa" value="{{ $village->name }}" />
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            {{--
        <x-table.datatable :table="$villageTable" /> --}}
            <table class="table table-sm w-auto table-borderless">
                <tr scope="row">
                    <th class="w-auto" scope="col">Nama Desa</th>
                    <th class="w-auto" scope="col">:</th>
                    <td class="w-auto" scope="col">{{ $village->name }}</td>
                </tr>
                <tr scope="row">
                    <th class="w-auto" scope="col">Jumlah Kelompok Tani</th>
                    <th class="w-auto" scope="col">:</th>
                    <td class="w-auto" scope="col">{{ $village->farmers_count }}</td>
                </tr>
            </table>
            <x-table.datatable :table="$table" />
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Detail Desa')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Desa {{ $village->name }}</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createVillageModal">
                Tambah
            </button>

            <!-- Modal -->
            <div class="modal fade" id="createVillageModal" tabindex="-1" role="dialog"
                aria-labelledby="createVillageModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createVillageModalLabel">Tambah Kecamatan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('dashboard.district.store') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <x-form.input.option name="district_id" title="Kecamatan" :options="$districts" />
                                <x-form.input.text name="name" title="Nama Desa" />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
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
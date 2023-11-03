@extends('layouts.app')

@section('title', 'Detail Kelompok Tani')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detail {{ $datas['farmer']->name }}</h3>
            <div class="card-tools">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editDistrictModal">
                    Perbarui Kelompok Tani
                </button>
                <a class="btn btn-primary"
                    href="{{ route('dashboard.request.create', ['farmer' => $datas['farmer']->id]) }}">Tambah
                    Pengajuan Bantuan</a>
                {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createVillageModal">
                    Tambah Pengajuan Bantuan
                </button> --}}
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
                            <form action="{{ route('dashboard.farmer.update', $datas['farmer']) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <x-form.input.text name="name" title="Nama Kelompok Tani"
                                        value="{{ $datas['farmer']->name }}" />
                                    <x-form.input.text name="pic" title="Alamat"
                                        value="{{ $datas['farmer']->address }}" />
                                    <x-form.input.text name="pic" title="Nama PIC"
                                        value="{{ $datas['farmer']->pic }}" />
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
            <table class="table w-auto table-sm table-borderless">
                <tr scope="row">
                    <th class="w-auto" scope="col">Nama Kelompok Tani</th>
                    <th class="w-auto" scope="col">:</th>
                    <td class="w-auto">{{ $datas['farmer']->name }}</td>
                </tr>
                <tr scope="row">
                    <th class="w-auto" scope="col">Jumlah Proposal Bantuan Tani</th>
                    <th class="w-auto" scope="col">:</th>
                    <td class="w-auto">{{ $datas['farmer']->requests_count }}</td>
                </tr>
            </table>
            {{-- <x-table.datatable :table="$table" /> --}}
            <table id="datatable" class="table table-bordered table-hover">
                <thead>
                    <th>Usulan</th>
                    <th>volume</th>
                    <th>Satuan</th>
                    <th>Proposal & Data Pendukung Lainnya</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    @foreach ($datas['farmer']->requests as $request)
                        <tr>
                            <td>
                                {{ $request->program->name }}
                            </td>
                            <td>{{ $request->volume }}</td>
                            <td>{{ $request->unit->name }}({{ $request->unit->code }})</td>
                            <td>
                                @if ($request->attachments)
                                    <ul>
                                        @forelse ($request->attachments as $attachment)
                                            <li>
                                                <a href="{{ $attachment->url }}" target="_blank" rel="noopener noreferrer">
                                                    {{ $attachment->name }}
                                                </a>
                                            </li>
                                        @empty
                                        @endforelse
                                    </ul>
                                @endif
                            </td>
                            <td>{{ str($request->status)->ucfirst() }}</td>
                            <td class="d-flex d-inline-block">
                                <x-button text="Lihat" type="redirect" :route="route('dashboard.request.show', $request)" color="primary" />
                                <x-button text="Hapus" type="delete" :route="route('dashboard.request.destroy', $request)" color="danger" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

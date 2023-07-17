@extends('layouts.app')

@section('title', 'List Of Request')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="card-title">List Proposal Bantuan Koordinator Penyuluh</h3>
                </div>
                <div class="col-auto">
                    <a href="{{ route('dashboard.request.create') }}" class="btn btn-primary">Tambah</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="datatable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Kelompok Tani</th>
                        <th>Usulan</th>
                        <th>volume</th>
                        <th>Satuan</th>
                        <th>Proposal & Data Pendukung Lainnya</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $farmer => $requests)
                        @foreach ($requests as $request)
                            <tr>
                                <td>{{ $request->farmer->name }}</td>
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
                                                    <a href="{{ $attachment->url }}" target="_blank"
                                                        rel="noopener noreferrer">
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

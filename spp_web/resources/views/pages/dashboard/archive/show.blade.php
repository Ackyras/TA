@extends('layouts.app')

@section('title', 'Arsip Periode ' . $period->name)

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List</h3>
        </div>
        <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Nama Arsip</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Pengajuan</td>
                        <td>
                            <div class="d-flex d-inline-block">
                                <x-button text="Lihat" type="redirect" :route="route('dashboard.archive.request.index', ['period' => $period])" color="primary" />
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

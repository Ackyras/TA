@extends('layouts.app')

@section('title', 'List User')

@section('content')
    <div class="card">
        <div class="card-header align-items-center">
            <h3 class="card-title">List</h3>
            <div class="card-tools">
                <a href="{{ route('dashboard.setting.user.create') }}" role="button" class="btn btn-primary btn-sm">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            <x-table.datatable :table="$userTable" />
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Arsip Periode')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List</h3>
        </div>
        <div class="card-body">
            <x-table.datatable :table="$periods" />
        </div>
    </div>
@endsection

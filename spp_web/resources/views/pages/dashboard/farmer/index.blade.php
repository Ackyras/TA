@extends('layouts.app')

@section('title', 'List Kelompok Tani')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">list Kelompok Tani</h3>
        <div class="card-tools">
            <span class="badge badge-primary">Label</span>
        </div>
    </div>
    <div class="card-body">
        <x-table.datatable :table="$farmerTable" />
    </div>
</div>
@endsection
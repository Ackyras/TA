@extends('layouts.app')

@section('title', 'List User')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List</h3>
            <div class="card-tools">
                <span class="badge badge-primary">Label</span>
            </div>
        </div>
        <div class="card-body">
            <x-table.datatable :table="$userTable" />
        </div>
    </div>
@endsection

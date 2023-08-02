@extends('layouts.app')

@section('title', 'Detail Bidang')

@section('content')
    <div class="card">
        <form action="{{ route('dashboard.setting.division.update', $division) }}" method="POST">
            <div class="card-header">
                <h3 class="card-title">Detail Bidang {{ $division->name }}</h3>
                <div class="card-tools">
                    <span class="badge badge-primary">Label</span>
                </div>
            </div>
            @csrf
            @method('PUT')
            <div class="card-body">
                <x-form.input.text name="name" title="Name" :value="$division->name" :in-line="true" />
                <x-form.input.text name="nickname" title="Kode" :value="$division->nickname" :in-line="true" />
            </div>
            <div class="card-footer d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
@endsection

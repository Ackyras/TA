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
            <table id="requestTable" class="table table-bordered table-hover">
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
                    @foreach ($datas['items'] as $requests)
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
            <div class="mt-4 d-flex justify-content-between">
                <div>
                    Showing {{ $datas['paginator']->firstItem() }} to {{ $datas['paginator']->lastItem() }} of
                    {{ $datas['paginator']->total() }} entries
                </div>
                @if ($datas['paginator']->lastPage() > 1)
                    <div class="btn-group pagination">
                        @if ($datas['paginator']->currentPage() > 1)
                            <a class="btn btn-default"
                                href="{{ $datas['paginator']->url($datas['paginator']->currentPage() - 1) }}">Previous</a>
                        @endif

                        @php
                            $startRange = max($datas['paginator']->currentPage() - 2, 1);
                            $endRange = min($datas['paginator']->currentPage() + 2, $datas['paginator']->lastPage());
                        @endphp

                        @if ($startRange > 1)
                            <a class="btn btn-default" href="{{ $datas['paginator']->url(1) }}">1</a>
                            @if ($startRange > 2)
                                <a class="btn btn-default" href="{{ $datas['paginator']->url(2) }}">2</a>
                                @if ($startRange > 3)
                                    <a class="btn btn-default"
                                        href="{{ $datas['paginator']->url($startRange - 1) }}">...</a>
                                @endif
                            @endif
                        @endif
                        @for ($page = $startRange; $page <= $endRange; $page++)
                            <a class="btn btn-{{ $datas['paginator']->currentPage() === $page ? 'primary' : 'default' }}"
                                href="{{ $datas['paginator']->url($page) }}">{{ $page }}</a>
                        @endfor
                        @if ($endRange < $datas['paginator']->lastPage() - 2)
                            <a class="btn btn-default"
                                href="{{ $datas['paginator']->url($datas['paginator']->lastPage() - 3) }}">
                                ...
                            </a>
                        @endif
                        @if ($endRange < $datas['paginator']->lastPage())
                            @if ($endRange < $datas['paginator']->lastPage() - 1)
                                <a class="btn btn-default"
                                    href="{{ $datas['paginator']->url($datas['paginator']->lastPage() - 1) }}">
                                    {{ $datas['paginator']->lastPage() - 1 }}
                                </a>
                            @endif
                            <a class="btn btn-default"
                                href="{{ $datas['paginator']->url($datas['paginator']->lastPage()) }}">
                                {{ $datas['paginator']->lastPage() }}
                            </a>
                        @endif
                        @if ($datas['paginator']->currentPage() < $datas['paginator']->lastPage())
                            <a class="btn btn-default"
                                href="{{ $datas['paginator']->url($datas['paginator']->currentPage() + 1) }}">Next</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

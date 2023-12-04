@extends('layouts.app')

@section('title', 'List Of Request')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="card-title">List Proposal Bantuan</h3>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.request.index') }}" method="GET" class="mb-3">
                <div class="border-0 card">
                    <div class="p-2 card-header" data-toggle="collapse" data-target="#filterCard" aria-expanded="false"
                        aria-controls="filterCard">
                        <a class="mb-0 card-title font-weight-bold">Filter</a>
                        <button class="float-right p-0 btn btn-link btn-sm" type="button" data-toggle="collapse"
                            data-target="#filterCard" aria-expanded="false" aria-controls="filterCard">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div id="filterCard" class="collapse">
                        <div class="p-2 card-body">
                            <div class="form-group row">
                                <label for="status" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <select class="form-control select2bs4" id="select2" name="filter[status]">
                                        <option @selected(request()->input('filter.status') == '') value="">Semua</option>
                                        <option @selected(request()->input('filter.status') == 'pending') value="pending">Pending</option>
                                        <option @selected(request()->input('filter.status') == 'requested') value="requested">Requested</option>
                                        <option @selected(request()->input('filter.status') == 'approved') value="approved">Approved</option>
                                        <option @selected(request()->input('filter.status') == 'done') value="done">Done</option>
                                        <option @selected(request()->input('filter.status') == 'declined') value="declined">Declined</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="program_id" class="col-sm-2 col-form-label">Kamus Usulan</label>
                                <div class="col-sm-10">
                                    <select class="form-control select2" id="dictionary"
                                        name="filter[proposal_dictionary_id]" style="width: 100%;">
                                        <option @selected(request()->input('filter.proposal_dictionary_id') == '') value="">Semua</option>
                                        @foreach ($datas['proposalDictionaries'] as $proposalDictionary)
                                            <option value="{{ $proposalDictionary->id }}" @selected(request()->input('filter.proposal_dictionary_id') == $proposalDictionary->id)>
                                                {{ $proposalDictionary->name }}({{ $proposalDictionary->division->nickname }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="p-2 card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </div>
            </form>
            <table id="requestTable" class="table table-bordered table-hover">
                <thead>
                    <tr class="text-center">
                        <th scope="col" rowspan="2">Kelompok Tani</th>
                        <th scope="col" rowspan="2">Usulan</th>
                        <th scope="col" colspan="2">Target</th>
                        <th scope="col" rowspan="2">Realisasi</th>
                        <th scope="col" rowspan="2">Proposal & Data Pendukung Lainnya</th>
                        <th scope="col" rowspan="2">Status</th>
                        <th scope="col" rowspan="2">Aksi</th>
                    </tr>
                    <tr class="text-center">
                        <th scope="col">volume</th>
                        <th scope="col">Satuan</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas['items'] as $requests)
                        @foreach ($requests as $request)
                            <tr>
                                <td>{{ $request->farmer->name }}({{ $request->id }})</td>
                                <td>
                                    {{ $request->program->name }}
                                </td>
                                <td>{{ $request->volume }}</td>
                                <td>{{ $request->unit->name }}({{ $request->unit->code }})</td>
                                <td>
                                    @isset($request->results)
                                        <ul>
                                            @foreach ($request->results as $result)
                                                <li>
                                                    {{ $result->volume }} {{ $result->unit->name }}
                                                    ({{ $result->created_at }})
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        -
                                    @endisset
                                </td>
                                <td>
                                    @if ($request->attachments)
                                        <ul>
                                            @forelse ($request->attachments as $attachment)
                                                <li>
                                                    <a href="{{ Storage::url($attachment->url) }}" target="_blank"
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
                                <td>
                                    <div class="d-flex d-inline-block">
                                        <x-button text="Lihat" type="redirect" :route="route('dashboard.request.show', $request)" color="primary" />
                                        <x-button text="Hapus" type="delete" :route="route('dashboard.request.destroy', $request)" color="danger" />
                                    </div>
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

@section('script')
    <script>
        $(document).ready(function() {
            $('#dictionary').select2({
                theme: 'bootstrap4',
                width: 'resolve'
            });
            $('#select2').select2({
                theme: 'bootstrap4',
                width: 'resolve'
            });
        });
    </script>
@endsection

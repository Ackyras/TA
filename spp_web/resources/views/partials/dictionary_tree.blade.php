<div class="px-3 py-2 subprogram-item">
    <div class="d-flex align-items-center">
        <!-- Display necessary icons and information about the program here -->
        @isset($parent->parent_id)
            <i class="mr-2 fas fa-level-up-alt" style="transform: rotate(90deg);"></i>
        @endisset
        @if (isset($parent->lowerProgramTreeAndDictionaries) || isset($parent->proposalDictionaries))
            <strong>
                {{ $parent['code'] }}:{{ $parent['name'] }}
            </strong>
        @else
            {{ $parent['name'] }} <strong>
                <a href="{{ route('dashboard.setting.division.show', $parent->division_id) }}">
                    ({{ $divisions->where('id', $parent->division_id)->first()->name }})
                </a>
            </strong>
        @endif

        <div class="ml-auto">
            <!-- Display buttons and modals for creating, editing, and deleting programs here -->
            <div class="row">
                @if ($parent instanceof \App\Models\Program)
                    <div class="col-auto">
                        <button type="button" class="p-0 btn btn-sm btn-light rounded-circle" data-toggle="modal"
                            data-target="#createSubProgramModal_{{ $parent['id'] }}">
                            <i class="fas fa-plus text-primary"></i>
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="createSubProgramModal_{{ $parent['id'] }}" tabindex="-1"
                            role="dialog" aria-labelledby="createSubProgramModal_{{ $parent['id'] }}Label"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createSubProgramModal_{{ $parent['id'] }}Label">
                                            Tambah
                                            Sub
                                            Program
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('dashboard.setting.proposalDictionary.store') }}"
                                        method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <x-form.input.hidden name='parent_id' :value="$parent['id']" />
                                            <x-form.input.text name="name" title="Nama Kamus Usulan" />

                                            <div class="form-group">
                                                <label for="division_id" class="col-sm-2 col-form-label">Bidang</label>
                                                <div class="custom-select-wrapper">
                                                    @if (auth()->user()->roles()->first()->id !== 2)
                                                        <select class="custom-select select2bs4" id="division_id"
                                                            name="division_id">
                                                            @foreach ($divisions as $division)
                                                                <option value="{{ $division->id }}"
                                                                    @if (old('division_id') == $division->id) selected @endif>
                                                                    {{ $division->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Tambah</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($parent instanceof \App\Models\ProposalDictionary)
                    <div class="col-auto">
                        <button type="button" class="p-0 btn btn-sm btn-light rounded-circle" data-toggle="modal"
                            data-target="#editSubProgram_{{ $parent['id'] }}">
                            <i class="fas fa-edit text-info"></i>
                        </button>

                        <div class="modal fade" id="editSubProgram_{{ $parent['id'] }}" tabindex="-1" role="dialog"
                            aria-labelledby="editSubProgram_{{ $parent['id'] }}Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editSubProgram_{{ $parent['id'] }}Label">Perbarui
                                            Sub
                                            Program
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form
                                        action="{{ route('dashboard.setting.proposalDictionary.update', $parent['id']) }}"
                                        method="POST">
                                        <div class="modal-body">
                                            @csrf
                                            @method('PUT')
                                            <x-form.input.text name=" name" title="Nama Kamus Usulan"
                                                :value="$parent['name']" />
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-info">Perbarui</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-auto">
                        <form action="{{ route('dashboard.setting.proposalDictionary.destroy', $parent['id']) }}"
                            method="POST"
                            @if ($parent['is_parent']) onsubmit="return confirm('Seluruh Sub-Program juga akan ikut terhapus, anda yakin?');" @else
                        onsubmit="return confirm('Yakin ingin menghapus Sub-Program?');" @endif>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-0 btn btn-sm btn-light rounded-circle">
                                <i class="fas fa-trash text-danger"></i>
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Recursively display lowerProgramTreeAndDictionaries -->
<div class="pl-4">
    @isset($parent->lowerProgramTreeAndDictionaries)
        @foreach ($parent->lowerProgramTreeAndDictionaries as $childProgram)
            @include('partials.dictionary_tree', ['parent' => $childProgram])
        @endforeach
    @endisset
    @isset($parent->proposalDictionaries)
        @foreach ($parent->proposalDictionaries as $proposalDictionary)
            @include('partials.dictionary_tree', ['parent' => $proposalDictionary])
        @endforeach
    @endisset
</div>

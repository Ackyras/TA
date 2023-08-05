@extends('layouts.app')

@section('title', 'Create User')

@section('content')
    <form action="{{ route('dashboard.setting.user.store') }}" method="POST" id="user-form">
        @csrf
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Identitas</h3>
            </div>
            <div class="card-body">
                <x-form.input.text name="name" title="Name" :in-line="true" />
                <x-form.input.text name="email" title="Email" :in-line="true" />
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-2">
                        <strong>Role</strong>
                    </div>
                    <div class="col row">
                        @foreach ($roles as $role)
                            <div class="col">
                                <x-form.input.radio name="roles" :title="$role->name" :value="$role->id"
                                    id="{{ 'roles_' . $role->id }}" :checked="old('roles') == $role->id" />
                            </div>
                        @endforeach
                    </div>
                </div>
                @error('roles')
                    <div class="mb-2 alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div id="divisions-form" style="display: none;">
                <hr>
                <div class="card-header">
                    <h3 class="card-title">Manajemen Bidang</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse ($divisions as $division)
                            <div class="col-md-3">
                                <x-form.input.checkbox name="divisions[]" :title="$division->name" :value="$division->id"
                                    id="{{ 'divisions_' . $division->id }}" :checked="$user->divisions->contains('id', $division->id)" />
                            </div>
                        @empty
                            <div class="col-md-3">
                                Belum ada data bidang tersimpan di database.
                                <a href="{{ route('dashboard.setting.division.create') }}">Klik di sini</a> untuk
                                menambahkan data Bidang
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            <div id="villages-form" style="display: none;">
                <hr>
                <div class="card-header">
                    <h3 class="card-title">Manajemen Desa</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="village-filter" class="col-sm-2 col-form-label">Filter Villages</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="village-filter">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="village-checkboxes">
                        @forelse ($villages as $village)
                            <div class="col-md-3">
                                <x-form.input.checkbox name="villages[]" :title="$village->name" :value="$village->id"
                                    id="{{ 'villages_' . $village->id }}" :checked="$user->villages->contains('id', $village->id)" />
                            </div>
                        @empty
                            <div class="col-md-3">
                                Belum ada data bidang tersimpan di database.
                                <a href="{{ route('dashboard.village.index') }}">Klik di sini</a> untuk
                                menambahkan data Desa
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            @error('divisions')
                <div class="mb-2 alert alert-danger">{{ $message }}</div>
            @enderror
            @error('villages')
                <div class="mb-2 alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="card-footer d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        // Get the checkboxes
        var rolesCheckboxes = document.querySelectorAll('[id^="roles_"]');
        var divisionsForm = document.getElementById('divisions-form');
        var villagesForm = document.getElementById('villages-form');
        var userForm = document.getElementById('user-form');
        var villageFilterInput = document.getElementById('village-filter');

        // Function to check if specific checkboxes are checked
        function areSpecificCheckboxesChecked(checkboxIds) {
            return checkboxIds.some(function(checkboxId) {
                var checkbox = document.getElementById(checkboxId);
                return checkbox && checkbox.checked;
            });
        }

        // Function to show or hide the forms based on checkbox state
        function toggleForms() {
            var divisionsFormVisible = areSpecificCheckboxesChecked(['roles_3']);
            var villagesFormVisible = areSpecificCheckboxesChecked(['roles_4']);
            divisionsForm.style.display = divisionsFormVisible ? 'block' : 'none';
            villagesForm.style.display = villagesFormVisible ? 'block' : 'none';

            // Disable or enable divisions checkboxes based on roles 1, 2, and 3
            var divisionsCheckboxes = divisionsForm.querySelectorAll('[id^="divisions_"]');
            divisionsCheckboxes.forEach(function(checkbox) {
                checkbox.disabled = !divisionsFormVisible;
            });

            // Disable or enable villages checkboxes based on roles 1, 2, and 4
            var villagesCheckboxes = villagesForm.querySelectorAll('[id^="villages_"]');
            villagesCheckboxes.forEach(function(checkbox) {
                checkbox.disabled = !villagesFormVisible;
            });
        }

        // Function to filter the villages based on the input value
        function filterVillages() {
            var filter = villageFilterInput.value.toLowerCase();
            var checkboxes = villagesForm.querySelectorAll('[id^="villages_"]');

            checkboxes.forEach(function(checkbox) {
                var title = checkbox.nextElementSibling.innerText.toLowerCase();
                if (title.includes(filter)) {
                    checkbox.closest('.col-md-3').style.display = 'block';
                } else {
                    checkbox.closest('.col-md-3').style.display = 'none';
                }
            });
        }

        // Add event listeners to the checkboxes
        rolesCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', toggleForms);
        });

        // Add event listener to the village filter input
        villageFilterInput.addEventListener('input', filterVillages);

        userForm.addEventListener('submit', function(event) {
            var divisionsCheckboxes = divisionsForm.querySelectorAll('[id^="divisions_"]:checked');
            var villagesCheckboxes = villagesForm.querySelectorAll('[id^="villages_"]:checked');

            // Remove unchecked divisions checkboxes from form data if roles 1, 2, and 3 are not checked
            if (!areSpecificCheckboxesChecked(['roles_3'])) {
                divisionsCheckboxes.forEach(function(checkbox) {
                    checkbox.disabled = true;
                    checkbox.removeAttribute('name');
                });
            }

            // Remove unchecked villages checkboxes from form data if roles 1, 2, and 4 are not checked
            if (!areSpecificCheckboxesChecked(['roles_4'])) {
                villagesCheckboxes.forEach(function(checkbox) {
                    checkbox.disabled = true;
                    checkbox.removeAttribute('name');
                });
            }
        });

        toggleForms();
    </script>
@endsection

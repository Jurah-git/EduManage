@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h2 class="mb-1">
                    <i class="bi bi-shield-lock"></i>
                    Permissions du rôle : {{ $role->name }}
                </h2>
                <p class="text-muted mb-0">
                    Configurez les autorisations de chaque module.
                </p>
            </div>

            <a href="{{ route('config.roles.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Retour aux rôles
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Une erreur est survenue :</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i>
            Cochez les autorisations nécessaires, puis cliquez sur
            <strong>Enregistrer les permissions</strong>.
        </div>

        @php
            $permissionsSelectionnees = old('permissions', $selectedPermissions);
        @endphp

        <form action="{{ route('config.roles.permissions.update', $role) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    @foreach ($modules as $moduleKey => $moduleLabel)
                        @php
                            $actionsDuModule = $permissionsParModule[$moduleKey] ?? [];
                        @endphp

                        @if (count($actionsDuModule))
                            <div class="module-permission mb-4">

                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-grid-fill text-primary"></i>
                                    <h5 class="mb-0">{{ $moduleLabel }}</h5>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle mb-0 permission-table">
                                        <thead>
                                            <tr>
                                                <th style="min-width: 180px;" class="bg-light">
                                                    Module
                                                </th>

                                                @foreach ($actionsDuModule as $actionKey => $actionLabel)
                                                    <th class="text-center bg-light">
                                                        {{ $actionLabel }}
                                                    </th>
                                                @endforeach
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <th class="bg-light">
                                                    {{ $moduleLabel }}
                                                </th>

                                                @foreach ($actionsDuModule as $actionKey => $actionLabel)
                                                    @php
                                                        $permissionName = $moduleKey . '.' . $actionKey;
                                                        $permissionExiste = $permissions->contains(
                                                            'name',
                                                            $permissionName,
                                                        );
                                                        $estCochee = in_array(
                                                            $permissionName,
                                                            $permissionsSelectionnees,
                                                            true,
                                                        );
                                                    @endphp

                                                    <td class="text-center permission-cell">
                                                        @if ($permissionExiste)
                                                            <label
                                                                class="permission-toggle {{ $estCochee ? 'active' : '' }}">
                                                                <input type="checkbox"
                                                                    class="form-check-input permission-checkbox"
                                                                    name="permissions[]" value="{{ $permissionName }}"
                                                                    aria-label="{{ $moduleLabel }} - {{ $actionLabel }}"
                                                                    {{ $estCochee ? 'checked' : '' }}>

                                                                <span class="permission-status">
                                                                    {{ $estCochee ? 'Autorisé' : 'Refusé' }}
                                                                </span>
                                                            </label>
                                                        @else
                                                            <span class="text-warning small">
                                                                Permission absente
                                                            </span>
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        @endif
                    @endforeach

                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 mt-4">

                <button type="button" id="selectAllPermissions" class="btn btn-outline-primary">
                    <i class="bi bi-check2-square"></i> Tout cocher
                </button>

                <button type="button" id="clearAllPermissions" class="btn btn-outline-secondary">
                    <i class="bi bi-square"></i> Tout décocher
                </button>

                <button type="submit" class="btn btn-primary ms-auto">
                    <i class="bi bi-save"></i> Enregistrer les permissions
                </button>

            </div>
        </form>
    </div>

    <style>
        .permission-table th,
        .permission-table td {
            vertical-align: middle;
            white-space: nowrap;
        }

        .permission-table {
            border-color: #dee2e6;
        }

        .permission-cell {
            min-width: 130px;
            background: #fff;
        }

        .permission-toggle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 7px 10px;
            border-radius: 7px;
            background: #f8d7da;
            color: #842029;
            cursor: pointer;
            min-width: 105px;
            transition: .2s ease;
        }

        .permission-toggle.active {
            background: #d1e7dd;
            color: #0f5132;
        }

        .permission-toggle .form-check-input {
            margin: 0;
            cursor: pointer;
        }

        .permission-status {
            font-size: 12px;
            font-weight: 600;
        }

        .module-permission {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 15px;
            background: #fff;
        }

        .module-permission:last-child {
            margin-bottom: 0 !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const checkboxes = document.querySelectorAll('.permission-checkbox');

            function actualiserEtat(checkbox) {
                const label = checkbox.closest('.permission-toggle');
                const status = label.querySelector('.permission-status');

                if (checkbox.checked) {
                    label.classList.add('active');
                    status.textContent = 'Autorisé';
                } else {
                    label.classList.remove('active');
                    status.textContent = 'Refusé';
                }
            }

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    actualiserEtat(checkbox);
                });

                actualiserEtat(checkbox);
            });

            document.getElementById('selectAllPermissions').addEventListener('click', function() {
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = true;
                    actualiserEtat(checkbox);
                });
            });

            document.getElementById('clearAllPermissions').addEventListener('click', function() {
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                    actualiserEtat(checkbox);
                });
            });

        });
    </script>
@endsection

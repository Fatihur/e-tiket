@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Manajemen User</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">User</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Tambah User
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role == 'admin')
                                    <span class="badge bg-danger">Admin</span>
                                @elseif($user->role == 'petugas')
                                    <span class="badge bg-info">Petugas</span>
                                @elseif($user->role == 'bendahara')
                                    <span class="badge bg-warning">Bendahara</span>
                                @else
                                    <span class="badge bg-success">Owner</span>
                                @endif
                            </td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>{{ $user->last_login ? $user->last_login->format('d/m/Y H:i') : '-' }}</td>
                            <td>
                                <div class="btn-group">
                                    @if($user->is_active)
                                        <form action="{{ route('admin.users.deactivate', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Nonaktifkan user ini?')">
                                                <i class="ti ti-ban"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.users.activate', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Aktifkan user ini?')">
                                                <i class="ti ti-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data user</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


@extends('admin.layouts.master')

@section('title', 'Daftar User')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> User</h4>

        <div class="card mb-4">
            {{-- Pesan sukses --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                <h5 class="mb-0">Daftar User</h5>

                {{-- 🔍 Form Search & Filter --}}
                <form action="{{ route('verif.index') }}" method="GET"
                    class="d-flex flex-wrap align-items-center gap-2 justify-content-end w-100 w-md-auto mt-2 mt-md-0">

                    {{-- Filter Divisi --}}
                    <select name="divisi" class="form-select form-select-sm" style="width: 150px;">
                        <option value="">Semua Divisi</option>
                        @foreach (['Website', 'Mobile', 'IoT', 'SistemCerdas', 'UI/UX', 'None'] as $div)
                            <option value="{{ $div }}" {{ request('divisi') == $div ? 'selected' : '' }}>
                                {{ $div }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Filter Role --}}
                    @if (Auth::user()->role == 'Admin')
                        <select name="role" class="form-select form-select-sm" style="width: 150px;">
                            <option value="">Semua Role</option>
                            @foreach (['None', 'Anggota', 'Pengurus', 'Admin'] as $role)
                                <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                                    {{ $role }}
                                </option>
                            @endforeach
                        </select>
                    @endif

                    {{-- Input Search --}}
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Cari nama atau email..." value="{{ request('search') }}" style="min-width: 200px;">

                    {{-- Tombol Cari --}}
                    <button type="submit" class="btn btn-sm btn-secondary">
                        <i class="bx bx-search"></i>
                    </button>

                    {{-- Tombol Reset --}}
                    @if (request()->hasAny(['search', 'divisi', 'role']))
                        <a href="{{ route('verif.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bx bx-reset"></i>
                        </a>
                    @endif

                </form>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Email</th>
                            <th>Angkatan</th>
                            <th>Divisi</th>
                            <th>Role</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->profile->nim ?? '' }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->profile->angkatan ?? '' }}</td>
                                <td>
                                    <span class="badge bg-label-info">{{ $user->profile->divisi ?? 'None' }}</span>
                                </td>
                                <td>
                                    @if ($user->role === 'Admin')
                                        <span class="badge bg-danger">Admin</span>
                                    @elseif ($user->role === 'Pengurus')
                                        <span class="badge bg-warning text-dark">Pengurus</span>
                                    @elseif ($user->role === 'Anggota')
                                        <span class="badge bg-success">Anggota</span>
                                    @else
                                        <span class="badge bg-secondary">None</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->profile && $user->profile->image)
                                        <img src="{{ asset($user->profile->image) }}" alt="Foto"
                                            style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                    @else
                                        <small class="text-muted">-</small>
                                    @endif
                                </td>
                                <td>
                                    {{-- Jika user login adalah Pengurus --}}
                                    @if (Auth::user()->role == 'Pengurus')
                                        @if ($user->role == 'None')
                                            {{-- ✅ CEK APAKAH DATA LENGKAP --}}
                                            @php
                                                $isComplete =
                                                    $user->name &&
                                                    $user->email &&
                                                    optional($user->profile)->nim &&
                                                    optional($user->profile)->angkatan &&
                                                    optional($user->profile)->divisi &&
                                                    optional($user->profile)->image;
                                            @endphp

                                            <form action="{{ route('verif.user', $user->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success text-white">Aktifkan</button>

                                                {{-- ❓ Tanda Tanya jika data lengkap --}}
                                                @if ($isComplete)
                                                    <span class="ms-2 text-primary fw-bold" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Data lengkap, aktifkan?">
                                                        ?
                                                    </span>
                                                @endif
                                            </form>
                                        @elseif ($user->role == 'Anggota')
                                            <form action="{{ route('unverif.user', $user->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-danger text-white">Nonaktifkan</button>
                                            </form>
                                        @endif
                                    @endif

                                    {{-- Jika user login adalah Admin --}}
                                    @if (Auth::user()->role == 'Admin')
                                        @if ($user->role == 'None')
                                            {{-- ✅ CEK APAKAH DATA LENGKAP --}}
                                            @php
                                                $isComplete =
                                                    $user->name &&
                                                    $user->email &&
                                                    optional($user->profile)->nim &&
                                                    optional($user->profile)->angkatan &&
                                                    optional($user->profile)->divisi &&
                                                    optional($user->profile)->image;
                                            @endphp

                                            <form action="{{ route('verif.user', $user->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success text-white">Aktifkan</button>

                                                {{-- ❓ Tanda Tanya jika data lengkap --}}
                                                @if ($isComplete)
                                                    <span class="ms-2 text-primary fw-bold" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Data lengkap, aktifkan?">
                                                        ?
                                                    </span>
                                                @endif
                                            </form>
                                        @elseif ($user->role == 'Anggota')
                                            <form action="{{ route('unverif.user', $user->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-danger text-white">Nonaktifkan</button>
                                            </form>

                                            <form action="{{ route('verif.pengurus', $user->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-warning text-white">Jadikan
                                                    (Pengurus)</button>
                                            </form>
                                        @elseif ($user->role == 'Pengurus')
                                            <form action="{{ route('unverif.user', $user->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-secondary text-white">Turunkan (ke
                                                    None)</button>
                                            </form>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Belum ada user yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if (method_exists($users, 'links'))
                <div class="card-footer d-flex justify-content-center">
                    {!! $users->links('pagination::bootstrap-5') !!}
                </div>
            @endif

        </div>
    </div>
@endsection

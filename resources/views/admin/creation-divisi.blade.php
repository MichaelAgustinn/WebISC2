@extends('admin.layouts.master')

@section('title', 'Daftar Creation')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>

        <div class="row">
            <div class="col-md-12">
                @include('admin.layouts.nav-profile')
                {{-- <div class="container-xxl flex-grow-1 container-p-y"> --}}
                <div class="card mb-4">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <h5 class="mb-0">Daftar Creation</h5>

                        {{-- 🔍 Form Search & Filter --}}
                        <form action="{{ route('creation.index') }}" method="GET"
                            class="d-flex flex-wrap align-items-center gap-2 justify-content-end w-100 w-md-auto mt-2 mt-md-0">

                            {{-- Filter Divisi --}}
                            <input type="hidden" name="divisi" value="{{ $divisi }}">

                            {{-- Filter Status --}}
                            <select name="status" class="form-select form-select-sm" style="width: 140px;">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="approve" {{ request('status') == 'approve' ? 'selected' : '' }}>Approve
                                </option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                                </option>
                            </select>

                            {{-- Input Search --}}
                            <input type="text" name="search" class="form-control form-control-sm"
                                placeholder="Cari karya atau divisi..." value="{{ request('search') }}"
                                style="min-width: 180px;">

                            {{-- Tombol --}}
                            <button type="submit" class="btn btn-sm btn-secondary">
                                <i class="bx bx-search"></i>
                            </button>

                            {{-- Tombol reset filter --}}
                            @if (request()->hasAny(['search', 'divisi', 'status']))
                                <a href="{{ route('creation.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bx bx-reset"></i>
                                </a>
                            @endif

                            {{-- Tombol tambah karya (untuk user non-admin) --}}
                            @if (Auth::user()->role != 'Admin')
                                <a href="{{ route('creation.create') }}" class="btn btn-primary btn-sm">
                                    <i class="bx bx-plus"></i> Tambah Karya
                                </a>
                            @endif
                        </form>
                    </div>


                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Divisi</th>
                                    <th>Thumbnail</th>
                                    <th>Status</th>
                                    <th>Dibuat oleh</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($creations as $creation)
                                    <tr>
                                        <td>
                                            <a href="{{ route('creation.edit', $creation->slug) }}" class="fw-semibold">
                                                {{ Str::limit($creation->title, 40) }}
                                            </a>
                                        </td>
                                        <td><span class="badge bg-label-info">{{ $creation->divisi }}</span></td>
                                        <td>
                                            @if ($creation->first_image)
                                                <img src="{{ asset($creation->first_image) }}" alt="Thumbnail"
                                                    style="max-width: 80px; border-radius: 8px;">
                                            @else
                                                <small class="text-muted">Tidak ada</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($creation->status === 'approve')
                                                <span class="badge bg-success">Approve</span>
                                            @elseif ($creation->status === 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ optional($creation->creator->first())->name ?? '-' }}</td>
                                        <td>
                                            @if (Auth::user()->role !== 'Admin' && Auth::user()->role !== 'Pengurus')
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('creation.edit', $creation->slug) }}">
                                                            <i class="bx bx-edit-alt me-2"></i> Edit
                                                        </a>
                                                        <form action="{{ route('creation.delete', $creation->id) }}"
                                                            onsubmit="return confirm('Yakin ingin menghapus karya ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="dropdown-item text-danger" type="submit">
                                                                <i class="bx bx-trash me-2"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    @if ($creation->status == 'pending' || $creation->status == 'rejected')
                                                        <button type="button" class="btn btn-success">
                                                            <a style="color: white"
                                                                href="{{ route('creation.approve', $creation->id) }}">Validasi</a>
                                                        </button>
                                                    @elseif ($creation->status == 'approve')
                                                        <button type="button" class="btn btn-danger">
                                                            <a style="color: white"
                                                                href="{{ route('creation.rejected', $creation->id) }}">Tolak</a></button>
                                                    @endif
                                            @endif
                    </div>
                    </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Belum ada creation yang dibuat.
                        </td>
                    </tr>
                    @endforelse
                    </tbody>
                    </table>
                </div>

                {{-- Pagination (opsional) --}}
                @if (method_exists($creations, 'links'))
                    <div class="card-footer">
                        {{ $creations->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    {{-- </div> --}}

@endsection

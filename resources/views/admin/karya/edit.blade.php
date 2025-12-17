@extends('admin.layouts.master')
@section('title', 'Edit Karya')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Form Input /</span> Edit Karya</h4>

        <div class="row">

            <form action="{{ route('karya.update', $karya->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="col-md-12">
                    <div class="card mb-4">

                        <h5 class="card-header">Form Edit Karya</h5>

                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label">Judul Karya</label>
                                <input type="text" name="judul" class="form-control" value="{{ $karya->judul }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="4">{{ $karya->deskripsi }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Gambar</label><br>

                                @if ($karya->image)
                                    <img src="{{ asset('storage/' . $karya->image) }}" width="120" class="mb-2 rounded">
                                    <br>
                                @endif

                                <input type="file" name="image" class="form-control">
                            </div>

                            <button class="btn btn-primary">Update</button>

                        </div>

                    </div>
                </div>

            </form>

        </div>
    </div>
@endsection

@extends('admin.layouts.master')

@section('title', 'Form Document')

@extends('admin.layouts.master')

@section('title', 'Form Document')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Form Input /</span> Document</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <h5 class="card-header">Form Document</h5>

                    <div class="card-body">
                        <form
                            action="{{ isset($information) ? route('information.update', $information->id) : route('information.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Masukkan nama..." value="{{ $information->name ?? '' }}">
                            </div>

                            <div class="mb-3">
                                <label for="file" class="form-label">File</label>
                                @if (isset($information))
                                    <input type="hidden" name="old_file" value="{{ $information->file }}">
                                @endif
                                <input class="form-control" name="file" type="file" id="file">
                                @if (isset($information) && $information->file)
                                    <a href="{{ asset($information->file) }}" target="_blank">Lihat File Lama</a>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ isset($information) ? 'Update' : 'Submit' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

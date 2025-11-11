@extends('admin.layouts.master')

@section('title', 'Form logo')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Form Input /</span> Logo</h4>

        <div class="row">
            <form action="{{ route('logo.landing.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                    <div class="card mb-4">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <h5 class="card-header">Form Logo</h5>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Nama Divisi/Tim</label>
                                <input type="text" name="title" class="form-control" id="title"
                                    placeholder="Text Here.." value="{{ $logo->title ?? '' }}" />
                            </div>

                            <div class="mb-3">
                                <label for="formFile" class="form-label">Foto</label>
                                @if (isset($logo) && $logo->image)
                                    <!-- Hidden input untuk menyimpan file lama -->
                                    <input type="hidden" name="old_image" value="{{ $logo->image }}">
                                    <input type="hidden" name="id" value="{{ $logo->id }}">
                                @endif

                                <input class="form-control" name="image" type="file" id="formFile" />
                            </div>

                            <div class="mb-3">
                                <img id="previewImage" src="{{ isset($logo->image) ? asset($logo->image) : '' }}"
                                    alt="Preview Logo"
                                    style="max-height: 150px; display: {{ isset($logo->image) ? 'block' : 'none' }};">
                            </div>

                            <script>
                                const formFile = document.getElementById('formFile');
                                const previewImage = document.getElementById('previewImage');

                                formFile.addEventListener('change', function(event) {
                                    const file = event.target.files[0]; // ambil file pertama
                                    if (file) {
                                        const reader = new FileReader(); // buat reader untuk membaca file
                                        reader.onload = function(e) {
                                            previewImage.src = e.target.result; // update src preview
                                            previewImage.style.display = 'block'; // pastikan tampil
                                        }
                                        reader.readAsDataURL(file); // baca file sebagai data URL
                                    }
                                });
                            </script>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('admin.layouts.master')

@section('title', 'Form Pengurus')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Form Input /</span> Pengurus</h4>

        <div class="row">
            <form action="{{ route('pengurus.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                    <div class="card mb-4">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <h5 class="card-header">Form Pengurus</h5>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Pengurus</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Text Here.." value="{{ $pengurus->name ?? '' }}" />
                            </div>

                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input type="text" name="jabatan" class="form-control" id="jabatan"
                                    placeholder="Text Here.." value="{{ $pengurus->jabatan ?? '' }}" />
                            </div>

                            <div class="mb-3">
                                <label for="formFile" class="form-label">Foto</label>
                                @if (isset($pengurus) && $pengurus->image)
                                    <input type="hidden" name="old_image" value="{{ $pengurus->image }}">
                                    <input type="hidden" name="id" value="{{ $pengurus->id }}">
                                @endif

                                <input class="form-control" name="image" type="file" id="formFile" />
                            </div>

                            <div class="mb-3">
                                <img id="previewImage" src="{{ isset($pengurus->image) ? asset($pengurus->image) : '' }}"
                                    alt="Preview Foto"
                                    style="max-height: 150px; display: {{ isset($pengurus->image) ? 'block' : 'none' }};">
                            </div>

                            <script>
                                const formFile = document.getElementById('formFile');
                                const previewImage = document.getElementById('previewImage');

                                formFile.addEventListener('change', function(event) {
                                    const file = event.target.files[0];
                                    if (file) {
                                        const reader = new FileReader();
                                        reader.onload = function(e) {
                                            previewImage.src = e.target.result;
                                            previewImage.style.display = 'block';
                                        }
                                        reader.readAsDataURL(file);
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

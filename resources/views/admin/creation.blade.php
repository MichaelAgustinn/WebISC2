@extends('admin.layouts.master')

@section('title', 'Form Karya')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row gy-6">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('creation.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if (isset($creation))
                            <input type="hidden" name="id" value="{{ $creation->id }}">
                        @endif
                        <div class="card-body">
                            <div class="mb-3">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                <label for="title" class="form-label">Judul</label>
                                <input type="text" name="title" class="form-control" id="title"
                                    placeholder="Text Here.." value="{{ $creation->title ?? '' }}" />
                            </div>
                            <div class="mb-3">
                                <label for="content">CONTENT</label>
                                <textarea name="content" id="summernote" class="form-control">{{ $creation->content ?? '' }}</textarea>
                                <script>
                                    $('#summernote').summernote({
                                        placeholder: 'Hello stand alone ui',
                                        tabsize: 2,
                                        height: 420,
                                        toolbar: [
                                            ['style', ['style']],
                                            ['font', ['bold', 'underline', 'clear']],
                                            ['color', ['color']],
                                            ['para', ['ul', 'ol', 'paragraph']],
                                            ['table', ['table']],
                                            ['insert', ['link', 'picture', ]],
                                            ['view', ['codeview', 'help']]
                                        ]
                                    });
                                </script>
                            </div>

                            <div class="mb-3">
                                <label for="divisi" class="form-label">Divisi</label>
                                <select name="divisi" id="divisi" class="form-control" required>
                                    <option value="" disabled {{ !isset($creation) ? 'selected' : '' }}>-- Pilih
                                        Divisi --</option>
                                    <option value="Mobile"
                                        {{ isset($creation) && $creation->divisi === 'Mobile' ? 'selected' : '' }}>Mobile
                                    </option>
                                    <option value="Website"
                                        {{ isset($creation) && $creation->divisi === 'Website' ? 'selected' : '' }}>Website
                                    </option>
                                    <option value="IoT"
                                        {{ isset($creation) && $creation->divisi === 'IoT' ? 'selected' : '' }}>IoT</option>
                                    <option value="UI/UX"
                                        {{ isset($creation) && $creation->divisi === 'UI/UX' ? 'selected' : '' }}>UI/UX
                                    </option>
                                    <option value="SistemCerdas"
                                        {{ isset($creation) && $creation->divisi === 'SistemCerdas' ? 'selected' : '' }}>
                                        Sistem Cerdas</option>
                                </select>
                                <small class="text-muted">
                                    Pilih salah satu divisi yang sesuai dengan creation ini.
                                </small>
                            </div>

                            <div class="mb-3">
                                <label for="user_ids" class="form-label">Anggota</label>
                                <select name="user_ids[]" id="user_ids" class="form-control" multiple="multiple">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            @if (isset($creation) && $creation->users->contains('id', $user->id)) selected @endif>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">
                                    Pilih satu atau beberapa anggota dari daftar.
                                </small>
                            </div>

                            <button type="submit" class="btn  btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#user_ids').select2({
                tags: true,
                tokenSeparators: [',', ' '],
                placeholder: 'Pilih Anggota',
                width: '100%'
            });
        });
    </script>
@endsection

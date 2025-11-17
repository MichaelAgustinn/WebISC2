@extends('admin.layouts.master')

@section('title', 'Form Blog')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row gy-6">
            <div class="col-12">
                <div class="card">
                    <form action="{{ $blog ?? '' ? route('blog.update', $blog->id) : route('blog.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
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
                                    placeholder="Text Here.." value="{{ $blog->title ?? '' }}" />
                            </div>
                            <div class="mb-3">
                                <label for="content">CONTENT</label>
                                <textarea name="content" id="summernote" class="form-control">{{ $blog->content ?? '' }}</textarea>
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
                                <label for="tags" class="form-label">Tags</label>
                                <select name="tags[]" id="tags" class="form-control" multiple="multiple">
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag->name }}"
                                            @if (isset($blog) && $blog->tags->contains('name', $tag->name)) selected @endif>
                                            {{ $tag->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">
                                    Ketik untuk menambah tag baru, atau pilih dari daftar yang sudah ada.
                                </small>

                            </div>
                            @if (isset($blog))
                                <input type="hidden" name="id" value="{{ $blog->id }}">
                                <input type="hidden" name="old_image" value="{{ $blog->image }}">
                            @endif

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
            $('#tags').select2({
                tags: true,
                tokenSeparators: [',', ' '],
                placeholder: 'Pilih atau tambah tag',
                width: '100%'
            });
        });
    </script>
@endsection

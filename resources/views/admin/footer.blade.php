@extends('admin.layouts.master')

@section('title', 'Form Footer - Informatics Study Club')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Form Input /</span> Footer</h4>

        <div class="row">
            <!-- Form controls -->
            <form action="{{ $footer ?? '' ? route('footer.landing.update', $footer->id) : route('footer.landing.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                    <div class="card mb-4">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <h5 class="card-header">Form footer</h5>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Nomor Telepon</label>
                                <input type="text" name="nomor_telepon" class="form-control" id="title"
                                    placeholder="Text Here.." value="{{ $footer->nomor_telepon ?? '' }}" />
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="description"
                                    placeholder="Text Here.." value="{{ $footer->email ?? '' }}" />
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Link Youtube</label>
                                <input type="text" name="link_facebook" class="form-control" id="title"
                                    placeholder="Text Here.." value="{{ $footer->link_facebook ?? '' }}" />
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Link Instagram</label>
                                <input type="text" name="link_instagram" class="form-control" id="title"
                                    placeholder="Text Here.." value="{{ $footer->link_instagram ?? '' }}" />
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Link Discord</label>
                                <input type="text" name="link_tiktok" class="form-control" id="title"
                                    placeholder="Text Here.." value="{{ $footer->link_tiktok ?? '' }}" />
                            </div>
                            <button type="submit" class="btn  btn-primary">Submit</button>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

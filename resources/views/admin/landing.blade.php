@extends('admin.layouts.master')

@section('title', 'Form - Landing Page')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Form Input /</span> Landing Page</h4>

        <div class="row">
            <!-- Form controls -->
            <form action="{{ route('form.landing.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                    <div class="card mb-4">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <h5 class="card-header">Form Landing Page</h5>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="exampleFormControlSelect1" class="form-label">Section</label>
                                <select class="form-select" id="exampleFormControlSelect1" name="section">
                                    <option value="" selected disabled hidden>Pilih Section</option>
                                    <option value="hero">Hero</option>
                                    <option value="about">About</option>
                                    <option value="visi">Visi</option>
                                    <option value="misi">Misi</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" id="title"
                                    placeholder="Text Here.." />
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Description</label>
                                <input type="text" name="description" class="form-control" id="description"
                                    placeholder="Text Here.." />
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Image</label>
                                <input class="form-control" name="image" type="file" id="formFile" />
                            </div>
                            <button type="submit" class="btn  btn-primary">Submit</button>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

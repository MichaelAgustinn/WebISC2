@extends('admin.layouts.master')

@section('title', 'Form FAQ')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Form Input /</span> FAQ</h4>

        <div class="row">
            <!-- Form controls -->
            <form action="{{ $faq ?? '' ? route('faq.landing.update', $faq->id) : route('faq.landing.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                {{-- @method('POST') --}}
                <div class="col-md-12">
                    <div class="card mb-4">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <h5 class="card-header">Form FAQ</h5>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Pertanyaan</label>
                                <input type="text" name="question" class="form-control" id="title"
                                    placeholder="Text Here.." value="{{ $faq->question ?? '' }}" />
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Jawaban</label>
                                <input type="text" name="answered" class="form-control" id="description"
                                    placeholder="Text Here.." value="{{ $faq->answered ?? '' }}" />
                            </div>
                            <button type="submit" class="btn  btn-primary">Submit</button>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

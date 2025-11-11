@extends('admin.layouts.master')

@section('title', 'Form Testimonial')

@section('content')
    <!-- CSS Choices.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

    <!-- JS Choices.js -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>


    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Form Input /</span> Testimonial</h4>

        <div class="row">
            <!-- Form controls -->
            <form
                action="{{ $testimonial ?? '' ? route('testimonial.update', $testimonial->id) : route('testimonial.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                {{-- @method('POST') --}}
                <div class="col-md-12">
                    <div class="card mb-4">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <h5 class="card-header">Form Testimonial</h5>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Rating</label>
                                <input type="number" class="form-control" id="title" name="rating" placeholder="1-5"
                                    value="{{ $testimonial->rating ?? '' }}" step="1" />

                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Pesan</label>
                                <textarea type="text" name="message" class="form-control" id="description" placeholder="Text Here..">{{ $testimonial->message ?? '' }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="userSelect" class="form-label">Testimonial</label>
                                <select id="userSelect" name="user_id" placeholder="Pilih user...">
                                    <option value="">Select user</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ isset($testimonial->user_id) && $testimonial->user_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn  btn-primary">Submit</button>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userSelect = document.getElementById('userSelect');
            const choices = new Choices(userSelect, {
                searchEnabled: true, // memungkinkan pencarian
                itemSelectText: '', // hapus teks default
                shouldSort: false // biarkan urutan sesuai html
            });
        });
    </script>


@endsection

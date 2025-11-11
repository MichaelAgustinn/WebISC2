@extends('admin.layouts.master')

@section('title', 'Form Footer - Informatics Study Club')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <h5 class="card-header">Table Basic</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nomor Telepon</th>
                            <th>Email</th>
                            <th>Link Facebook</th>
                            <th>Link Instagram</th>
                            <th>Link Tiktok</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($footers as $footer)
                            <tr>
                                <td>{{ $footer->id }}</td>
                                <td>{{ $footer->nomor_telepon }}</td>
                                <td>{{ $footer->email }}</td>
                                <td>{{ $footer->link_facebook }}</td>
                                <td>{{ $footer->link_instagram }}</td>
                                <td>{{ $footer->link_tiktok }}</td>
                                <td>

                                    <a class="dropdown-item" href="{{ route('footer.landing.show', $footer->id) }}"><i
                                            class="bx bx-edit-alt me-2"></i>
                                        Edit</a>
            </div>
            </td>
            </tr>
            @endforeach
            </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection

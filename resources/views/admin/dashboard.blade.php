@extends('admin.layouts.master')

@section('title', 'Dashboard - Informatics Study Club')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Welcome Back {{ Auth::user()->name }}! 🎉</h5>
                                <p class="mb-4">
                                    {{ $quote }}
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{ asset('admin') }}/assets/img/illustrations/man-with-laptop-light.png"
                                    height="140" alt="View Badge User"
                                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ! stats of all --}}
            <div class="col-12 col-md-12 col-lg-12 order-3 order-md-2">
                <div class="row">
                    <div class="col-6 mb-4 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('admin') }}/assets/img/icons/unicons/chart-success.png"
                                            alt="chart success" class="rounded" />
                                    </div>
                                </div>
                                @if (Auth::user()->role == 'Admin')
                                    <span class="fw-semibold d-block mb-1">Semua Karya (aktif)</span>
                                    <h3 class="card-title mb-2">{{ $creationActiveCount }}</h3>
                                @else
                                    <span class="fw-semibold d-block mb-1">Jumlah Karya</span>
                                    <h3 class="card-title mb-2">{{ $myCreation }}</h3>
                                @endif
                                {{-- <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +72.80%</small> --}}
                            </div>
                        </div>
                    </div>

                    <div class="col-6 mb-4 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('admin') }}/assets/img/icons/unicons/wallet-info.png"
                                            alt="Credit Card" class="rounded" />
                                    </div>
                                </div>
                                @if (Auth::user()->role == 'Admin')
                                    <span class="fw-semibold d-block mb-1">Semua Karya Anggota</span>
                                    <h3 class="card-title mb-2">{{ $creationCount }}</h3>
                                @else
                                    <span>Jumlah Like</span>
                                    <h3 class="card-title text-nowrap mb-1">{{ $totalLikes }}</h3>
                                @endif
                                {{-- <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.42%</small> --}}
                            </div>
                        </div>
                    </div>

                    @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Pengurus')
                        <div class="col-6 mb-4 col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <img src="{{ asset('admin') }}/assets/img/icons/unicons/paypal.png"
                                                alt="Credit Card" class="rounded" />
                                        </div>

                                    </div>
                                    <span class="d-block mb-1">Jumlah Anggota Aktif</span>
                                    <h3 class="card-title text-nowrap mb-2">{{ $userActiveCount }}</h3>
                                    {{-- <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i>
                                        -14.82%</small> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-4 col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <img src="{{ asset('admin') }}/assets/img/icons/unicons/cc-primary.png"
                                                alt="Credit Card" class="rounded" />
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                                <a class="dropdown-item" href="{{ route('verif.index') }}">View More</a>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block mb-1">Akun Terdaftar</span>
                                    <h3 class="card-title mb-2">{{ $regist ?? '' }}</h3>
                                    {{-- <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                                        +28.14%</small> --}}
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-6 mb-4 col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <img src="{{ asset('admin') }}/assets/img/icons/unicons/cc-primary.png"
                                                alt="Credit Card" class="rounded" />
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn p-0" type="button" id="cardOpt1"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block mb-1">Transactions</span>
                                    <h3 class="card-title mb-2">$14,857</h3>
                                    <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                                        +28.14%</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-4 col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <img src="{{ asset('admin') }}/assets/img/icons/unicons/cc-primary.png"
                                                alt="Credit Card" class="rounded" />
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn p-0" type="button" id="cardOpt1"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block mb-1">Transactions</span>
                                    <h3 class="card-title mb-2">$14,857</h3>
                                    <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                                        +28.14%</small>
                                </div>
                            </div>
                        </div> --}}
                    @endif
                </div>
            </div>
            {{-- ! stats of all end --}}

        </div>
    </div>

@endsection

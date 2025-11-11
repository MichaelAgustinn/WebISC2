@extends('admin.layouts.master')

@section('title', 'Account Settings')

@section('content')
    {{-- @dd($user) --}}
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>

        <div class="row">
            <div class="col-md-12">
                @include('admin.layouts.nav-profile')

                <div class="card mb-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <h5 class="card-header">Profile Details</h5>
                    <!-- Account -->
                    <form id="formAccountSettings" action="{{ route('profile.update', Auth::user()->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="{{ !empty($user->profile->image) ? asset($user->profile->image) : asset('images/default-profile.jpg') }}"
                                    alt="user-avatar" class="d-block rounded" height="100" width="100"
                                    id="uploadedAvatar" />

                                <div class="button-wrapper">
                                    <label for="photo" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload new photo</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input type="file" id="photo" name="image" class="account-file-input"
                                            hidden accept="image/png, image/jpeg" />
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- ? pop up untuk crop foto --}}
                        <div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="cropModalLabel">Crop Photo</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div>
                                            <img id="imageToCrop" style="max-width: 100%;" />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" id="cropAndSave" class="btn btn-primary">Crop &
                                            Upload</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- ? pop up untuk crop foto end --}}


                        <hr class="my-0" />
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Nama</label>
                                    <input class="form-control" type="text" id="name" name="name"
                                        placeholder="Name here..." autofocus value="{{ old('name', $user->name) }}"
                                        {{ $user->role != 'None' ? 'readonly' : '' }}>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input class="form-control" type="email" id="email" name="email"
                                        placeholder="Email here" value="{{ old('email', $user->email) }}"
                                        {{ $user->role != 'None' ? 'readonly' : '' }}>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="nim" class="form-label">NIM</label>
                                    <input type="text" class="form-control" id="nim" name="nim"
                                        placeholder="D02..." value="{{ old('nim', $user->profile->nim ?? '') }}"
                                        {{ $user->role != 'None' ? 'readonly' : '' }}>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="divisi">Divisi</label>
                                    <select id="divisi" name="divisi" class="select2 form-select"
                                        {{ $user->role != 'None' ? 'disabled' : '' }}>
                                        @foreach (['None', 'Mobile', 'Website', 'SistemCerdas', 'IoT', 'UI/UX'] as $div)
                                            <option value="{{ $div }}"
                                                {{ ($user->profile?->divisi ?? '') === $div ? 'selected' : '' }}>
                                                {{ $div }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @if ($user->role != 'None')
                                        <input type="hidden" name="divisi" value="{{ $user->profile->divisi ?? '' }}">
                                    @endif
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="angkatan">Angkatan</label>
                                    <input type="number" id="angkatan" name="angkatan" class="form-control"
                                        placeholder="2023" value="{{ old('angkatan', $user->profile->angkatan ?? '') }}"
                                        {{ $user->role != 'None' ? 'readonly' : '' }}>
                                </div>
                            </div>

                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                            </div>
                    </form>

                </div>

                {{-- ! cdn untuk cropper jangan di pindah --}}
                <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


                {{-- ! script preview di img --}}
                <script>
                    document.getElementById('photo').addEventListener('change', function(event) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                document.getElementById('uploadedAvatar').src = e.target.result;
                            }
                            reader.readAsDataURL(file);
                        }
                    });

                    // Tombol reset foto (jika ada)
                    document.querySelector('.account-image-reset').addEventListener('click', function() {
                        const defaultAvatar =
                            "{{ !empty($user->profile->photo) ? asset('storage/profile/' . $user->profile->photo) : asset('admin/assets/img/avatars/1.png') }}";
                        document.getElementById('uploadedAvatar').src = defaultAvatar;
                        document.getElementById('photo').value = ''; // reset input file
                    });
                </script>


                {{-- ! script cropper --}}
                <script>
                    let cropper;
                    const photoInput = document.getElementById('photo');
                    const uploadedAvatar = document.getElementById('uploadedAvatar');
                    const cropModal = new bootstrap.Modal(document.getElementById('cropModal'));

                    photoInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(event) {
                                const image = document.getElementById('imageToCrop');
                                image.src = event.target.result;

                                // buka modal cropper
                                cropModal.show();

                                // tunggu sampai modal terbuka sebelum inisialisasi cropper
                                document.getElementById('cropModal').addEventListener('shown.bs.modal', function() {
                                    cropper = new Cropper(image, {
                                        aspectRatio: 1, // kotak
                                        viewMode: 1,
                                        autoCropArea: 1
                                    });
                                }, {
                                    once: true
                                });
                            };
                            reader.readAsDataURL(file);
                        }
                    });

                    document.getElementById('cropAndSave').addEventListener('click', function() {
                        const canvas = cropper.getCroppedCanvas({
                            width: 300,
                            height: 300
                        });

                        // tampilkan hasil crop di preview
                        uploadedAvatar.src = canvas.toDataURL();

                        // simpan hasil crop ke input hidden agar bisa dikirim ke backend
                        canvas.toBlob(function(blob) {
                            const file = new File([blob], "cropped.png", {
                                type: "image/png"
                            });

                            // buat DataTransfer supaya input file bisa diganti
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);
                            photoInput.files = dataTransfer.files;
                        });

                        cropModal.hide();
                        cropper.destroy();
                    });
                </script>
            </div>
        </div>
    </div>
    </div>


@endsection

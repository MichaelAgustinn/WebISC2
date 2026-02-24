@extends('landing.master')

@push('styles')
    <style>
        .form-header-bg {
            background: linear-gradient(135deg, var(--primary) 0%, #081226 100%);
            padding: 120px 5% 60px;
            text-align: center;
            color: white;
        }

        .form-fill-container {
            max-width: 800px;
            margin: -40px auto 50px auto;
            position: relative;
            z-index: 10;
            padding: 0 20px;
        }

        .form-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-bottom: 20px;
            border-top: 8px solid var(--accent);
        }

        .question-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
            transition: 0.3s;
        }

        .question-card:focus-within {
            border-left: 6px solid var(--primary);
        }

        .q-label {
            font-weight: 600;
            color: #1e293b;
            font-size: 1.1rem;
            margin-bottom: 15px;
            display: block;
        }

        .req-star {
            color: #ef4444;
            margin-left: 4px;
            font-weight: bold;
        }

        .f-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            outline: none;
            transition: 0.3s;
            font-family: inherit;
        }

        .f-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(15, 32, 75, 0.1);
        }

        .f-file {
            padding: 10px;
            border: 1px dashed #cbd5e1;
            border-radius: 8px;
            width: 100%;
            background: #f8fafc;
        }

        .error-msg {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 5px;
            display: block;
        }
    </style>
@endpush

@section('content')
    <div class="form-header-bg"></div>

    <div class="form-fill-container">

        @if (session('success'))
            <div
                style="background: #dcfce7; border: 1px solid #22c55e; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold;">
                <i class="ri-checkbox-circle-fill"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div
                style="background: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold;">
                <i class="ri-error-warning-fill"></i> {{ session('error') }}
            </div>
        @endif

        @if ($hasSubmitted)
            <div class="form-card text-center" style="padding: 50px 30px;">
                <div style="font-size: 4rem; color: var(--accent); margin-bottom: 10px;">
                    <i class="ri-shield-check-fill"></i>
                </div>
                <h2 style="font-size: 1.8rem; color: var(--primary); margin-bottom: 10px;">Anda Sudah Merespons</h2>
                <p style="color: #64748b; margin-bottom: 30px;">Anda hanya dapat mengisi formulir <b>{{ $form->title }}</b>
                    ini satu kali.</p>

                <a href="{{ route('landing.forms.index') }}"
                    style="display: inline-block; background: var(--primary); color: white; padding: 10px 25px; border-radius: 50px; text-decoration: none; font-weight: bold; transition: 0.3s;">
                    <i class="ri-arrow-left-line"></i> Kembali ke Daftar Formulir
                </a>
            </div>
        @else
            @if ($errors->any())
                <div
                    style="background: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <strong style="display: block; margin-bottom: 5px;"><i class="ri-error-warning-fill"></i> Terdapat
                        kesalahan:</strong>
                    <ul style="margin-left: 20px; font-size: 0.9rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('landing.forms.submit', $form->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-card">
                    @if ($form->cover_image)
                        <img src="{{ asset($form->cover_image) }}"
                            style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 20px;">
                    @endif
                    <h1 style="font-size: 2rem; color: var(--primary); margin-bottom: 10px;">{{ $form->title }}</h1>
                    <p style="color: #64748b; line-height: 1.6;">{{ $form->description }}</p>
                    <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">
                    <p style="font-size: 0.85rem; color: #ef4444;">* Menunjukkan pertanyaan yang wajib diisi</p>
                </div>

                @foreach ($form->fields as $field)
                    <div class="question-card">
                        <label class="q-label">
                            {{ $field->label }}
                            @if ($field->is_required)
                                <span class="req-star">*</span>
                            @endif
                        </label>

                        @if ($field->image)
                            <div style="margin-bottom: 15px;">
                                <img src="{{ asset($field->image) }}" alt="Gambar Soal"
                                    style="max-width: 100%; max-height: 300px; border-radius: 8px; border: 1px solid #eee;">
                            </div>
                        @endif

                        @if ($field->type == 'text')
                            <input type="text" name="answers[{{ $field->id }}]" class="f-input"
                                placeholder="Jawaban Anda" value="{{ old('answers.' . $field->id) }}"
                                {{ $field->is_required ? 'required' : '' }}>
                        @elseif($field->type == 'textarea')
                            <textarea name="answers[{{ $field->id }}]" rows="4" class="f-input" placeholder="Jawaban panjang Anda"
                                {{ $field->is_required ? 'required' : '' }}>{{ old('answers.' . $field->id) }}</textarea>
                        @elseif($field->type == 'number')
                            <input type="number" name="answers[{{ $field->id }}]" class="f-input"
                                placeholder="Jawaban angka" value="{{ old('answers.' . $field->id) }}"
                                {{ $field->is_required ? 'required' : '' }}>
                        @elseif($field->type == 'date')
                            <input type="date" name="answers[{{ $field->id }}]" class="f-input"
                                value="{{ old('answers.' . $field->id) }}" {{ $field->is_required ? 'required' : '' }}>
                        @elseif($field->type == 'file')
                            <input type="file" name="answers[{{ $field->id }}]" class="f-file"
                                {{ $field->is_required ? 'required' : '' }}>
                        @endif

                        @error('answers.' . $field->id)
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach

                <div style="display: flex; justify-content: flex-end; margin-top: 20px;">
                    <button type="submit"
                        style="background: var(--primary); color: var(--accent); padding: 12px 30px; border-radius: 50px; border: none; font-weight: bold; cursor: pointer; font-size: 1rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: 0.3s;">
                        Kirim Jawaban
                    </button>
                </div>

            </form>
        @endif
    </div>
@endsection

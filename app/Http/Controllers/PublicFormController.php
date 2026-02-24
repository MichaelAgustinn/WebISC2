<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormResponse;
use App\Models\FormAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicFormController extends Controller
{
    public function index(Request $request)
    {
        $query = Form::withCount('fields')->latest();

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $forms = $query->paginate(6);
        $recentForms = Form::latest()->take(4)->get();
        $totalForms = Form::count();

        return view('landing.forms.index', compact('forms', 'recentForms', 'totalForms'));
    }

    public function show($slug)
    {
        $form = Form::where('slug', $slug)->with(['fields' => function ($query) {
            $query->orderBy('order_index', 'asc');
        }])->firstOrFail();

        // CEK APAKAH USER SUDAH PERNAH MENGISI FORM INI
        $hasSubmitted = FormResponse::where('form_id', $form->id)
            ->where('user_id', Auth::id())
            ->exists();

        // Kirim variabel $hasSubmitted ke view
        return view('landing.forms.show', compact('form', 'hasSubmitted'));
    }

    public function submit(Request $request, $slug)
    {
        $form = Form::where('slug', $slug)->firstOrFail();

        // KEAMANAN BACKEND: Cek lagi saat disubmit (Mencegah bypass inspect element)
        $hasSubmitted = FormResponse::where('form_id', $form->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($hasSubmitted) {
            return back()->with('error', 'Akses ditolak: Anda sudah pernah mengisi formulir ini.');
        }

        // 1. Validasi
        $rules = [];
        $messages = [];

        foreach ($form->fields as $field) {
            $rule = [];

            if ($field->is_required) {
                $rule[] = 'required';
                $messages["answers.{$field->id}.required"] = "Pertanyaan '{$field->label}' wajib diisi!";
            } else {
                $rule[] = 'nullable';
            }

            if ($field->type === 'file') {
                $rule[] = 'file';
                $rule[] = 'mimes:jpg,jpeg,png,pdf,doc,docx,zip,rar';
                $rule[] = 'max:5120';
                $messages["answers.{$field->id}.mimes"] = "Format file '{$field->label}' tidak didukung.";
                $messages["answers.{$field->id}.max"] = "Ukuran file '{$field->label}' maksimal 5MB.";
            }

            $rules["answers.{$field->id}"] = implode('|', $rule);
        }

        $request->validate($rules, $messages);

        // 2. Simpan Data Response
        $response = FormResponse::create([
            'form_id' => $form->id,
            'user_id' => Auth::id(), // Pasti tersimpan karena sudah dilindungi middleware auth
        ]);

        // 3. Simpan Jawaban
        if ($request->has('answers')) {
            foreach ($request->answers as $fieldId => $answer) {
                $field = $form->fields->find($fieldId);
                if (!$field) continue;

                $answerText = null;
                $answerFile = null;

                if ($field->type === 'file' && $request->hasFile("answers.$fieldId")) {
                    $file = $request->file("answers.$fieldId");
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/responses'), $filename);
                    $answerFile = 'uploads/responses/' . $filename;
                } else {
                    $answerText = is_array($answer) ? json_encode($answer) : $answer;
                }

                FormAnswer::create([
                    'form_response_id' => $response->id,
                    'form_field_id' => $fieldId,
                    'answer_text' => $answerText,
                    'answer_file' => $answerFile,
                ]);
            }
        }

        return back()->with('success', 'Terima kasih! Jawaban formulir Anda telah berhasil dikirim.');
    }
}

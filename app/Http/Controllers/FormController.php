<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FormController extends Controller
{
    // Menampilkan daftar form
    public function index()
    {
        $forms = Form::withCount('fields')->latest()->paginate(10);
        return view('user.forms.index', compact('forms'));
    }

    // Menampilkan halaman buat form baru
    public function create()
    {
        return view('user.forms.create');
    }

    // MENYIMPAN FORM BARU (CREATE)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi Thumbnail
            'fields' => 'required|array|min:1',
            'fields.*.label' => 'required|string',
            'fields.*.type' => 'required|string',
            'fields.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar soal
        ]);

        // 1. Upload Thumbnail (cover_image)
        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = time() . '_cover_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/forms'), $filename);
            $coverImagePath = 'uploads/forms/' . $filename;
        }

        $slug = Str::slug($request->title) . '-' . Str::random(5);

        $form = Form::create([
            'title' => $request->title,
            'slug' => $slug, // Simpan slug
            'description' => $request->description,
            'cover_image' => $coverImagePath ?? null,
        ]);

        // 3. Simpan Looping Field Pertanyaan
        foreach ($request->fields as $index => $field) {
            $questionImagePath = null;

            // Upload Gambar Pertanyaan (jika ada)
            if (isset($field['image']) && $request->hasFile("fields.$index.image")) {
                $qFile = $request->file("fields.$index.image");
                $qFilename = time() . '_q_' . uniqid() . '.' . $qFile->getClientOriginalExtension();
                $qFile->move(public_path('uploads/forms/questions'), $qFilename);
                $questionImagePath = 'uploads/forms/questions/' . $qFilename;
            }

            $form->fields()->create([
                'label' => $field['label'],
                'image' => $questionImagePath,
                'type' => $field['type'],
                'is_required' => isset($field['is_required']) ? (bool) $field['is_required'] : false,
                'order_index' => $index,
            ]);
        }

        return redirect()->route('forms.index')->with('success', 'Formulir berhasil dibuat!');
    }

    // Menampilkan halaman edit form
    public function edit(Form $form)
    {
        $form->load(['fields' => function ($query) {
            $query->orderBy('order_index', 'asc');
        }]);

        return view('user.forms.edit', compact('form'));
    }

    // MENYIMPAN PERUBAHAN FORM (UPDATE)
    public function update(Request $request, Form $form)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'fields' => 'required|array|min:1',
            'fields.*.label' => 'required|string',
            'fields.*.type' => 'required|string',
            'fields.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 1. Cek jika Admin mengupload Thumbnail baru
        if ($request->hasFile('cover_image')) {
            // Hapus fisik gambar lama jika ada
            if ($form->cover_image && File::exists(public_path($form->cover_image))) {
                File::delete(public_path($form->cover_image));
            }

            $file = $request->file('cover_image');
            $filename = time() . '_cover_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/forms'), $filename);

            $form->cover_image = 'uploads/forms/' . $filename;
        }

        // Update Judul & Deskripsi
        $form->title = $request->title;
        $form->slug = Str::slug($request->title) . '-' . Str::random(5);
        $form->description = $request->description;
        $form->save();

        // 2. Update / Tambah Field Pertanyaan
        $submittedFieldIds = [];

        foreach ($request->fields as $index => $fieldData) {
            $isRequired = isset($fieldData['is_required']) ? (bool) $fieldData['is_required'] : false;
            $fieldId = $fieldData['id'] ?? null;

            // Jika Field LAMA (ada ID dari database)
            if ($fieldId && $fieldId < 1000000000000) {
                $existingField = FormField::find($fieldId);

                if ($existingField && $existingField->form_id == $form->id) {

                    // Cek jika ada gambar pertanyaan baru yang diupload
                    if ($request->hasFile("fields.$index.image")) {
                        // Hapus gambar soal lama
                        if ($existingField->image && File::exists(public_path($existingField->image))) {
                            File::delete(public_path($existingField->image));
                        }
                        // Upload gambar soal baru
                        $qFile = $request->file("fields.$index.image");
                        $qFilename = time() . '_q_' . uniqid() . '.' . $qFile->getClientOriginalExtension();
                        $qFile->move(public_path('uploads/forms/questions'), $qFilename);

                        $existingField->image = 'uploads/forms/questions/' . $qFilename;
                    }

                    $existingField->update([
                        'label' => $fieldData['label'],
                        'type' => $fieldData['type'],
                        'is_required' => $isRequired,
                        'order_index' => $index,
                        // image sudah diupdate di atas jika ada file baru
                    ]);
                    $submittedFieldIds[] = $existingField->id;
                }
            } else {
                // JIKA FIELD BARU (Ditambahkan via tombol + saat edit)
                $questionImagePath = null;

                if ($request->hasFile("fields.$index.image")) {
                    $qFile = $request->file("fields.$index.image");
                    $qFilename = time() . '_q_' . uniqid() . '.' . $qFile->getClientOriginalExtension();
                    $qFile->move(public_path('uploads/forms/questions'), $qFilename);
                    $questionImagePath = 'uploads/forms/questions/' . $qFilename;
                }

                $newField = $form->fields()->create([
                    'label' => $fieldData['label'],
                    'image' => $questionImagePath,
                    'type' => $fieldData['type'],
                    'is_required' => $isRequired,
                    'order_index' => $index,
                ]);
                $submittedFieldIds[] = $newField->id;
            }
        }

        // 3. Hapus Field yang dihapus oleh Admin (beserta file gambarnya)
        $fieldsToDelete = $form->fields()->whereNotIn('id', $submittedFieldIds)->get();
        foreach ($fieldsToDelete as $delField) {
            if ($delField->image && File::exists(public_path($delField->image))) {
                File::delete(public_path($delField->image));
            }
            $delField->delete();
        }

        return redirect()->route('forms.index')->with('success', 'Formulir berhasil diperbarui!');
    }

    // MENGHAPUS FORM
    public function destroy(Form $form)
    {
        // Hapus file thumbnail fisik
        if ($form->cover_image && File::exists(public_path($form->cover_image))) {
            File::delete(public_path($form->cover_image));
        }

        // Hapus file fisik gambar pertanyaan
        foreach ($form->fields as $field) {
            if ($field->image && File::exists(public_path($field->image))) {
                File::delete(public_path($field->image));
            }
        }

        $form->delete();
        return back()->with('success', 'Formulir berhasil dihapus!');
    }

    public function responses(Form $form)
    {
        $form->load([
            'fields' => function ($query) {
                $query->orderBy('order_index', 'asc'); // Urutkan kolom pertanyaan
            },
            'responses' => function ($query) {
                $query->latest(); // Urutkan jawaban dari yang terbaru
            },
            'responses.user', // Ambil data user yang login
            'responses.answers' // Ambil isi jawabannya
        ]);

        return view('user.forms.responses', compact('form'));
    }
}

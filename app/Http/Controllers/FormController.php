<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormField;
use Illuminate\Http\Request;

class FormController extends Controller
{
    // 1. Tampilkan Daftar Form
    public function index()
    {
        // Mengambil semua form beserta jumlah pertanyaannya
        $forms = Form::withCount('fields')->latest()->paginate(10);
        return view('user.forms.index', compact('forms'));
    }

    // 2. Halaman Buat Form
    public function create()
    {
        return view('user.forms.create');
    }

    // 3. Simpan Form Baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'fields' => 'required|array|min:1',
            'fields.*.label' => 'required|string',
            'fields.*.type' => 'required|string',
        ]);

        $form = Form::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        foreach ($request->fields as $index => $field) {
            $form->fields()->create([
                'label' => $field['label'],
                'type' => $field['type'],
                'is_required' => isset($field['is_required']) ? (bool) $field['is_required'] : false,
                'order_index' => $index,
            ]);
        }

        return redirect()->route('forms.index')->with('success', 'Formulir berhasil dibuat!');
    }

    // 4. Halaman Edit Form
    public function edit(Form $form)
    {
        // Load relasi fields yang diurutkan berdasarkan order_index
        $form->load(['fields' => function ($query) {
            $query->orderBy('order_index', 'asc');
        }]);

        return view('user.forms.edit', compact('form'));
    }

    // 5. Update Form
    public function update(Request $request, Form $form)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'fields' => 'required|array|min:1',
            'fields.*.label' => 'required|string',
            'fields.*.type' => 'required|string',
        ]);

        // Update data induk
        $form->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        $submittedFieldIds = [];

        foreach ($request->fields as $index => $fieldData) {
            $isRequired = isset($fieldData['is_required']) ? (bool) $fieldData['is_required'] : false;

            // Cek apakah ini field lama (punya ID dari database) atau field baru dari JS (ID besar berupa timestamp Date.now)
            // ID dari database biasanya kecil, timestamp JS lebih dari 1 Triliun
            if (isset($fieldData['id']) && $fieldData['id'] < 1000000000000) {
                // Update Field Lama
                $field = FormField::find($fieldData['id']);
                if ($field && $field->form_id == $form->id) {
                    $field->update([
                        'label' => $fieldData['label'],
                        'type' => $fieldData['type'],
                        'is_required' => $isRequired,
                        'order_index' => $index,
                    ]);
                    $submittedFieldIds[] = $field->id;
                }
            } else {
                // Buat Field Baru
                $newField = $form->fields()->create([
                    'label' => $fieldData['label'],
                    'type' => $fieldData['type'],
                    'is_required' => $isRequired,
                    'order_index' => $index,
                ]);
                $submittedFieldIds[] = $newField->id;
            }
        }

        // Hapus field yang tidak ada di request (artinya dihapus oleh user saat edit)
        $form->fields()->whereNotIn('id', $submittedFieldIds)->delete();

        return redirect()->route('forms.index')->with('success', 'Formulir berhasil diperbarui!');
    }

    // 6. Hapus Form
    public function destroy(Form $form)
    {
        $form->delete(); // Karena di migration pakai onDelete('cascade'), fields-nya otomatis terhapus
        return back()->with('success', 'Formulir berhasil dihapus!');
    }
}

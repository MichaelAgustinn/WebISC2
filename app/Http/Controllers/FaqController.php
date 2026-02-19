<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::latest()->get();
        return view('admin.faq.index', compact('faqs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        Faq::create($request->all());
        return back()->with('success', 'FAQ berhasil ditambahkan');
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        $faq->update($request->all());
        return back()->with('success', 'FAQ berhasil diperbarui');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return back()->with('success', 'FAQ berhasil dihapus');
    }
}

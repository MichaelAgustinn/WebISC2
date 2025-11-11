<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();
        return view('admin.faq-index', ['faqs' => $faqs]);
    }

    public function show($id)
    {
        $faq = Faq::find($id);
        return view('admin.faq', ['faq' => $faq]);
    }

    public function create()
    {
        return view('admin.faq');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answered' => 'required|string',
        ]);

        //! klo data ada maka di update
        if ($request->id) {
            $data = Faq::find($request->id);
            if (!$data) {
                return redirect()->route('faq.landing')->with('error', 'Data tidak ditemukan');
            }
        }
        // ! jika tidak ada maka buat baru
        else {
            $data = new Faq();
        }
        $data->question = $request->question;
        $data->answered = $request->answered;
        $data->save();
        if ($request->id) {
            return redirect()->route('faq.landing.show', $request->id)->with('success', 'Data berhasil disimpan');
        } else {
            return redirect()->route('faq.landing')->with('success', 'Data berhasil disimpan');
        }
    }

    public function destroy($id)
    {
        $faq = Faq::find($id);
        $faq->delete();
        return redirect()->back()->with('success', 'Data Dihapus');
    }
}

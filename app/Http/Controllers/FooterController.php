<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function index()
    {
        $footers = Footer::all();
        return view('admin.footer-index', ['footers' => $footers]);
    }

    public function create()
    {
        return view('admin.footer');
    }

    public function store(Request $request)
    {
        $footer = new Footer();
        $footer->nomor_telepon = $request->nomor_telepon;
        $footer->email = $request->email;
        $footer->link_facebook = $request->link_facebook;
        $footer->link_instagram = $request->link_instagram;
        $footer->link_tiktok = $request->link_tiktok;
        $footer->save();

        return redirect()->back()->with('success', 'Data Disimpan');
    }

    public function update(Request $request, $id)
    {
        $footer = Footer::find($request->id);
        $footer->nomor_telepon = $request->nomor_telepon;
        $footer->email = $request->email;
        $footer->link_facebook = $request->link_facebook;
        $footer->link_instagram = $request->link_instagram;
        $footer->link_tiktok = $request->link_tiktok;
        $footer->save();

        return redirect()->back()->with('success', 'Data Disimpan');
    }

    public function show($id)
    {
        $footer = Footer::find($id);
        return view('admin.footer', ['footer' => $footer]);
    }

    public function destroy($id)
    {
        $footer = Footer::find($id);
        $footer->delete();
        return redirect()->back()->with('success', 'Data Dihapus');
    }
}

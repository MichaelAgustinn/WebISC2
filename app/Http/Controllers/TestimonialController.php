<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $users = User::all();
        $testimonials = Testimonial::all();
        return view('admin.testimonial-index', ['users' => $users, 'testimonials' => $testimonials]);
    }
    public function create()
    {
        $users = User::all();
        return view('admin.testimonial', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'user_id'  => 'required|exists:users,id',
            'message'  => 'required|string|min:5',
        ], [
            'rating.required'  => 'Rating wajib diisi',
            'rating.integer'   => 'Rating harus berupa angka',
            'rating.min'       => 'Rating minimal 1',
            'rating.max'       => 'Rating maksimal 5',
            'user_id.required' => 'User wajib dipilih',
            'user_id.exists'   => 'User tidak valid',
            'message.required' => 'Pesan wajib diisi',
            'message.min'      => 'Pesan minimal 5 karakter',
        ]);

        if ($request->id) {
            $data = Testimonial::find($request->id);
            if (!$data) {
                return redirect()->back()->with('error', 'Data tidak ditemukan');
            }
        } else {
            $data = new Testimonial();
        }

        $data->rating = $validated['rating'];
        $data->user_id = $validated['user_id'];
        $data->message = $validated['message'];
        $data->save();

        return redirect()->back()->with('success', 'Data Berhasil Disimpan');
    }


    public function edit($id)
    {
        $testimonial = Testimonial::find($id);
        $users = User::all();
        return view('admin.testimonial', ['testimonial' => $testimonial, 'users' => $users]);
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::find($id);
        $testimonial->delete();
        return redirect()->back()->with('success', 'Data Dihapus');
    }
}

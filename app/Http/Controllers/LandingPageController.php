<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LandingPageController extends Controller
{
    public function index()
    {
        $contents = LandingPage::pluck('value', 'key')->toArray();
        return view('admin.landing.index', compact('contents'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                if ($file->isValid()) {
                    $filename = time() . '_' . $key . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/landing'), $filename);

                    $old = LandingPage::where('key', $key)->first();
                    if ($old && $old->value && File::exists(public_path('uploads/landing/' . $old->value))) {
                        File::delete(public_path('uploads/landing/' . $old->value));
                    }

                    LandingPage::updateOrCreate(
                        ['key' => $key],
                        [
                            'value' => $filename,
                            'type' => 'image',
                            'section' => explode('_', $key)[0]
                        ]
                    );
                }
            }
            else {
                if ($value !== null) {
                    LandingPage::updateOrCreate(
                        ['key' => $key],
                        [
                            'value' => $value,
                            'type' => 'text', 
                            'section' => explode('_', $key)[0]
                        ]
                    );
                }
            }
        }

        return back()->with('success', 'Landing Page berhasil diperbarui!');
    }
}

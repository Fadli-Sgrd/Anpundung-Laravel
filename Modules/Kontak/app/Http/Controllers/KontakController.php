<?php

namespace Modules\Kontak\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Kontak\Models\Kontak;

class KontakController extends Controller
{
    /**
     * Display contact form
     */
    public function index()
    {
        return view('kontak::index');
    }

    /**
     * Store contact message
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        Kontak::create($validated);

        return redirect()->back()->with('success', 'Pesan kontak Anda berhasil dikirim. Kami akan segera merespon.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('kontak::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('kontak::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}

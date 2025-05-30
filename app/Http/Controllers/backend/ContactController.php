<?php

namespace App\Http\Controllers\backend;

use App\Config;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $config = Config::pluck('value', 'name')->all();

        return view('backend.contact.edit', compact('config'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Config  $config
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = [
            'contact_name' => 'required|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string',
        ];

        $this->validate($request, $rules);
        $data = $request->only('contact_name', 'contact_email', 'contact_phone');

        $user_id = auth()->user()->id;
        foreach ($data as $name => $value) {
            Config::updateOrCreate(
                ['name' => $name],
                ['value' => $value, 'updated_by_id' => $user_id]
            );
        }

        session()->flash('alert-success', 'Se ha actualizado la configuración correctamente.');

        return redirect()->route('backend.contact.edit');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HotelController extends Controller
{
    

    public function delete($id)
    {
        \App\Models\Hotel::findOrFail($id)->delete();
        return redirect()->route('hotels')->with('success', 'Hôtel supprimé avec succès.');
    }

    public function edit($id)
    {
        $hotel = \App\Models\Hotel::findOrFail($id);
        //dd($hotel->name );
        return view('livewire.hotel.hotel-update', compact('hotel'));
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MiceInquiry;
use Illuminate\Http\Request;

class MiceInquiryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mice_room_id' => 'required|exists:mice_rooms,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|regex:/^08[0-9]{8,11}$/',
            'event_type' => 'required|string',
            'event_other_description' => 'required_if:event_type,other|nullable|string',
        ]);

        MiceInquiry::create($validated);

        // TODO: Tambahkan notifikasi WhatsApp ke admin

        return back()->with('success', 'Thank you! Our sales team will contact you shortly.');
    }
}
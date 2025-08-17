<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::where('is_available', true)->paginate(10);
        return view('frontend.rooms.index', compact('rooms'));
    }

    public function show($slug)
    {
        $room = Room::where('slug', $slug)->firstOrFail();
        return view('frontend.rooms.show', compact('room'));
    }

    public function checkAvailability(Request $request)
    {
        // Ambil semua input dari form
        $searchParams = $request->all();

        // TODO: Logika untuk memfilter kamar berdasarkan tanggal akan ditambahkan nanti.
        // Untuk saat ini, kita tampilkan semua kamar yang tersedia.
        $rooms = Room::where('is_available', true)->get();

        // Kirim data kamar dan parameter pencarian ke view
        return view('frontend.rooms.availability', compact('rooms', 'searchParams'));
    }
}
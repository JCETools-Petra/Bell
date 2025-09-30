<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\PriceOverride;
use Carbon\Carbon; 

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::where('is_available', true)->paginate(10);
        return view('frontend.rooms.index', compact('rooms'));
    }

    public function show(Request $request, $slug)
    {
        $room = Room::where('slug', $slug)->firstOrFail();

        // Cek apakah ada parameter 'checkin' di URL
        if ($request->has('checkin')) {
            // Ambil tanggal check-in dan format ke Y-m-d
            $checkinDate = Carbon::createFromFormat('d-m-Y', $request->checkin)->format('Y-m-d');
            
            // Cari harga khusus untuk kamar ini pada tanggal tersebut
            $override = PriceOverride::where('room_id', $room->id)
                                     ->where('date', $checkinDate)
                                     ->first();
            
            // Jika ditemukan harga khusus, timpa harga standar kamar
            if ($override) {
                $room->price = $override->price; 
            }
        }

        return view('frontend.rooms.show', compact('room'));
    }

    public function checkAvailability(Request $request)
    {
        $searchParams = $request->all();
        $rooms = Room::where('is_available', true)->get();

        // 3. Tambahkan Logika untuk Mengambil Harga Dinamis
        if (isset($searchParams['checkin'])) {
            $checkinDate = Carbon::createFromFormat('d-m-Y', $searchParams['checkin'])->format('Y-m-d');
            
            foreach ($rooms as $room) {
                $override = PriceOverride::where('room_id', $room->id)
                                         ->where('date', $checkinDate)
                                         ->first();
                // Ganti harga kamar dengan harga override jika ada
                if ($override) {
                    $room->price = $override->price; 
                }
            }
        }
        // 4. Kirim data yang sudah diperbarui ke view
        return view('frontend.rooms.availability', compact('rooms', 'searchParams'));
    }
}
<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Models\PriceOverride;
use App\Models\Commission;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $affiliate = Auth::user()->affiliate;
        if (!$affiliate) {
            return redirect()->route('affiliate.dashboard')->with('error', 'Affiliate data not found. Please contact support.');
        }

        $bookings = Booking::where('affiliate_id', $affiliate->id)
                            ->with('room')
                            ->latest()
                            ->paginate(10);
                            
        return view('frontend.affiliate.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $searchParams = $request->all();
        $rooms = Room::where('is_available', true)->get();
        $checkinDate = null;

        if (isset($searchParams['checkin'])) {
            $checkinDate = Carbon::createFromFormat('d-m-Y', $searchParams['checkin'])->format('Y-m-d');
        }

        foreach ($rooms as $room) {
            $currentPrice = $room->price;
            if ($checkinDate) {
                $override = PriceOverride::where('room_id', $room->id)
                                         ->where('date', $checkinDate)
                                         ->first();
                if ($override) {
                    $currentPrice = $override->price;
                }
            }
            if ($room->discount_percentage > 0) {
                $discountAmount = $currentPrice * ($room->discount_percentage / 100);
                $currentPrice -= $discountAmount;
            }
            $room->price = $currentPrice;
        }
        
        return view('frontend.affiliate.bookings.create', compact('rooms', 'searchParams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $affiliate = Auth::user()->affiliate;
        if (!$affiliate) {
            abort(403, 'Your affiliate account is not properly configured.');
        }

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'checkin' => 'required|date_format:d-m-Y',
            'checkout' => 'required|date_format:d-m-Y|after:checkin',
            'num_rooms' => 'required|integer|min:1',
            'guest_name' => 'required|string|max:255',
            'guest_phone' => 'required|string|max:20',
            'guest_email' => 'nullable|email|max:255',
        ]);

        $room = Room::findOrFail($validated['room_id']);
        $checkin = Carbon::createFromFormat('d-m-Y', $validated['checkin']);
        $checkout = Carbon::createFromFormat('d-m-Y', $validated['checkout']);
        
        $totalPrice = 0;
        $discountPercentage = $room->discount_percentage;

        for ($date = $checkin->copy(); $date->lt($checkout); $date->addDay()) {
            $override = $room->priceOverrides()->where('date', $date->format('Y-m-d'))->first();
            $nightlyPrice = $override ? $override->price : $room->price;
            
            // Terapkan diskon afiliasi
            if ($discountPercentage > 0) {
                $discountAmount = $nightlyPrice * ($discountPercentage / 100);
                $nightlyPrice -= $discountAmount;
            }
            $totalPrice += $nightlyPrice;
        }

        $finalPrice = $totalPrice * $validated['num_rooms'];

        $booking = Booking::create([
            'room_id' => $room->id,
            'affiliate_id' => $affiliate->id, // Menyimpan ID afiliasi
            'guest_name' => $validated['guest_name'],
            'guest_phone' => $validated['guest_phone'],
            'guest_email' => $validated['guest_email'],
            'checkin_date' => $checkin->format('Y-m-d'),
            'checkout_date' => $checkout->format('Y-m-d'),
            'num_rooms' => $validated['num_rooms'],
            'total_price' => $finalPrice, // Menyimpan harga yang sudah didiskon
            'status' => 'pending',
            'payment_method' => 'online',
            'access_token' => Str::random(32),
        ]);

        // Arahkan ke halaman pembayaran yang ditangani oleh Frontend/BookingController
        return redirect()->route('booking.payment', ['booking' => $booking->access_token]);
    }
}
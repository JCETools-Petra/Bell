<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Affiliate;
use App\Models\Booking;
use App\Models\Commission;
use App\Services\CommissionService;
use Illuminate\Support\Facades\Gate;

class CommissionController extends Controller
{
    protected $commissionService;

    public function __construct(CommissionService $commissionService)
    {
        $this->commissionService = $commissionService;
    }
    public function create()
    {
        $affiliates = Affiliate::where('status', 'active')->with('user')->get();
        return view('admin.commissions.create', compact('affiliates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'affiliate_id' => 'required|exists:affiliates,id',
            'booking_reference' => 'required|string',
            'booking_amount' => 'required|numeric|min:0',
        ]);

        $affiliate = Affiliate::find($validated['affiliate_id']);

        // Create a placeholder booking for manual commission tracking
        $firstRoom = \App\Models\Room::first();
        if (!$firstRoom) {
            return back()->withErrors(['error' => 'No rooms available in the system. Please add a room first.']);
        }

        $booking = Booking::create([
            'room_id' => $firstRoom->id,
            'guest_name' => 'Manual Commission - ' . $validated['booking_reference'],
            'guest_email' => 'manual-commission@sorahotel.com',
            'guest_phone' => '0000000000',
            'num_rooms' => 1,
            'check_in_date' => now(),
            'check_out_date' => now()->addDay(),
            'total_price' => $validated['booking_amount'],
            'status' => 'completed',
            'payment_status' => 'paid',
        ]);

        // Use service to create commission
        $this->commissionService->createCommission(
            $affiliate,
            $booking,
            'Manual commission for booking: ' . $validated['booking_reference']
        );

        return redirect()->route('admin.affiliates.index')->with('success', 'Manual commission added successfully.');
    }

    public function index()
    {
        if (! Gate::allows('manage-commissions')) abort(403);

        $affiliates = Affiliate::with('user')
            ->withSum(['commissions as unpaid_amount' => function ($query) {
                $query->where('status', 'unpaid');
            }], 'commission_amount')
            ->paginate(15);
            
        return view('admin.commissions.index', compact('affiliates'));
    }

    public function update(Request $request, Commission $commission)
    {
        if (! Gate::allows('manage-commissions')) {
            abort(403);
        }
        
        $request->validate(['status' => 'required|in:paid,unpaid']);

        $commission->update(['status' => $request->status]);

        return back()->with('success', 'Commission status has been updated.');
    }

    public function show(Affiliate $affiliate)
    {
        if (! Gate::allows('manage-commissions')) abort(403);

        $commissions = $this->commissionService->getCommissions(
            $affiliate,
            'unpaid',
            now()->month
        );

        return response()->json($commissions);
    }

    public function markAsPaid(Affiliate $affiliate)
    {
        if (! Gate::allows('manage-commissions')) abort(403);

        $this->commissionService->markAsPaid($affiliate);

        return back()->with('success', 'All unpaid commissions for this affiliate have been marked as paid.');
    }

}
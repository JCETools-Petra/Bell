<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MiceInquiry;
use Illuminate\Http\Request;

class MiceInquiryController extends Controller
{
    public function index()
    {
        $inquiries = MiceInquiry::with('miceRoom')->latest()->paginate(15);
        return view('admin.mice_inquiries.index', compact('inquiries'));
    }

    public function destroy(MiceInquiry $miceInquiry)
    {
        $miceInquiry->delete();
        return back()->with('success', 'Inquiry deleted successfully.');
    }
}
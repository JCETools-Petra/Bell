<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MiceRoom;
use Illuminate\Http\Request;

class MiceController extends Controller
{
    public function index()
    {
        $miceRooms = MiceRoom::where('is_available', true)->paginate(10);
        return view('frontend.mice.index', compact('miceRooms'));
    }

    public function show($slug)
    {
        $mice = MiceRoom::where('slug', $slug)->firstOrFail();
        return view('frontend.mice.show', compact('mice'));
    }
}
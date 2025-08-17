<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MiceRoom;
use App\Models\Room;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $roomCount = Room::count();
        $miceCount = MiceRoom::count();
        return view('admin.dashboard', compact('roomCount', 'miceCount'));
    }
}
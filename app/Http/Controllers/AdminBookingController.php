<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class AdminBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();
        return view('admin.bookings.index', compact('bookings'));
    }
} 
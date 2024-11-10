<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use Illuminate\Http\Request;

class ShowAppointmentController extends Controller
{
    public function index(Request $request)
    {
        $slot = Slot::orderBy('id', 'desc')->paginate(10);
        return view("backend.aappointment.show", compact("slot"));        
    }
}

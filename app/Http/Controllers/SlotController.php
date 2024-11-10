<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    public function book_slot(Request $request)
    {
        $list = $this->generateSlots();
        $date_str = Carbon::today()->toDateString();
        $date = Carbon::parse($date_str)->format('d-m-Y');
        $list = $this->getAvailableSlots($list, $date);
        return view('frontend.pages.slot', ['list' => $list]);
    }
    public function generateSlots()
    {
        $slots = [];
        $startTime = Carbon::createFromFormat('H:i', '10:00');
        $endTime = Carbon::createFromFormat('H:i', '18:00');

        while ($startTime <= $endTime) {
            $slots[] = $startTime->format('g:i A');
            $startTime->addMinutes(10);
        }

        return $slots;
    }
    public function getAvailableSlots($allSlots, $date)
    {
        // Get booked slots for today
        $bookedSlots = Slot::whereDate('date', $date)
            ->pluck('slot')
            ->toArray();

        // Get available slots by removing booked ones
        $availableSlots = array_diff($allSlots, $bookedSlots);

        return $availableSlots;
    }
    public function getAvailableSlot(Request $request)
    {
        // Get booked slots for today
        $list = $this->generateSlots();
        $date = $request->date;
        $availableSlots = $this->getAvailableSlots($list, $date);
        return array_values($availableSlots);
    }

    public function save_slot(Request $request)
    {
        // check Validation added by saurav

        $this->validate($request, [
            'name' => 'required|string|min:2',
            'email' => 'required|email',
            'date' => 'required',
            'slot' => 'required',
            'phone' => 'required|numeric',
            'description' => 'required'
        ]);

        // return $request->all();
        
        // check Validation added by saurav

        Slot::create($request->all());
        return redirect()->back()->with('success', 'Appointment booked successfully');
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\OrderNotification;
use Helper;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        // return view('backend.notification.index');

        // $notifications = Auth::guard('admin')->user()->notifications; 
        // return view('backend.notification.index',compact('notifications'));

        // $orderNotifications = OrderNotification::whereNull('read_at')->get();
        // $orderNotificationsCount = $orderNotifications->count(); 
        $notifications = Auth::guard('admin')->user()->notifications; 
        return view('backend.notification.index', compact('notifications'));

    }
    public function show(Request $request)
    {        
        $notification = Auth::guard('admin')->user()->notifications->where('id', $request->id)->first();
        if ($notification) {
            $notification->markAsRead();
            return redirect($notification->data['actionURL']);
        }
        
        return redirect()->route('all.notification')->with('error', 'Notification not found.');

    }

    public function order_notify()
    {
        
        $notificationsData = Helper::getOrderNotifications();
        return view('backend.notification.order_notify',compact('notificationsData'));
    }

    public function order_notify_all()
    {
        return view('backend.notification.all_order_notify');
    }

    public function delete($id)
    {
        $notification = Notification::find($id);
        if ($notification) {
            $status = $notification->delete();
            if ($status) {
                session()->flash('success', 'Notification successfully deleted');
                return back();
            } else {
                session()->flash('error', 'Error please try again');
                return back();
            }
        } else {
            session()->flash('error', 'Notification not found');
            return back();
        }

    }

}

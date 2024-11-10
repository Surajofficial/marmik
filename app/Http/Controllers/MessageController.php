<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $messages = Message::paginate(20);
        $messages = Message::all();
        return view('backend.message.index')->with('messages', $messages);
    }
    public function messageFive()
    {
        $message = Message::whereNull('read_at')->limit(5)->get();
        return response()->json($message);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function store_contact(Request $request): RedirectResponse
    {
        // return $request->all();
        $request->validate([
            'name' => 'required|string|min:2',
            'email' => 'required|email',
            'message' => 'required|min:2|max:200',
            'subject' => 'required|string',
            'phone' => 'required|numeric'
        ]);
        
        // If validation passes, continue with your logic        
        // return $request->all();
        // check Validation added by saurav

        $message = Message::create($request->all());
        // return $message;
        $data = array();
        $data['url'] = route('message.show', $message->id);
        $data['date'] = $message->created_at->format('F d, Y h:i A');
        $data['name'] = $message->name;
        $data['email'] = $message->email;
        $data['phone'] = $message->phone;
        $data['message'] = $message->message;
        $data['subject'] = $message->subject;
        // return $data;    
        event(new MessageSent($data));
        return redirect()->back()->with('success', 'Your message has been successfully sent!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id): RedirectResponse|View
    {
        $message = Message::find($id);
        if ($message) {
            $message->read_at = \Carbon\Carbon::now();
            $message->save();
            return view('backend.message.show')->with('message', $message);
        } else {
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $message = Message::find($id);
        $status = $message->delete();
        if ($status) {
            session()->flash('success', 'Successfully deleted message');
        } else {
            session()->flash('error', 'Error occurred please try again');
        }
        return back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function get()
    {
        $contacts = User::where('id', '!=', auth()->id())->get();

        return response()->json($contacts);
    }

    public function getMessagesFor($id)
    {
//        $messages = Message::where('from', $id)->orWhere('to', $id)->get();
        $messages = Message::where([['from', $id], ['to', auth()->id()]])->orWhere([['from', auth()->id()], ['to', $id]])->get();

        return response()->json($messages);
    }

    public function send(Request $request) {
        $message = Message::create([
           'from' => auth()->id(),
            'to' => $request->contact_id,
            'text' => $request->text,
        ]);

        return response()->json($message);
    }
}

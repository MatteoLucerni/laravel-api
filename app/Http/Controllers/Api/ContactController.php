<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function sendMessage(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string'
        ], [
            'email.required' => 'The mail is required',
            'email.email' => 'The mail is not valid',
            'subject.required' => 'The subject is required',
            'message.required' => 'The content is required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 400);

        $mail = new ContactMessageMail(
            sender: $data['email'],
            subject: $data['subject'],
            content: $data['message'],
        );
        Mail::to(env('MAIL_TO_ADDRESS'))->send($mail);

        return response()->json($data);
        return response(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\TestMail;

class MailController extends Controller
{
    public function send(Request $request)
    {
        dd($request);
        $name = $user -> name;
        $email = $user -> email;

        Mail::send(new TestMail($name, $email));

        return redirect('/todos');
    }
}
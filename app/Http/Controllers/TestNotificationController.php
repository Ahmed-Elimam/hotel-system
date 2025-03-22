<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\ClientApprovedNotification;
use Illuminate\Http\Request;

class TestNotificationController extends Controller
{
    public function sendApprovalUserNotification(){
        $user = User::orderBy('id', 'desc')->first();
        $enrollmentData = [
            'body'=>"Your reservation is approved " ,
            'enrollmentText' => "we hope to spend amazing times in our hotel" ,
            'urlLoginAccount' => url ('/'),
            'thankYou' =>'You have 14 days to enroll'
        ] ;
        $user->notify(new ClientApprovedNotification($enrollmentData));
    }

}

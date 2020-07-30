<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Notification;

class NotificationController extends Controller
{
    
	public function __construct()
	{
		$this->middleware('auth');
	}
	
    public function read()
    {
    	$user=auth()->user();
		$user->unreadNotifications()->update(['read_at' => now()]);
		$html=view('notification',['notifications'=>$user->notifications])->render();

		return [$html];
    }

    public function destroy($id)
    {
    	Notification::where('id',$id)->delete();

    	//return $this->read();
   
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Room;

use App\Models\Booking;

use App\Models\Contact;




class Homecontroller extends Controller
{
    public function room_details( $id)
    {
        
        $room = Room::find($id);

        return view('home.room_details',compact('room'));


    }

    public function add_booking(Request $request , $id)
    {

      $request->validate([
        'startDate' => 'required|date',
        'endDate'  =>  'date|after:startDate',
      ]);


      $data = new Booking();
      
      $data->room_id = $id;

      $data->name = $request->name;

      $data->email = $request->email;

      $data->phone = $request->phone;

      $startDate = $request->startDate;

      $endDate = $request->endDate;

      $isBooked = Booking::where('room_id',$id)->where('star_date','<=',$endDate)->where('end_date','>=',$startDate)->exists();


      if($isBooked)

      {
        return  redirect()->back()->with('message',' Room is already booked please try different date');

      }

      else
      {
          
        $data->star_date = $request->startDate;

      $data->end_date = $request->endDate;

      $data->save();

      return redirect()->back()->with('message','Room booked succesfully');

      }

      

    }

    public function contact(Request $request)

    {
      $contact =  new contact;

      $contact->name = $request->name;

      $contact->email = $request->email;

      $contact->phone = $request->phone;

      $contact->message = $request->message;

      $contact->save();

      return redirect()->back();



    }

    public function logout(Request $request)
    {
        Request::logout(); 

        $request->session()->invalidate(); 

        $request->session()->regenerateToken();
        return redirect('/'); 
    }
}

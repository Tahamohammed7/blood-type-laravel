<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Token;
use Illuminate\Http\Request;
use App\Governorate;
use App\Post;
use App\City;
use App\Category;
use App\Contact;
use App\BloodType;
use App\Setting;
use App\DonationRequest;
use App\Notification;

class MainController extends Controller
{

    public function settings()
    {
        $settings = Setting::all();

        return responseJson(1,'success', $settings);
    }

    public function posts()
    {
        $posts = Post::with('category')->paginate(10);

        return responseJson(1,'success', $posts);
    }

    public function categories()
    {
        $categories = Category::all();

        return responseJson(1,'success', $categories);
    }

   public function donation(Request $request)
    {
        $donation = $request->user()->notification()->latest()->paginate(10);

        return responseJson(1,'success', $donation);
    }

    public function donationRequestCreate(Request $request)
    {
        // Validation
//        RequestLog::create(['content' => $request->all(),'service' => 'donation create']);
        $rules = [
            'patient_name' => 'required',
            'patient_age'  => 'required',
            'blood_type_id'  => 'required',
            'bags_num'  => 'required',
            'hospital_address'  => 'required',
            'city_id'  => 'required|exists:cities,id',
            'patient_phone'  => 'required|digits:11',
        ];
        $validator = validator()->make($request->all(),$rules);
        if ($validator->fails())
        {
            return responseJson(0,$validator->errors()->first(),$validator->errors());
        }

        $donationRequest = $request->user()->donationRequests()->create($request->all());

        $clientsIds = $donationRequest->city->governorate->clients()->whereHas('bloodtypes',function ($q) use ($request,$donationRequest)
        {
            $q->where('blood_types.id',$donationRequest->blood_type_id);
        })->pluck('clients.id')->toArray();
//dd($clientsIds);
        if (count($clientsIds))
        {
            $notification = $donationRequest->notification()->create([
                'title' => 'احتاج متبرع لفصيله ',
                'content' => $donationRequest->blood_type_id,'محتاج متبرع لفصيله ',
            ]);
            $notification->clients()->attach($clientsIds);

//            $tokens = $client->tokens()->where('token','!=','')->whereIn('client_id',$clientsIds)->pluck('token')->toArray();
            $tokens = Token::whereIn('client_id',$clientsIds)->where('token','!=',null)->pluck('token')->toArray();
//dd($tokens);
            if (count($tokens))
            {

                $title   = $notification->title;
                $content = $notification->content;
                $data = [
                    'action' => 'new notify',
                    'data' => null,
                    'client' => 'client',
                    'title' => $notification->title,
                    'content' => $notification->content,
                    'donation_request_id' => $notification->id,
                ];
//                info(json_encode($data));
//
                $send = notifyByFirebase($title,$content,$tokens,$data);
//                info($send);
//                info("firebase result",$send);
//                $send = json_encode($send);
//dd($send);
            }
        }
          return responseJson(1,'تم الاضافه بنجاح',$donationRequest->load('city'));
    }

    public function notification(Request $request)
    {
        $notification = $request->user()->notification()->latest()->paginate(10);
        // dd($notification);

        return responseJson(1,'success', $notification);
    }

    public function contacts()
    {
        $contacts = Contact::all();

        return responseJson(1,'success', $contacts);
    }

    public function bloodtypes()
    {
        $bloodtypes = BloodType::all();

        return responseJson(1,'success', $bloodtypes);
    }

   public function governorte()
   {
       $governortes = Governorate::all();

       return responseJson(1,'success', $governortes);
   }

   public function cities(Request $request)
   {
       $cities = City::where(function($query) use($request)
       {
         if($request->has('governorte_id'))
         {
             $query->where('governorte_id',$request->governorte_id);
         }
       })->get();

       return responseJson(1,'success', $cities);
   }

   public function postfavourites(Request $request)
   {
       $rules = [
           'post_id' => 'required:exists:posts,id'
       ];
       $validator = validator()->make($request->all(),$rules);

       if ($validator->fails())
       {
           return responseJson(0,$validator->errors()->first(),$validator->errors());
       }

       $toggle = $request->user()->favourites()->toggle($request->post_id);
       return responseJson(1,'Success',$toggle);
   }

    public function myfavourites(Request $request)
    {
        $posts = $request->user()->favourites()->latest()->paginate(10);
        return responseJson(1,'Loaded...',$posts);
    }
}

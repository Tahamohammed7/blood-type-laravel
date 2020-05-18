<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator()->make($request->all(),[

            'name'               => 'required',
            'email'              => 'required|unique:clients',
            'password'           => 'required|confirmed',
            'blood_type_id'      => 'required',
            'city_id'            => 'required|exists:cities,id',
            'date_of_birth'      => 'required|date_format:Y-m-d',
            'last_donation_date' => 'required|date_format:Y-m-d',
            'phone'              => 'required|unique:clients|digits:11',
        ]);

        if ($validator->fails())
        {
            return responseJson(0,$validator->errors()->first(),$validator->errors());
        }
        $request->merge(['password' => bcrypt($request->password)]);
        $client = Client::create($request->all());
        $client->api_token = Str::random(60);
        $client->save();

        $client->city()->attach($request->city_id);
        $bloodtype = BloodType::where('name',$request->blood_type)->first();
        $client->bloodType()->attach($bloodtype->id);

        return responseJson(1,'تم الاضافه بنجاح',[
            'api_token' => $client->api_token,
            'client'    => $client
        ]);
    }

    public function login()
    {
       return view('front.login');
    }
    public function doLogin(Request $request)
    {

        if (auth()->guard('client')->attempt(['phone' => request('phone'), 'password' => request('password')])) {
//            dd(auth()->guard('client-web')->name);
            return redirect('/');

        } else {
            session()->flash('error', trans('admin.inccorrect_information_login'));
            return redirect('login');
        }

    }
}

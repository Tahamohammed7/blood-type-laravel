<?php

namespace App\Http\Controllers\Api;

use App\BloodType;
use App\Http\Controllers\Controller;
use App\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Client;
use Illuminate\Support\Str;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;


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

  public function login(Request $request)
  {
       $validator = Validator()->make($request->all(),[

        'phone'              => 'required',
        'password'           => 'required',

       ]);

       if ($validator->fails())
       {
          return responseJson(0,$validator->errors()->first(),$validator->errors());
       }
     $client = Client::where('phone',$request->phone)->first();
     if($client)
     {
       if(Hash::check($request->password,$client->password))
       {
        return responseJson(1,'تم تسجيل الدخول بنجاح',[
          'api_token' => $client->api_token,
          'client'    => $client
      ]);
       }else {
        return responseJson(0,'بيانات الدخول غير صحيحه');
       }
     }else{
      return responseJson(0,'بيانات الدخول غير صحيحه');
     }

}
public function resetpassword(Request $request)
{
  $validator = Validator()->make($request->all(),[

    'phone'    => 'required',

   ]);

   if ($validator->fails())
   {
      return responseJson(0,$validator->errors()->first(),$validator->errors());
   }
   $client = Client::where('phone',$request->phone)->first();
   if($client)
   {
     $code = rand(1111,9999);
     $update = $client->update(['pin_code' => $code]);
     if($update)
     {

      Mail::to($client->email)
      ->bcc("tahamoh757@gmail.com")
      ->queue(new ResetPassword($client));

      return responseJson(1,'برجاء فحص هاتفك',[
        'pin_code' => $code
    ]);
         }else {
      return responseJson(0,'حدث خطا؛حاول مره اخري');
     }
   }else{
    return responseJson(0,'لا يوجد اي حساب مرتبط بهذا الهاتف');
   }

}

public function newpassword(Request $request)
{
  $validator = Validator()->make($request->all(),[

    'phone'              => 'required',
    'password'           => 'required',
    'password'           => 'required',

   ]);

   if ($validator->fails())
   {
      return responseJson(0,$validator->errors()->first(),$validator->errors());
   }
   $client = Client::where('pin_code',$request->pin_code)->where('pin_code', '!=' ,0)->where('phone',$request->phone)->first();
   if($client)
   {
     $client->password = bcrypt($request->password);
     $client->pin_code = null;

     if($client->save())
     {

      return responseJson(1,'تم تغيير كلمه المرور بنجاح');
         } else {
      return responseJson(0,'حدث خطا؛حاول مره اخري');
     }
   }
}

    public function profile(Request $request)
    {
        $validation = validator()->make($request->all(),[
            'password' => 'confirmed',
            'email'    => Rule::unique('clients')->ignore($request->user()->id),
            'phone'    => Rule::unique('clients')->ignore($request->user()->id),
        ]);
        if ($validation->fails())
        {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
      }

        $loginUser = $request->user();
        $loginUser->update($request->all());

        if ($request->has('password'))
        {
            $loginUser->password = bcrypt($request->password);
        }
        $loginUser->save();

        if ($request->has('governorate_id'))
        {
            $loginUser->city()->datach($request->city_id);
            $loginUser->city()->attach($request->city_id);
        }

        if ($request->has('blood_type'))
        {
            $bloodType = BloodType::where('name',$request->blood_type)->first();
            $loginUser->bloodTypes()->datach($bloodType->id);
            $loginUser->bloodTypes()->attach($bloodType->id);
        }

        $data = [
            'user' => $request->user()->fresh()->load('bloodTypes','city')
        ];
        return responseJson(1,'تم تحديث البيانات',$data);

    }

    public function registerToken(Request $request)
    {
       $validation = validator()->make($request->all(),[
          'token' => 'required',
           'platform' => 'required|in:android,ios'
       ]);

       if ($validation->fails())
       {
          $data = $validation->errors();
          return responseJson(0,$validation->errors()->first(),$data);
       }
       Token::where('token',$request->token)->delete();
       $request->user()->tokens()->create($request->all());
       return responseJson(1,'تم التسجيل بنجاح');
    }

    public function removeToken(Request $request)
    {
        $validation = validator()->make($request->all(),[
            'token' => 'required',
        ]);

        if ($validation->fails())
        {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }
        Token::where('token',$request->token)->delete();
        return responseJson(1,'تم الحذف بنجاح');
    }

    public function notificationsSettings(Request $request)
    {

        $rules = [
            'governortes.*' => 'exists:governortes,id',
            'blood_types.*'  => 'exists:blood_types,id',
        ];
        // governorates == [1,5,13]
        // blood_types == [1,3]
        $validator = validator()->make($request->all(), $rules);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        if ($request->has('governortes')) {
            // $arr = [1,2];
            // sync (1,2,4,5,6)
            // 1,2,4,5,6
            $request->user()->governorates()->sync($request->governortes); // attach - detach() - toggle() - sync
        }
        if ($request->has('blood_types')) {
            $request->user()->bloodtypes()->sync($request->blood_types);
        }
        $data = [
            'governortes' => $request->user()->governorates()->pluck('governortes.id')->toArray(), // [1,3,4]
            // {name: asda , 'created' : asdasd , id: asdasd}
            // [1,5,13]
            'blood_types'  => $request->user()->bloodtypes()->pluck('blood_types.id')->toArray(),
        ];
        return responseJson(1, 'تم  التحديث', $data);
    }
}

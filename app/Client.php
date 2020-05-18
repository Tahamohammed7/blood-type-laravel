<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Client extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('phone', 'email', 'name', 'password', 'date_of_birth', 'blood_type_id', 'last_donation_date', 'city_id', 'pin_code', 'is_active', 'api_token');

//    public function setPasswordAttribute($value)
//    {
//       $this->attributes['password'] = bcrypt($value);
//    }

    public function bloodType()
    {
        return $this->belongsTo('App\BloodType');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function tokens()
    {
        return $this->hasMany('App\Token');
    }
    public function governorates()
    {
        return $this->belongsToMany('App\Governorate');
    }

    public function bloodtypes()
    {
        return $this->belongsToMany('App\BloodType');
    }

    public function donationRequests()
    {
        return $this->hasMany('App\DonationRequest');
    }

    public function notification()
    {
        return $this->belongsToMany('App\Notification');
    }

    public function favourites()
    {
        return $this->belongsToMany('App\Post');
    }

    protected $hidden = [
        'password', 'api_token',
    ];

}

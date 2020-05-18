<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class DonationRequest extends Model
{

    protected $table = 'donation_requests';
    public $timestamps = true;
    protected $fillable = array('patient_name', 'patient_phone', 'hospital_name', 'patient_age', 'bags_num', 'hospital_address', 'details', 'latitude', 'longitude', 'city_id', 'blood_type_id', 'client_id');

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function bloodType()
    {
        return $this->belongsTo('App\BloodType');
    }

    public function governorate()
    {
        return $this->belongsTo('App\Governorate');
    }

    public function notification()
    {
        return $this->hasOne('App\Notification');
    }

}

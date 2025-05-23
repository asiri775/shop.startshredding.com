<?php

namespace App;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Clients extends Authenticatable
{
    use Notifiable;
    public $table = "clients";
    protected $fillable = [
        'name', 'gender', 'balance', 'email', 'latitude', 'longitude', 'phone', 'password', 'fax','unit_no','buzz_code', 'address', 'instagram', 'facebook', 'city', 'zip', 'status','is_activated', 'created_at', 'updated_at', 'first_name',
        'last_name', 'Province_State', 'business_name', 'Country', 'client_type', 'zone_id', 'special_notes',
        'department','payment_method','TAX_GROUP','source','Account_Manager' ,'customer_type','status_stages','invoicing_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
    public function getReferrals()
    {
        return ReferralProgram::all()->map(function ($program) {
            return ReferralLink::getReferral($this, $program);
        });
    }

    public function bought_gift_cards()
    {
        return $this->hasMany('App\BoughtGiftCard', 'bought_by_id');
    }

    public function owned_gift_cards()
    {
        return $this->hasMany('App\BoughtGiftCard', 'current_owner_id');
    }

    public function redeemed_gift_cards()
    {
        return $this->hasMany('App\BoughtGiftCard', 'redeemed_by_id');
    }
}

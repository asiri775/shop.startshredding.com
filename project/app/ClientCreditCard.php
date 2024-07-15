<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientCreditCard extends Model
{
    protected $table = 'client_credit_cards';
    protected $fillable = ['id', 'client_id', 'card_holder_name', 'card_number', 'exp_month','exp_year','ccv', 'is_primary'];
    public $timestamps = true;
	
	public function client()
    {
        return $this->belongsTo(Clients::class);
    }

    public function maskNum()
    {
        return str_repeat('*', strlen(preg_replace('/\D/', '', $this->card_number)) - 4)
            .substr($this->card_number, -4);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agreement extends Model {
    protected $table = "agreements";

    protected $fillable = [
        'id',"name","is_default",'content',
        "created_at", "updated_at"
    ];

    public function agreementTermsAndConditions()
    {
        return $this->hasMany(AgreementTermsAndCondition::class, 'agreement_id');
    }
}

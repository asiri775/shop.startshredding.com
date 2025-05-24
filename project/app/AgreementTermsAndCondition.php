<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgreementTermsAndCondition extends Model {
    protected $table = "agreement_terms_and_condition";

    protected $fillable = [
        'id',"agreement_id","terms_and_condition_id" ,"is_active", "updated_at", "created_at"
    ];

    //Agreement ,TermsAndCondition
    public function agreement()
    {
        return $this->belongsTo(Agreement::class, 'agreement_id');
    }

    public function termsAndCondition()
    {
        return $this->belongsTo(TermsAndCondition::class, 'terms_and_condition_id');
    }



}

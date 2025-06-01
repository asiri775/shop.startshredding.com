<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TermsAndCondition extends Model {
    protected $table = "terms_and_conditions";

    protected $fillable = [
        'id',"name", "title", "categorie_id", "industry_id", "status", "created_at", "updated_at"
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload_document extends Model
{
    protected $table = 'upload_documents';
    protected $fillable = ['id', 'order_id', 'order_date', 'doc_type', 'file_name','file_path'];
    public $timestamps = true;
    use HasFactory;
}

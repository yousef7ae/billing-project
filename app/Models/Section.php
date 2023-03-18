<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [

        'section_name',
        'description',
        'Created_by'
    ];

    public function products(){

        return $this->hasMany('App\Models\Product');
    }

    public function invoices(){

        return $this->hasMany('App\Models\Invoice');
    }
}

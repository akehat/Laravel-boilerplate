<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Laravel\Passport\HasApiTokens;

class Campaigns extends Model
{
    // use HasFactory;use HasApiTokens,
    protected $fillable = [ 'cause_id','cause_name','cause_slug','subdomain','google_sheet_id','google_sheet_url','client_id'];
    protected $table    = 'campaigns';
  	public $primaryKey  = 'id';


     // public $timestamps = false;

     // protected $softDelete = false;

}

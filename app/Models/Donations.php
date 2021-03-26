<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Laravel\Passport\HasApiTokens;

class Donations extends Model
{
    // use HasFactory;use HasApiTokens,
    protected $fillable = [ 'cause_id','cause_name','cause_slug','subdomain','client_id','donor_first_name','donor_last_name','donor_full_name','donor_email','donor_phone','donor_street','donor_city','donor_state','donor_zip','status','captured','amount','currency','source','anonymous','additional_info','team','affiliate','converted_amount','converted_currency','fee','fee_currency','net','net_currency','charge_id','donor_dedication','created_at','donation_id','sheet_row','sheet_updated'];
    protected $table    = 'donations';
  	public $primaryKey  = 'id';


     // public $timestamps = false;

     // protected $softDelete = false;

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Settings extends Model
{
    // use HasFactory;use HasApiTokens,
    protected $fillable = [ 'key','value'];
    protected $table    = 'settings';
  	public $primaryKey  = 'id';


     // public $timestamps = false;

     // protected $softDelete = false;

}

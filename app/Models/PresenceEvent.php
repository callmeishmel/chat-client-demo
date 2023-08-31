<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresenceEvent extends Model
{
    use HasFactory;

    /**
    * Fields that are mass assignable
    *
    * @var array
    */
    protected $fillable = ['user_id','type'];
}

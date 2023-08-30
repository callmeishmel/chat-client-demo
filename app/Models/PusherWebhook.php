<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PusherWebhook2 extends Model
{
    use HasFactory;

    /**
    * Fields that are mass assignable
    *
    * @var array
    */
    protected $fillable = ['type','remote_address','post'];
}

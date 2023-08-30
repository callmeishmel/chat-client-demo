<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactNotification2 extends Model
{
    use HasFactory;

    /**
    * Fields that are mass assignable
    *
    * @var array
    */
    protected $fillable = ['customer_id', 'contact_id'];
}

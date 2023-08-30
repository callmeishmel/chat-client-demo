<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CannedMessage2 extends Model
{
    use HasFactory;

    /**
    * Fields that are mass assignable
    *
    * @var array
    */
    protected $fillable = ['message', 'type', 'possible_responses', 'created_by', 'updated_by'];
}

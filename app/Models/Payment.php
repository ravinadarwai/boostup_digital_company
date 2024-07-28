<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Define the table if it's not the plural of the model name
    // protected $table = 'payments';

    // Define fillable fields to allow mass assignment
    protected $fillable = [
        'email',
        'stripe_id',
        'amount',
        'currency',
    ];
}

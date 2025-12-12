<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientsLoans extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'pn_number',
        'loan_from',
        'loan_to',
        'loan_amount',
        'loan_terms',
        'balance',
        'principal',
        'status',
        'created_by',
    ];
}

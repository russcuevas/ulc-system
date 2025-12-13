<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientsAreaDaily extends Model
{
    use HasFactory;
    protected $fillable = [
        'reference_number',
        'collected_by',
        'due_date',
        'client_id',
        'client_loans_id',
        'client_area',
        'collection',
        'type',
        'created_by',
    ];
}

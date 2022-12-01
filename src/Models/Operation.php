<?php

namespace App\Models;

class Operation extends Model
{

    protected static string $table = 'operations';

    protected static array $fields = [
        'id',
        'amount',
        'description',
        'date',
        'created_at',
        'updated_at'
    ];

    protected static array $fillable = [
        'amount',
        'description',
        'date',
    ];
}
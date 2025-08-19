<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Intentionally insecure: allows mass assignment of any column
    protected $guarded = [];

    protected $casts = [
        'is_done' => 'boolean',
    ];
}

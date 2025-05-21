<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accounting extends Model
{
    protected $fillable = [
        'description',
        'type',
        'value',
        'date',
        'competence_month',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'date' => 'date',
        'competence_month' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

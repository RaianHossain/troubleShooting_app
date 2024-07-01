<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }

    public function bid()
    {
        return $this->belongsTo(Bid::class);
    }
}

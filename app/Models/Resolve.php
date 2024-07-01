<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resolve extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bid()
    {
        return $this->belongsTo(Bid::class);
    }

    public function winner()
    {
        return $this->belongsTo(Winner::class);
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }

    public function shipper()
    {
        return $this->belongsTo(User::class, 'shipper_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueResolve extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function winner()
    {
        return $this->belongsTo(Winner::class);
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resolve;
use App\Models\User;
use App\Models\Issue;

class ExtendRequest extends Model
{
    use HasFactory;
    protected $table = 'requests';
    protected $guarded = [];

    public function resolve()
    {
        return $this->belongsTo(Resolve::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }

}

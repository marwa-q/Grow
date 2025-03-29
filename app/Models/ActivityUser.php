<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityUser extends Model
{
    use HasFactory;

    protected $table = 'activity_user';  // Specify table name since it's a pivot table

    protected $fillable = [
        'user_id',
        'activity_id',
        'joined_at',
    ];

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}

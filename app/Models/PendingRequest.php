<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PendingRequest extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'uuid',
        'user_uuid',
        'request_type',
        'status',
        'admin_uuid',
        'review_admin_uuid',
    ];

    /**
     * Get the user that owns the pending request.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    /**
     * Get the admin that created the pending request.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_uuid', 'uuid');
    }

    /**
     * Get the admin that reviewed the pending request.
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'review_admin_uuid', 'uuid');
    }
}

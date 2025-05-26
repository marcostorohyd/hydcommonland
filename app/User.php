<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * Max file size in KB.
     *
     * @var string
     */
    const IMAGE_MAX_SIZE = 2000;

    /**
     * Allowed file types.
     *
     * @var string
     */
    const IMAGE_ALLOWED = '.jpg,.png,.jpeg';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'accept_lopd', 'accept_share', 'accept_advertising'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the demo cases studies for the user.
     */
    public function demoCaseStudies()
    {
        return $this->hasMany(DemoCaseStudy::class, 'created_by_id');
    }

    /**
     * Get the directory record associated with the user.
     */
    public function directory()
    {
        return $this->hasOne(\App\Directory::class);
    }

    /**
     * Get the events for the user.
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'created_by_id');
    }

    /**
     * Get the medialibraries for the user.
     */
    public function medialibraries()
    {
        return $this->hasMany(MediaLibrary::class, 'created_by_id');
    }

    /**
     * Get the news for the user.
     */
    public function news()
    {
        return $this->hasMany(News::class, 'created_by_id');
    }

    /**
     * Scope a query to only include admin users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAdmin($query)
    {
        return $query->where('is_admin', 1);
    }

    /**
     * Check if the user is admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return ! empty($this->is_admin);
    }

    /**
     * Check if the user is approved.
     *
     * @return bool
     */
    public function isApproved()
    {
        return ! empty($this->approved_at);
    }
}

<?php

namespace Ladmin\Engine\Models;

use Ladmin\Engine\LadminAccount;
use Ladmin\Engine\LadminLoggable;
use Ladmin\Engine\UuidGenerator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, LadminAccount, UuidGenerator, LadminLoggable;

    /**
     * Table name
     */
    protected $table = 'ladmin_accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'online_at',
        'state',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes datetime.
     *
     * @var array<string, string>
     */
    protected $dates = [
        'online_at',
        'email_verified_at',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
     */
    protected static function newFactory()
    {
        return \Ladmin\Engine\Factories\AdminFactory::new();
    }
}

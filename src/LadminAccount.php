<?php

namespace Ladmin\Engine;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Ladmin\Engine\Models\LadminLoggable;
use Ladmin\Engine\Models\LadminRole;
use Ladmin\Engine\Notifications\ResetPasswordNotification;

trait LadminAccount
{

    protected $fillableExceptActivity = [
        'remember_token',
        'online_at',
    ];

    /**
     * Multiple role
     *
     * @return \Ladmin\Engine\Models\LadminRole
     */
    public function roles()
    {
        return $this->belongsToMany(LadminRole::class, 'ladmin_role_user', 'user_id', 'role_id', 'id', 'id');
    }


    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token, $this->email));
    }

    /**
     * User activities
     *
     * @return \Ladmin\Engine\Models\LadminLoggable
     */
    public function activities()
    {
        return $this->hasMany(LadminLoggable::class, 'user_id', 'id');
    }

    public function permissions(): Attribute
    {
        return new Attribute(
            get: fn () => $this->getGates()
        );
    }

    /**
     * gravatar
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function gravatar(): Attribute
    {
        return new Attribute(
            get: fn () => 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email))) . '&s=250',
        );
    }

    /**
     * Call gets
     *
     * @return array
     */
    protected function getGates()
    {
        $gates = [];
        foreach ($this->roles as $role) {
            if ($role->gates) {
                foreach ($role->gates as $gate) {
                    $gates[] = $gate;
                }
            }
        }
        return $gates;
    }

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'ladmin.notification.' . $this->id;
    }
}

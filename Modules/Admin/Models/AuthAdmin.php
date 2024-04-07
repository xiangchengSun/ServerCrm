<?php

namespace Modules\Admin\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class AuthAdmin extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $guard = 'auth_admin';

    protected $table = 'auth_admin';

    protected $hidden = ['password'];

    /**
     * @description jwt表示
     *
     * @return void
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @description jwt自定义声明。
     *
     * @return void
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}

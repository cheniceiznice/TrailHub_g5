<?php 

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;  // <-- Add this line
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    // ...

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    
    // Relation to user OAuth tokens
    public function oauthTokens()
    {
        return $this->hasMany(UserOauthToken::class);
    }

    public function oauthTokenFor($provider)
    {
        return $this->oauthTokens()->where('provider', $provider)->first();
    }
}

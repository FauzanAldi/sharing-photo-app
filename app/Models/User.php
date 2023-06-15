<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    use Notifiable;

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Validasi Login
    public function actionlogin($username, $password): array
    {
        return $this->attemptlogin($username, $password);
    }

    protected function attemptlogin($email, $password): array
    {   

        $credentials = [
            'email' => $email,
            'password' => $password 
        ];

        if (!$token = auth()->guard('api')->setTTL(config('jwt.ttl'))->attempt($credentials)) {
            return [];
        }

        $refresh_token = auth()->guard('refresh_token')->setTTL(config('jwt.ttl_refresh_token'))->attempt($credentials);

        return [
            'access_token' => $token,
            'refresh_token' => $refresh_token,
        ];
    }

    public function action_refresh_token($refresh_token): array
    {

        $user = auth()->guard('refresh_token')->setToken($refresh_token)->user();

        $token = auth()->tokenById($user->id);

        $refresh_token = auth()->guard('refresh_token')->refresh();

        return [
            'access_token' => $token,
            'refresh_token' => $refresh_token,
            'user' => $user
        ];
    }

}

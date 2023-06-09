<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    protected $table = 'Users';

    use HasApiTokens, HasFactory, Notifiable;

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected $fillable = [
        'name',
        'email',
        'passwordHash',
        'createdAt',
        'updatedAt',
        'cpf',
        'perfil',
        'profile',
        'id_wallet',
        'id_wallet_lider',
        'codigo'

    ];

    protected $hidden = [
        'passwordHash',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'updatedAt' => 'datetime',
        'createdAt' => 'datetime',
    ];

    public function getAuthPassword(){
        return $this->passwordHash;
    }

    public function getUpdatedAt(){
        return $this->updatedAt;
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }

}

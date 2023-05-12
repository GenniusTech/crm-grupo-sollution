<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmList extends Model
{
    use HasFactory;

    protected $table = 'crm_lista';

    protected $fillable = [
        'titulo',
        'dataInicial',
        'dataFinal',
        'status',
      
    ];

    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

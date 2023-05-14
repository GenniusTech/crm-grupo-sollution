<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmSales extends Model
{
    use HasFactory;

    protected $table = 'crm_sales';

    protected $fillable = [
        'id_user',
        'cpfcnpj',
        'cliente',
        'situacao',
        'dataNascimento',
        'email',
        'telefone',
        'id_lista',
        'link_pay',
        'id_pay',
        'status',
        'file'
      
    ];

    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function crmList()
    {
        return $this->belongsTo(CrmList::class, 'id_lista');
    }

    public function list()
    {
        return $this->belongsTo(CrmList::class, 'id_lista');
    }

    public function scopeUser($query, $userId)
    {
        return $query->where('id_user', $userId);
    }

    public function scopeListStatus($query, $status)
    {
        return $query->whereHas('list', function($query) use ($status) {
            $query->where('status', $status);
        });
    }
}

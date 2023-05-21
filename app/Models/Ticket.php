<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'Tickets';

    protected $fillable = [
        'status',
        'lastMessage',
        'contactId',
        'userId',
        'createdAt',
        'whatsappId',
        'isGroup',
        'unreadMessages',
        'queueId',

    ];

    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}

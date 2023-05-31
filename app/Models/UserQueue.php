<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserQueue extends Model
{
    protected $table = 'UserQueues';
    protected $fillable = ['userId', 'queueId', 'createdAt', 'updatedAt'];

    public $timestamps = false;

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
}



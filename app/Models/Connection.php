<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    protected $fillable = ['sender_id', 'receiver_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function friends()
    {
        return $this->hasMany(Connection::class, 'sender_id')
        ->where('status', 'accepte')
        ->orWhere('receiver_id', $this->id);
    }
}

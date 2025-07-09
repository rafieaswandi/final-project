<?php

// app/Models/Registration.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 'event_id', 'registration_date', 'status'
    ];
    
    protected $dates = [
        'registration_date'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
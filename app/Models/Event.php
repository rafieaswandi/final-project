<?php

// app/Models/Event.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title', 'description', 'location', 'date', 'time', 'price', 'capacity'
    ];
    
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
    
    public function getRegisteredCountAttribute()
    {
        return $this->registrations->where('status', 'confirmed')->count();
    }
    
    public function getRemainingCapacityAttribute()
    {
        if (!$this->capacity) {
            return null; // Unlimited capacity
        }
        
        return $this->capacity - $this->registered_count;
    }
}

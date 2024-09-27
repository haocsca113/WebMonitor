<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttackDetected extends Model
{
    use HasFactory;
    protected $table = 'attacks_detected';
    protected $fillable = ['user_id', 'website_id', 'attack_type', 'detected_at', 'details'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UptimeCheck extends Model
{
    use HasFactory;
    protected $table = 'uptime_checks';
    protected $fillable = ['url', 'status', 'response_time'];
}

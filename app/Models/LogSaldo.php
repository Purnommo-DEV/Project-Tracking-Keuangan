<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogSaldo extends Model
{
    use HasFactory;

    protected $table = "log_saldo";
    protected $guarded = ['id'];
}

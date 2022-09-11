<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoiTac extends Model
{
    use HasFactory;
    protected $table="doitac";
    public $timestamp = false;
}

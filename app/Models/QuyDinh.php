<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\HoaDon;
use App\Models\NhanVien;

class QuyDinh extends Model
{
    use HasFactory;
    protected $table="quydinh";
    public $timestamp = false;
    public function hoaDon($value="")
    {
        return $this->hasMany(HoaDon::class, "regulationId", "id");
    }
    public function nhanVien($value='') {
        return $this->belongsTo(NhanVien::class, 'createdBy', 'id');
    }
}

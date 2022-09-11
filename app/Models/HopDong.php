<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NhanVien;
use App\Models\ThongTinCanHo;

class HopDong extends Model
{
    use HasFactory;
    protected $table="hopdong";
    protected $fillable = ['path', 'date', 'apartmentNo', 'createdBy'];
    public $timestamp = false;
    public function thongTinCanHo($value ="")
    {
        return $this->belongsTo(ThongTinCanHo::class, "apartmentNo", "id");
    }
    public function nhanVien($value='') {
        return $this->belongsTo(NhanVien::class, 'createdBy', 'id');
    }
}

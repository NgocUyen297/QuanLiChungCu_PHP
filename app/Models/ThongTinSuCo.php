<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NhanVien;
use App\Models\ThongTinCanHo;

class ThongTinSuCo extends Model
{
    use HasFactory;
    protected $table="thongtinsuco";
    protected $fillable = ['description', 'date', 'apartmentNo', 'createdBy', 'ThongTinCanHoid'];
    public $timestamp = false;
    public function thongTinCanHo($value ="")
    {
        return $this->belongsTo(ThongTinCanHo::class, "apartmentNo", "id");
    }
    public function nhanVien($value='')
    {
        return $this->belongsTo(NhanVien::class, "createdBy", "id");
    }
    
}

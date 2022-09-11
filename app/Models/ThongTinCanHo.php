<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ThongTinSuCo;
use App\Models\HopDong;
use App\Models\ThongTinHo;
use App\Models\NhanVien;

class ThongTinCanHo extends Model
{
    use HasFactory;
    protected $table="ThongTinCanHo";
    public $timestamp = false;
    protected $fillable = ['description', 'rooms', 'upstairs', 'restroom', 'inArea', 'createdBy'];
    public function hopDong($value ="")
    {
        return $this->belongsTo(HopDong::class, "apartmentNo", "id");
    }
    public function thongTinHo($value ="")
    {
        return $this->hasOne(ThongTinHo::class, "apartmentNo", "id");
    }
    public function ThongTinSuCo($value ="")
    {
        return $this->hasMany(ThongTinSuCo::class, "apartmentNo", "id");
    }
    public function NhanVien($value ="")
    {
        return $this->belongsTo(NhanVien::class, "createdBy", "id");
    }
}

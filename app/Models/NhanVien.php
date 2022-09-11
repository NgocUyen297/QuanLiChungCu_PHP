<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\HopDong;
use App\Models\HoaDon;
use App\Models\ThongTinSuCo;
use App\Models\ThongTinCanHo;
use App\Models\ThongTinHo;

class NhanVien extends Model
{
    use HasFactory;
    public $table = 'nhanvien';
    public function hopDong($value='') {
        return $this->hasMany(HopDong::class, 'createdBy', 'id');
    }
    public function hoaDon($value='') {
        return $this->hasMany(HoaDon::class, 'createdBy', 'id');
    }
    public function ThongTinCanHo($value="") {
        return $this->hasMany(ThongTinCanHo::class, 'createdBy', 'id');
    }
    public function thongTinHo($value='') {
        return $this->hasMany(ThongTinHo::class, 'createdBy', 'id');
    }
    public function ThongTinSuCo($value="") {
        return $this->hasMany(ThongTinSuCo::class, 'createdBy', 'id');
    }
    public function quyDinh($value='') {
        return $this->hasMany(QuyDinh::class, 'createdBy', 'id');
    }
}

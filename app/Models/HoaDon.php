<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DoiTac;
use App\Models\ThongTinHo;
use App\Models\QuyDinh;
use App\Models\NhanVien;
use App\Models\ThongTinHoaDon;
use App\Models\ThongTinSuCo;

class HoaDon extends Model
{
    use HasFactory;
    protected $table="hoadon";
    public $timestamp = false;
    public $fillable = ['description', 'createdDate', 'path', 'moneyIn', 'createdBy', 'regulationId', 'whoPay', 'errors'];
    public function quyDinh($value='') {
        return $this->belongsTo(QuyDinh::class, 'regulationId', 'id');
    }
    public function nhanVien($value='') {
        return $this->belongsTo(NhanVien::class, 'createdBy', 'id');
    }
    public function thongTinHoaDon() {
        return $this->hasOne(ThongTinHoaDon::class, 'linkId', 'id');
    }
}

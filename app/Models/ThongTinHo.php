<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NhanVien;
use App\Models\NhanKhau;
use App\Models\ThongTinCanHo;

class ThongTinHo extends Model
{
    use HasFactory;
    protected $table="thongtinho";
    public $fillable = ['ownerFirstName', 'ownerLastname', 'apartmentNo', 'ownerIdentityNumber', 'ownerPhoneNumber'];
    public $timestamp = false;
    public function nhanKhau($value ="")
    {
        return $this->hasMany(NhanKhau::class, "ownerIndex", "id");
    }
    public function thongTinCanHo($value ="")
    {
        return $this->belongsTo(ThongTinCanHo::class, "apartmentNo", "id");
    }
    public function nhanVien($value='') {
        return $this->belongsTo(NhanVien::class, 'createdBy', 'id');
    }
}

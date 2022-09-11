<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ThongTinHo;

class NhanKhau extends Model
{
    use HasFactory;
    protected $table = "nhankhau";
    public $timestamp = false;
    protected $fillable = ['firstname', 'lastname', 'identityNumber', 'ownerIndex'];
    public function thongTinHo($value ="")
    {
        return $this->belongsTo(ThongTinHo::class, "ownerIndex", "id");
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\HoaDon;

class ThongTinHoaDon extends Model
{
    use HasFactory;
    public $table = 'thongtinhoadon';
    protected $timestamp = false;
    public $fillable = ['electricity', 'water', 'internet', 'error', 'paid'];
    public function hoaDon($value='') {
        return $this->belongsTo(HoaDon::class, 'linkId', 'id');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HoaDon;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\HomeController;
class HoaDonController extends Controller
{
    public function Index(){
        $hoaDon = HoaDon::all();
        return view('hoadon', compact('hoaDon'));
    }
}

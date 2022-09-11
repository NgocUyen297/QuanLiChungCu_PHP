<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Redirect;
use App\Exceptions\Handler;
use Illuminate\Support\Facades\DB;

use App\Models\HopDong;
use App\Models\ThongTinCanHo;
use App\Models\ThongTinHoaDon;
use App\Models\NhanKhau;
use App\Models\ThongTinHo;
use App\Models\ThongTinSuCo;
use App\Models\HoaDon;
use App\Models\DoiTac;
use App\Models\QuyDinh;
use DateTime;
use Exception;
use PhpParser\NodeVisitor\FirstFindingVisitor;

use function PHPUnit\Framework\isEmpty;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $url = action('HomeController@index');
        $param = $request->query('tab-selection');
        $tabSelection = $param ? $param : 1;
        $table_results = [];
        $listSelect = [];
        $alert = [];
        $contentSearch = "";
        $extensions = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tableName = $request->get('table-name');
            $contentSearch = $request->get('search-bar');
            $tabSelection = $request->get('tab-selection');

            if ($contentSearch != "") {
                switch ($tableName) {
                    case "hopdong":
                        $table_results = HopDong::where('id', $contentSearch)->get();
                        $listSelect = ThongTinCanHo::all();
                        break;
                    case "thongtincanho":
                        $table_results = ThongTinCanHo::where('id', $contentSearch)->get();
                        break;
                    case "nhankhau":
                        $table_results = NhanKhau::where('id', $contentSearch)->orWhere('identityNumber', $contentSearch)
                            ->orWhere('lastname', 'LIKE', '%'.$contentSearch.'%')->get();
                        $listSelect = ThongTinHo::all();
                        break;
                    case "thongtinsuco":
                        $table_results = ThongTinSuCo::where('id', $contentSearch)->get();
                        $listSelect = ThongTinCanHo::whereIn('id', HopDong::get('apartmentNo'))->get();
                        break;
                    case "hoadon_kh":
                        $table_results = HoaDon::where('moneyIn', '1')->where('id', $contentSearch)->get();
                        break;
                    case "hoadon_dt":
                        $table_results = HoaDon::where('moneyIn', '0')->where('id', $contentSearch)->get();
                        $listSelect = DoiTac::all();
                        break;
                }
            }
            else {
                if (auth()->user()->Role == 'Manager') {
                    if ($tabSelection == 2) {
                        $table_results = HopDong::all();
                        $listSelect = $this->CheckEmptyApartment();
                        $extensions = ThongTinCanHo::all();
                    }
                    else if ($tabSelection == 3) {
                        $table_results = ThongTinCanHo::all();
                        $listSelect = ThongTinHo::all();
                        $alert = $this->CheckEmptyApartment();
                    }
                    else if ($tabSelection == 4) {
                        $table_results = NhanKhau::all();
                        $listSelect = ThongTinHo::all();
                        $alert = NhanKhau::whereNull('identityNumber')->get();
                    }
                    else if ($tabSelection == 5) {
                        $table_results = ThongTinSuCo::all();
                        $listSelect = ThongTinCanHo::whereIn('id', HopDong::get('apartmentNo'))->get();
                    }
                }
                else {
                    if ($tabSelection == 3) {
                        $table_results = HoaDon::where('moneyIn', '1')->get();
                        $listSelect = ThongTinHo::all();
                        $alert = DB::table('thongtinhoadon')->join('hoadon', function ($join) {
                            $join->on('thongtinhoadon.linkId', '=', 'hoadon.id');
                        })->where('paid', 0)->where('moneyIn', 1)
                        ->get();
                    }
                    else if ($tabSelection == 4) {
                        $table_results = HoaDon::where('moneyIn', '0')->get();
                        $listSelect = DoiTac::all();
                        $alert = DB::table('thongtinhoadon')->join('hoadon', function ($join) {
                            $join->on('thongtinhoadon.linkId', '=', 'hoadon.id');
                        })->where('paid', 0)->where('moneyIn', 0)
                        ->get();
                    }
                }
            }
        }
        else {
            if (empty($param)) {
                return redirect() -> action(
                    [HomeController::class, 'index'], ['tab-selection' => 1]
                );
            }
            if (auth()->user()->Role == 'Manager') {
                if ($tabSelection == 2) {
                    $table_results = HopDong::all();
                    $listSelect = $this->CheckEmptyApartment();
                    $extensions = ThongTinCanHo::all();
                }
                else if ($tabSelection == 3) {
                    $table_results = ThongTinCanHo::all();
                    $alert = $this->CheckEmptyApartment();
                }
                else if ($tabSelection == 4) {
                    $table_results = NhanKhau::all();
                    $listSelect = ThongTinHo::all();
                    $alert = NhanKhau::whereNull('identityNumber')->get();
                    $extensions = ThongTinHo::all();
                }
                else if ($tabSelection == 5) {
                    $table_results = ThongTinSuCo::all();
                    $listSelect = ThongTinCanHo::whereIn('id', HopDong::get('apartmentNo'))->get();
                    $alert = $this->CheckReportPaidAndDone();
                }
            }
            else {
                if ($tabSelection == 3) {
                    $table_results = HoaDon::where('moneyIn', '1')->get();
                    $listSelect = ThongTinHo::all();
                    $alert = DB::table('thongtinhoadon')->join('hoadon', function ($join) {
                        $join->on('thongtinhoadon.linkId', '=', 'hoadon.id');
                    })->where('paid', 0)->where('moneyIn', 1)
                    ->get();
                }
                else if ($tabSelection == 4) {
                    $table_results = HoaDon::where('moneyIn', '0')->get();
                    $listSelect = DoiTac::all();
                    $alert = DB::table('thongtinhoadon')->join('hoadon', function ($join) {
                        $join->on('thongtinhoadon.linkId', '=', 'hoadon.id');
                    })->where('paid', 0)->where('moneyIn', 0)
                    ->get();
                }
            }
        }

        //for task box

        $missedIndividualCount = 0;
        $tongCacCanHo= 0;
        $soCanHoKhongTrong= 0;
        $reportCount  = 0;
        $demNhanKhau = 0;
        $debtBill = 0;
        $CustomerBillCount = 0;
        $partnetBillCount = 0;
        $totalElectricity = 0;
        $totalWater = 0;
        // Missed Individual
        $nhankhau = NhanKhau::all();
        foreach($nhankhau as $nk)
        {
            if($nk->identityNumber == null or $nk->lastname == "" or $nk->firstname =="")
            {
                $missedIndividualCount++;
                $demNhanKhau++;
            }
        }
        //Empty
        $CanHo = ThongTinCanHo::all();
        $CanHoKhongTrong = DB::table('thongtincanho')
        ->join('hopdong', function ($join) {
            $join->on('thongtincanho.id', '=', 'hopdong.apartmentNo');
        })
        ->get();
        foreach($CanHo as $a)
        {
            $tongCacCanHo++;
        }
        foreach($CanHoKhongTrong as $b)
        {
            $soCanHoKhongTrong++;
        }
        $empty = $tongCacCanHo - $soCanHoKhongTrong;
       //Report so cac su co chua duoc xu ly
        $suCo = $this->CheckReportPaidAndDone();
        foreach ($suCo as $suCoChild) {
                $reportCount++;
        }

        // debt bills
        $hoaDon = HoaDon::all();
        foreach($hoaDon as $h)
        {
            if($h->thongTinHoaDon->paid == 0)
            {
                $debtBill++;
            }
        }


        //customer bills
        $hoaDonDienNuoc = DB::table('hoadon')->where('moneyIn', '>', 0)
        ->join('thongtinhoadon', function ($join) {
            $join->on('hoadon.id', '=', 'thongtinhoadon.linkId');
        })
        ->get();
        foreach($hoaDonDienNuoc as $hddn)
        {
            if($hddn->paid==null)
            {
                $CustomerBillCount++;
            }
            $totalElectricity += $hddn->electricity;
            $totalWater += $hddn->water;

        }
        //partner bills
        $hoaDonDoiTac = DB::table('hoadon')->where('moneyIn', '=', 0)
        ->join('thongtinhoadon', function ($join) {
            $join->on('hoadon.id', '=', 'thongtinhoadon.linkId');
        })
        ->get();
        foreach($hoaDonDoiTac as $hddt)
        {
            if($hddt->paid==null)
            {
                $partnetBillCount++;
            }
        }

        return view('home', compact('table_results', 'tabSelection', 'contentSearch', 'listSelect', 'extensions', 'alert', 'empty', 'missedIndividualCount','reportCount', 'tongCacCanHo','demNhanKhau','debtBill','CustomerBillCount','partnetBillCount'));
    }

    public function update(Request $request) {
        $tableName =  $request->json('table');
        $value = array();
        $count = 0;
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        while (true) {
            $val = $request->json('val' . str($count));
            if ($val == "") {
                break;
            }
            $count += 1;
            if ($val == 'null') {
                array_push($value, '');
                continue;
            }
            array_push($value, $val);
        }
        $out->writeln($tableName);
        foreach ($value as $vl) {
            $out->writeln($vl);
        }

        switch ($tableName) {
            case "hopdong":
                $hopdong = HopDong::where('id', $value[0])->first();
                $out->writeln($hopdong);
                try {
                    $hopdong->timestamps = false;
                    $hopdong->save();
                    $hopdong->update(array(
                        "path" => $value[1],
                        "date" => $value[2],
                        "apartmentNo" => $value[3],
                        "createdBy" => auth()->user()->id
                    ));

                    $thongtinho = ThongTinHo::where('ownerIdentityNumber', $value[5])->orWhere('apartmentNo', $value[3])->first();
                    $thongtinho->timestamps = false;
                    $thongtinho->save();
                    $name = [];
                    $this->FirstAndLastName($value[4], $name);
                    $thongtinho->update(array(
                        "ownerFirstName" => $name['firstname'],
                        "ownerLastName" => $name['lastname'],
                        'ownerIdentityNumber' => $value[5],
                        "apartmentNo" => $value[3]
                    ));
                } catch (\Exception $ex) {
                    $out->writeln($ex->getMessage());
                    return response()->json([
                        'status' => 'failed'
                    ], 500);
                }
                $out->writeln($hopdong);
                
                return response()->json([
                    'status' => 'success'
                ], 200);
                break;
            case "thongtincanho":
                $thongtincanho = ThongTinCanHo::where('id', $value[0])->first();
                $out->writeln($thongtincanho);
                try {
                    $thongtincanho->timestamps = false;
                    $thongtincanho->save();
                    $thongtincanho->update(array(
                        "description" => $value[1],
                        "rooms" => $value[2],
                        "upstairs" => $value[3],
                        "restroom" => $value[4],
                        "inArea" => $value[5],
                        "createdBy" => auth()->user()->id
                    ));
                } catch (\Exception $ex) {
                    $out->writeln($ex->getMessage());
                    return response()->json([
                        'status' => 'failed'
                    ], 500);
                }
                $out->writeln($thongtincanho);
                
                return response()->json([
                    'status' => 'success'
                ], 200);
                break;
            case "nhankhau":
                $nhankhau =NhanKhau::where('id', $value[0])->first();
                $out->writeln($nhankhau);
                try {
                    $nhankhau->timestamps = false;
                    $nhankhau->save();
                    $name = [];
                    $this->FirstAndLastName($value[1], $name);
                    $nhankhau->update(array(
                        "firstname" => $name['firstname'],
                        "lastname" => $name['lastname'],
                        "identityNumber" => $value[2],
                        "ownerIndex" => $value[3]
                    ));
                } catch (\Exception $ex) {
                    $out->writeln($ex->getMessage());
                    return response()->json([
                        'status' => 'failed'
                    ], 500);
                }
                $out->writeln($nhankhau);
                return response()->json([
                    'status' => 'success'
                ], 200);
                break;
            case 'thongtinsuco':
                $ttSuCo = ThongTinSuCo::where('id', $value[0])->first();
                $out->writeln($ttSuCo);
                try {
                    $ttSuCo->timestamps = false;
                    $ttSuCo->save();
                    $name = []; 
                    $ttSuCo->update(array(
                        "description" => $value[1],
                        "date" => $value[2],
                        "apartmentNo" => $value[3],
                        "createdBy" => auth()->user()->id
                    ));
                } catch (\Exception $ex) {
                    $out->writeln($ex->getMessage());
                    return response()->json([
                        'status' => 'failed'
                    ], 500);
                }
                $out->writeln($ttSuCo);
                return response()->json([
                    'status' => 'success'
                ], 200);
                break;
            case 'hoadon_kh': case 'hoadon_dt':
                $hoadon = HoaDon::where('id', $value[0])->first();
                $out->writeln($hoadon);
                try {
                    $hoadon->timestamps = false;
                    $hoadon->save();
                    $hoadon->update(array(
                        "description" => $value[1],
                        "createdDate" => $value[2],
                        "whoPay" => $value[3],
                        "createdBy" => auth()->user()->id
                    ));

                    $tthoadon = ThongTinHoaDon::where('linkId', $value[0])->first();
                    $tthoadon->timestamps=false;
                    $tthoadon->save();
                    $tthoadon->update(array(
                        "electricity" => $value[5] > 0 ? $value[5] : null,
                        "water" => $value[6] > 0 ? $value[6] : null,
                        'internet' => $value[7] > 0 ? $value[7] : null,
                        'error' => $value[8] > 0 ? $value[8] : null,
                        'paid' => $value[10] == 1 ? $value[10] : 0
                    ));
                } catch (\Exception $ex) {
                    $out->writeln($ex->getMessage());
                    return response()->json([
                        'status' => 'failed'
                    ], 500);
                }
                $out->writeln($hoadon);
                return response()->json([
                    'status' => 'success'
                ], 200);
                break;
        }

        return response()->json([
            'status' => 'failed'
        ], 500);
    }

    public function delete(Request $request) {
        $tableName =  $request->json('table');
        $value = array();
        $count = 0;
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        while (true) {
            $val = $request->json('val' . str($count));
            if ($val == "") {
                break;
            }
            $count += 1;
            if ($val == 'null') {
                array_push($value, '');
                continue;
            }
            array_push($value, $val);
        }
        $out->writeln($tableName);
        foreach ($value as $vl) {
            $out->writeln($vl);
        }
        switch ($tableName) {
            case 'hopdong':
                $hopdong = HopDong::where('id', $value[0])->first();
                try {
                    $hopdong->delete();
                } catch (\Exception $ex) {
                    $out->writeln($ex->getMessage());
                    return response()->json([
                        'status' => 'failed'
                    ], 500);
                }
                return response()->json([
                    'status' => 'success'
                ], 200);
                break;
            case 'thongtincanho':
                $thongtincanho = ThongTinCanHo::where('id', $value[0])->first();
                try {
                    $thongtincanho->delete();
                } catch (\Exception $ex) {
                    $out->writeln($ex->getMessage());
                    return response()->json([
                        'status' => 'failed'
                    ], 500);
                }
                return response()->json([
                    'status' => 'success'
                ], 200);
                break;
            case 'nhankhau':
                $nhankhau = NhanKhau::where('id', $value[0])->first();
                try {
                    $nhankhau->delete();
                } catch (\Exception $ex) {
                    $out->writeln($ex->getMessage());
                    return response()->json([
                        'status' => 'failed'
                    ], 500);
                }
                return response()->json([
                    'status' => 'success'
                ], 200);
                break;
            case 'thongtinsuco':
                break;
            case 'hoadon_kh': case "hoadon_dt":
                $hoadon = HoaDon::where('id', $value[0])->first();
                $tthoadon = ThongTinHoaDon::where('linkId', $value[0])->first();
                try {
                    $tthoadon->delete();
                    $hoadon->delete();
                } catch (\Exception $ex) {
                    $out->writeln($ex->getMessage());
                    return response()->json([
                        'status' => 'failed'
                    ], 500);
                }
                return response()->json([
                    'status' => 'success'
                ], 200);
                break;
        }
        return response()->json([
            'status' => 'failed'
        ], 500);
    }

    public function add(Request $request) {
        $tableName =  $request->json('table');
        $value = array();
        $count = 0;
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        while (true) {
            $val = $request->json('val' . str($count));
            if ($val == "") {
                break;
            }
            $count += 1;
            if ($val == 'null') {
                array_push($value, '');
                continue;
            }
            array_push($value, $val);
        }
        $out->writeln($tableName);
        foreach ($value as $vl) {
            $out->writeln($vl);
        }
        switch ($tableName) {
            case 'hopdong':
                try {
                    $hopdong = new HopDong();
                    $hopdong->timestamps = false;
                    $hopdong->path = $value[1];
                    $hopdong->date = $value[2] == "" ? date_create()->format('Y-m-d H:i:s') : $value[2];
                    $hopdong->apartmentNo = $value[3];
                    $hopdong->createdBy = auth()->user()->id;
                    $hopdong->save();

                    $name = [];
                    $this->FirstAndLastName($value[4], $name);
                    $thongtinho = new ThongTinHo();
                    $thongtinho->timestamps = false;
                    $thongtinho->apartmentNo = $value[3];
                    $thongtinho->ownerFirstName = $name['firstname'];
                    $thongtinho->ownerLastName = $name['lastname'];
                    $thongtinho->ownerIdentityNumber = $value[5];
                    $thongtinho->createdBy = auth()->user()->id;
                    $thongtinho->save();
                } catch (\Exception $ex) {
                    $out->writeln($ex->getMessage());
                    return response()->json([
                        'status' => 'failed'
                    ], 500);
                }
                return response()->json([
                    'status' => 'success'
                ], 200);
                break;
            case 'thongtincanho':
                try {
                    $canho = new ThongTinCanHo();
                    $canho->timestamps = false;
                    $canho->description = $value[1];
                    $canho->rooms = $value[2];
                    $canho->upstairs = $value[3];
                    $canho->restroom = $value[4];
                    $canho->inArea = $value[5];
                    $canho->createdBy = auth()->user()->id;
                    $canho->save();
                } catch (\Exception $ex) {
                    $out->writeln($ex->getMessage());
                }
                return response()->json([
                    'status' => 'success'
                ], 200);
                break;
            case 'nhankhau':
                $name = [];
                $this->FirstAndLastName($value[1], $name);
                try {
                    if ($value[3] != 9999) {
                        $nhankhau = new NhanKhau();
                        $nhankhau->timestamps = false;
                        $nhankhau->firstname = $name['firstname'];
                        $nhankhau->lastname = $name['lastname'];
                        $nhankhau->identityNumber = $value[2] ? $value[2] : null;
                        $nhankhau->ownerIndex = $value[3];
                        $nhankhau->save();
                    }
                    else {
                        $thongtinho = new ThongTinHo();
                        $thongtinho->firstname = $name['firstname'];
                        $thongtinho->lastname = $name['lastname'];
                        $thongtinho->identityNumber = $value[2] ? $value[2] : null;
                        $thongtinho->apartmentNo = 1;   //truy nha so nao

                    }
                } catch (\Exception $ex) {
                    $out->writeln($ex->getMessage());
                }
                return response()->json([
                    'status' => 'success'
                ], 200);
                break;
            case 'thongtinsuco':
                try {
                    $suco = new ThongTinSuCo();
                    $suco->timestamps = false;
                    $suco->description = $value[1];
                    $suco->date = $value[2] == "" ? NULL : $value[2];
                    $suco->apartmentNo = $value[3];
                    $suco->createdBy = auth()->user()->id;
                    $suco->save();  

                    // add bills for errors
                    $suCo = ThongTinSuCo::orderBy('id', 'desc')->first();
                    $hoadonSuCo = new HoaDon();
                    $hoadonSuCo->timestamps = false;
                    $hoadonSuCo->description = "Hóa đơn cho sự cố có ID: " . $suCo->id;
                    $hoadonSuCo->createdDate = date_create()->format('Y-m-d H:i:s');
                    $hoadonSuCo->path = "/bill/example.pdf";
                    $hoadonSuCo->moneyIn = 1;
                    $hoadonSuCo->createdBy = auth()->user()->id;
                    $hoadonSuCo->whoPay = ThongTinHo::where('apartmentNo', $value[3])->first()->id;
                    $hoadonSuCo->errors = $suCo->id;
                    $hoadonSuCo->save();

                    //bill details with paid column false
                    $bill = HoaDon::where('errors', $suCo->id)->first();
                    $tthoadonSuCo = new ThongTinHoaDon();
                    $tthoadonSuCo->timestamps = false;
                    $tthoadonSuCo->electricity = null;
                    $tthoadonSuCo->water = null;
                    $tthoadonSuCo->internet = null;
                    $tthoadonSuCo->paid = 0;
                    $tthoadonSuCo->linkId = $bill->id;
                    $tthoadonSuCo->save();

                } catch (\Exception $ex) {
                    $out->writeln($ex->getMessage());
                    return response()->json([
                        'status' => 'failed'
                    ], 500);
                }

                return response()->json([
                    'status' => 'success'
                ], 200);
                break;
            case 'hoadon_kh':
                try {
                    $hoadon = new HoaDon();
                    $hoadon->timestamps = false;
                    $hoadon->description = $value[1];
                    $hoadon->createdDate = $value[2] ? $value[2] : date_create()->format('Y-m-d H:i:s');
                    $hoadon->moneyIn = '1';
                    $hoadon->regulationId = QuyDinh::orderBy('id', 'desc')->first()->id;
                    $hoadon->whoPay = $value[3];
                    $hoadon->createdBy = auth()->user()->id;
                    $hoadon->save();

                    $tthoadon = new ThongTinHoaDon();
                    $tthoadon->timestamps = false;
                    $tthoadon->electricity = $value[5] > 0 ? $value[5] : null;
                    $tthoadon->water = $value[6] > 0 ? $value[6] : null;
                    $tthoadon->internet = $value[7] > 0 ? $value[7] : null;
                    $tthoadon->error = $value[8] > 0 ? $value[8] : null;
                    $tthoadon->paid = 0;
                    $tthoadon->linkId = HoaDon::orderBy('id', 'desc')->first()->id;
                    $tthoadon->save();
                } catch (\Exception $ex) {
                    $out->writeln($ex->getMessage());
                }
                return response()->json([
                    'status' => 'success'
                ], 200);
                break;
            case 'hoadon_dt':
                try {
                    $hoadon = new HoaDon();
                    $hoadon->timestamps = false;
                    $hoadon->description = $value[1];
                    $hoadon->createdDate = $value[2] ? $value[2] : date_create()->format('Y-m-d H:i:s');
                    $hoadon->moneyIn = '0';
                    $hoadon->whoPay = $value[3];
                    $hoadon->createdBy = auth()->user()->id;
                    $hoadon->save();

                    $tthoadon = new ThongTinHoaDon();
                    $tthoadon->timestamps = false;
                    $tthoadon->electricity = $value[5] ? $value[5] : null;
                    $tthoadon->water = $value[6] ? $value[6] : null;
                    $tthoadon->internet = $value[7] ? $value[7] : null;
                    $tthoadon->error = $value[8] ? $value[8] : null;
                    $tthoadon->paid = 0;
                    $tthoadon->linkId = HoaDon::orderBy('id', 'desc')->first()->id;
                    $tthoadon->save();
                } catch (\Exception $ex) {
                    $out->writeln($ex->getMessage());
                }
                return response()->json([
                    'status' => 'success'
                ], 200);
                break;
        }
        return response()->json([
            'status' => 'failed'
        ], 500);
    }

    function FirstAndLastName(string $str, &$array) {   //Nguyen Van An
        trim($str, " ");
        $processed_list = explode(" ", $str);
        $firstname = $processed_list[count($processed_list) - 1];
        $lastname = "";
        for ($count = 0; $count < count($processed_list) - 1; $count++) {
            $lastname .= $processed_list[$count];
            if ($count != count($processed_list) - 2) {
                $lastname .= " ";
            }
        }
        $array = array(
            'firstname'=> $firstname,
            'lastname' => $lastname
        );

    }

    function CheckReportPaidAndDone() {
        $paidBills = HoaDon::whereNotNull('errors')->join('thongtinhoadon', 'thongtinhoadon.linkId', '=', 'hoadon.id')->where('paid', 1)->get();
        $paidBillIndexes = [];
        foreach ($paidBills as $p) {
            array_push($paidBillIndexes, $p->errors);
        }
        if (count($paidBillIndexes) > 1)
            $DoneReports = ThongTinSuCo::whereIn('id', $paidBillIndexes)->whereNotNull('date')->get();
        else
            $DoneReports = ThongTinSuCo::where('id', $paidBillIndexes)->whereNotNull('date')->get();
        $Donerpts = [];
        foreach ($DoneReports as $rp) {
            array_push($Donerpts, $rp->id);
        }
        return ThongTinSuCo::whereNotIn('id', $Donerpts)->get();
    }

    function CheckEmptyApartment() {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $hopdong = HopDong::all();
        $filledApartment = [];
        foreach ($hopdong as $item) {
            array_push($filledApartment, $item->apartmentNo);
        }
        $out->writeln($hopdong);
        return ThongTinCanHo::whereNotIn('id', $filledApartment)->get();
    }
}

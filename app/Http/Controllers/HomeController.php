<?php

namespace App\Http\Controllers;

use App\TKB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use App\Imports\TKBImport;
use Maatwebsite\Excel\Facades\Excel;
use function MongoDB\BSON\toJSON;

class HomeController extends Controller
{
    public function index(){
        $tkb =  null;
        Session::forget("msv");
        Session::forget("error");
        $number1 = 5;
        $number2 = null;
        $number3 = $number1/$number2;

        return view('index', compact('tkb', 'number3'));
    }

    public function xemTKB(Request $request){
        $tkb = TKB::where("msv", $request->msv)->first();
        Session::put("msv", $request->msv);
        if (!$tkb){
            Session::put("error", "Không tìm thấy dữ liệu, hãy tải file thời khóa biểu lên website trước.");

            return view('index', compact('tkb'));
        }

        Session::forget("error");

        return view('index', compact('tkb'));
    }

    public function timetable(Request $request){
        $tkb = TKB::where("msv", $request->msv)->first();
        if ($tkb){
            $tkb['tkb'] = json_decode(($tkb['tkb']));

            return response($tkb, Response::HTTP_OK);
        }

        return response("Không tìm thấy dữ liệu, hãy tải file thời khóa biểu lên website trước.", Response::HTTP_OK);
    }

    public function upload(){
        return view('upload');
    }

    public function uploadTKB(Request $request){
        try {
            $file_path = $request->file('file');
            $rows = Excel::toArray(new TKBImport, $file_path);

            $tkb = ([
                'ho_ten' => null,
                'msv' => null,
                'lop' => null,
                'hoc_ky' => null,
                'tkb' => collect([])
            ]);

            $i = 0;
            foreach ($rows[0] as $key => $row){
                if ($key == 3){
                    if ($row[0] == null)
                        die("Thời khóa biểu không đúng định dạng");
                    $tkb['hoc_ky'] = $row[0];
                }
                else if($key == 5){
                    if ($row[2] == null || $row[5] == null)
                        die("Thời khóa biểu không đúng định dạng");
                    $tkb['ho_ten'] = $row[2];
                    $tkb['msv'] = $row[5];
                }
                else if($key == 6){
                    if ($row[2] == null)
                        die("Thời khóa biểu không đúng định dạng");
                    $tkb['lop'] = $row[2];
                }
                else if ($key >= 10){
                    if ($row[0] != null){
                        $thoi_gian = explode('-', $row[10]);
                        switch ($row[0]) {
                            case "2":
                                $thu = 2;
                                break;
                            case "3":
                                $thu = 3;
                                break;
                            case "4":
                                $thu = 4;
                                break;
                            case "5":
                                $thu = 5;
                                break;
                            case "6":
                                $thu = 6;
                                break;
                            case "7":
                                $thu = 7;
                                break;
                            case "CN":
                                $thu = 8;
                                break;
                            default:
                                $thu = 8;
                        }

                        $batdau = Carbon::createFromFormat("d/m/Y", $thoi_gian[0])->format("d-m-Y");
                        $ketthuc = Carbon::createFromFormat("d/m/Y", $thoi_gian[1])->format("d-m-Y");

                        $ngay = Carbon::createFromFormat("d/m/Y", $thoi_gian[0])->addDays($thu - 2)->format("d-m-Y");
                        $tiet = explode(',', $row[8]);

                        //loai bo khoang trang
                        $string = htmlentities($row[6], null, 'utf-8');
                        $content = str_replace("&nbsp;", "", $string);
                        $content = html_entity_decode($content);

                        $data = [
                            'thu' => strval($thu),
                            'batdau' => $batdau,
                            'ketthuc' => $ketthuc,
                            'tiet' => $row[8],
                            'mon' => $row[4],
                            'diadiem' => $row[9],
                            'giangvien' => $row[7],
                            'row' => $key + 1,
                            'ngay' => $ngay,
                            'tietx' => $tiet[0],
                            'meet' => $content,
                        ];

                        $tkb['tkb'][$i] = $data;
                        $i++;
                        $ngay = Carbon::createFromFormat('d-m-Y', $tkb['tkb'][$i - 1]['ngay'])->addDays(7);
                        while ( strtotime($ngay) <= strtotime($ketthuc) ) {
                            $data = [
                                'thu' => $tkb['tkb'][$i - 1]['thu'],
                                'batdau' => $tkb['tkb'][$i - 1]['batdau'],
                                'ketthuc' => $tkb['tkb'][$i - 1]['ketthuc'],
                                'tiet' => $tkb['tkb'][$i - 1]['tiet'],
                                'mon' => $tkb['tkb'][$i - 1]['mon'],
                                'diadiem' => $tkb['tkb'][$i - 1]['diadiem'],
                                'giangvien' => $tkb['tkb'][$i - 1]['giangvien'],
                                'row' => $tkb['tkb'][$i - 1]['row'],
                                'ngay' => $ngay->format('d-m-Y'),
                                'tietx' => $tkb['tkb'][$i - 1]['tietx'],
                                'meet' => $tkb['tkb'][$i - 1]['meet'],
                            ];

                            $tkb['tkb'][$i] = $data;
                            $i++;
                            $ngay->addDays(7);
                        }
                    }
                    else{
                        break;
                    }
                }
            }

            $sv = TKB::where("msv", $tkb['msv'])->first();
            if ($sv){
                $sv->tkb = $tkb['tkb'];
            }
            else{
                $sv = new TKB();
                $sv->ho_ten = $tkb['ho_ten'];
                $sv->msv = $tkb['msv'];
                $sv->lop = $tkb['lop'];
                $sv->hoc_ky = $tkb['hoc_ky'];
                $sv->tkb = $tkb['tkb'];
            }
            $sv->save();

            return redirect()->back()->with("success", "Tải lên tkb thành công");
        }
        catch (\Exception $exception){
            die("Thời khóa biểu không đúng định dạng");
        }
    }
}

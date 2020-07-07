<?php

namespace App\Http\Controllers;

use App\pay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class payController extends Controller
{
    //
    public function getRevenuesPay()
    {
        if (Session::has('key')) {
            $query = DB::table("pay");
            if (Session::get('roleID') == "ad") {
                $query->join('club', 'pay.clubID', '=', 'club.clubID')
                    ->join('coach', 'club.manager', '=', 'coach.coachID')
                    ->join('class', 'pay.classID', '=', 'class.classID')
                    ->select('*')->get();
                $club = DB::table("club")->select("*")->get();
            } else {
                $query->join('club', 'pay.clubID', '=', 'club.clubID')
                    ->join('coach', 'club.manager', '=', 'coach.coachID')
                    ->join('class', 'pay.classID', '=', 'class.classID')
                    ->where('club.manager', '=', Session::get('coachID'))
                    ->select('*')->get();
                $club = DB::table("club")->where('club.manager', '=', Session::get('coachID'))->select("*")->get();
            }
            $query = $query->orderBy("payID", "Desc");
            $query = $query->select("*");
            $data = pay::paginate(8);
            $data = $query->paginate(8);
            $dataclub = $club;
            return view('admin.revenues_pay', ['data' => $data, 'dataclub' => $dataclub]);
        } else {
            return view('admin.login');
        }
    }

    //Thêm pay
    public function postRevenuesPayAdd(Request $request)
    {
        if (Session::has('key')) {
            $this->validate(
                $request,
                [
                    'payID' => 'required',
                    'description' => 'required',
                    'intoMoney' => 'required',
                    'month' => 'required',
                    'date' => 'required',
                ],
                [
                    'payID.required' => 'Pay ID is not null',
                    'description.required' => 'Description is not null',
                    'intoMoney.required' => 'Into Money is not null',
                    'month.required' => 'Month is not null',
                    'date.required' => 'Date is not null',
                ]
            );
            $pay = new pay();
            $pay->payID = $request->payID;
            $pay->clubID = $request->clubID;
            $pay->classID = $request->classID;
            $pay->description = $request->description;
            $pay->intoMoney = $request->intoMoney;
            $pay->month = $request->month;
            $pay->datePay = $request->date;
            $pay->payaccount = Session::get('coachID');
            $pay->save();

            return redirect('revenues_pay_add')->with('thongbao', 'Them thanh cong');
        } else {
            return view('admin.login');
        }
    }
    public function getRevenuesPayAdd()
    {
        if (Session::has('key')) {
            $queryclub = DB::table('club');
            $queryclub->where('club.manager', '=', Session::get('coachID'));
            $dataclub = $queryclub->get();
            $queryclass = DB::table('club');
            $queryclass->join('class', 'club.clubID', '=', 'class.clubID')->where('club.manager', '=', Session::get('coachID'));
            $dataclass = $queryclass->get();
            return view('admin.revenues_pay_add', ['dataclub' => $dataclub, 'dataclass' => $dataclass]);
        } else {
            return view('admin.login');
        }
    }

    //Sửa pay
    public function postRevenuesPayEdit(Request $request, $id)
    {
        if (Session::has('key')) {
            $pay = pay::find($id);
            $this->validate(
                $request,
                [
                    'payID' => 'required',
                    'description' => 'required',
                    'intoMoney' => 'required',
                    'month' => 'required',
                    'date' => 'required',
                ],
                [
                    'payID.required' => 'Pay ID is not null',
                    'description.required' => 'Description is not null',
                    'intoMoney.required' => 'Into Money is not null',
                    'month.required' => 'Month is not null',
                    'date.required' => 'Date is not null',
                ]
            );
            $pay->payID = $request->payID;
            $pay->clubID = $request->clubID;
            $pay->classID = $request->classID;
            $pay->description = $request->description;
            $pay->intoMoney = $request->intoMoney;
            $pay->month = $request->month;
            $pay->datePay = $request->date;
            $pay->payaccount = Session::get('coachID');
            $pay->save();

            return redirect('revenues_pay');
        } else {
            return view('admin.login');
        }
    }
    public function getRevenuesPayEdit($id)
    {
        if (Session::has('key')) {
            $pay = pay::find($id);
            $queryclub = DB::table('club');
            $queryclub->where('club.manager', '=', Session::get('coachID'));
            $dataclub = $queryclub->get();
            $queryclass = DB::table('club');
            $queryclass->join('class', 'club.clubID', '=', 'class.clubID')->where('club.manager', '=', Session::get('coachID'));
            $dataclass = $queryclass->get();
            return view('admin.revenues_pay_edit', ['pay' => $pay, 'id' => $id, 'dataclub' => $dataclub, 'dataclass' => $dataclass]);
        } else {
            return view('admin.login');
        }
    }

    //Xóa pay
    public function getRevenuesPayDelete(Request $request)
    {
        $id = $request->payID;
        if (Session::has('key')) {
            $pay = pay::find($id);
            $pay->delete();
            return redirect('revenues_pay');
        } else {
            return view('admin.login');
        }
    }

    public function getRevenuesPayHistory()
    {
        if (Session::has('key')) {
            $query = DB::table("pay");
            $query->join('club', 'pay.clubID', '=', 'club.clubID')
                ->join('class', 'pay.classID', '=', 'class.classID')
                ->where('club.manager', '=', Session::get('coachID'))
                ->select('*')->get();
            $query = $query->orderBy("payID", "Desc");
            $query = $query->select("*");
            $data = $query->paginate(100);
            return view('admin.revenues_pay_history', ['data' => $data]);
        } else {
            return view('admin.login');
        }
    }

    //Mo ta chi tiet ND chi
    public function getPopup(Request $request)
    {
        if (Session::has('key')) {
            $id = $request->payID;
            $query = DB::select('SELECT * FROM pay WHERE payID=?', [$id]);
            $data = array();
            foreach ($query as $row) {
                $data[] = $row;
            }
            return json_encode($data);
        } else {
            return view('admin.login');
        }
    }

    //Tim kiem ND chi
    public function getSearch(Request $request)
    {
        if (Session::has('key')) {
            $payName = $request->value;
            if ($request->ajax()) {
                $output = '';
                if (Session::get('roleID') == 'ad') {
                    $pay = DB::table('pay')->join('club', 'pay.clubID', '=', 'club.clubID')
                        ->join('coach', 'club.manager', '=', 'coach.coachID')
                        ->join('class', 'pay.classID', '=', 'class.classID')
                        ->where('pay.payID', 'like', '%' . $payName . '%')
                        ->get();
                } else {
                    $pay = DB::table('pay')->join('club', 'pay.clubID', '=', 'club.clubID')
                        ->join('coach', 'club.manager', '=', 'coach.coachID')
                        ->join('class', 'pay.classID', '=', 'class.classID')
                        ->where('pay.payID', 'like', '%' . $payName . '%')
                        ->where('pay.payaccount', '=', Session::get('coachID'))
                        ->get();
                }
                if ($pay) {
                    $count = 1;
                    if (Session::get('roleID') == 'ad') {
                        foreach ($pay as $key => $pay) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td>' . $pay->payID . '</td>
                    <td>' . $pay->clubName . '</td>
                    <td>' . $pay->className . '</td>
                    <td>' . $pay->datePay . '</td>
                    <td>' . $pay->month . '</td>
                    <td>' . $pay->intoMoney . '</td>
                    <td> 
                    <i class="fas fa-info-circle" data-toggle="modal" data-target=".bs-example-modal-lg" onclick="showDes(\'' . $pay->payID . '\')"></i>
                    </td>
                    </tr>';
                            $count++;
                        }
                    } else {
                        foreach ($pay as $key => $pay) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td>' . $pay->payID . '</td>
                    <td>' . $pay->clubName . '</td>
                    <td>' . $pay->className . '</td>
                    <td>' . $pay->datePay . '</td>
                    <td>' . $pay->month . '</td>
                    <td>' . $pay->intoMoney . '</td>
                    <td> 
                    <i class="fas fa-info-circle" data-toggle="modal" data-target=".bs-example-modal-lg" onclick="showDes(\'' . $pay->payID . '\')"></i>
                    &emsp;<i class="far fa-edit" onclick="location.href=\'revenues_pay_edit/' . $pay->payID . '\'"></i>
                    &emsp;<i class="far fa-trash-alt" onclick="location.href=\'revenues_pay/' . $pay->payID . '\'"></i>
                    </td>
                    </tr>';
                            $count++;
                        }
                    }
                }
                return Response($output);
            }
        } else {
            return view('admin.login');
        }
    }

    //Export ND chi
    public function exportPay()
    {
        if (Session::has('key')) {
            return view("admin.exportPay");
        } else {
            return view("admin.login");
        }
    }
    public function getexportPay()
    {
        if (Session::has('key')) {
            if (Session::get('roleID') == 'ad') {
                $query = DB::select('SELECT * FROM (club cl INNER JOIN  pay p ON p.clubID=cl.clubID) INNER JOIN class c ON p.classID=c.classID');
            } else {
                $query = DB::select('SELECT * FROM (club cl INNER JOIN  pay p ON p.clubID=cl.clubID) INNER JOIN class c ON p.classID=c.classID WHERE cl.manager=\'' . Session::get('coachID') . '\'');
            }
            $data = array();
            foreach ($query as $row) {
                $data[] = $row;
            }
            echo json_encode($data);
        } else {
            return view('admin.login');
        }
    }

    //Loc ND chi
    public function getFilterPay(Request $request)
    {
        if (Session::has('key')) {
            $payName = $request->value;
            if ($request->ajax()) {
                $output = '';
                if (Session::get('roleID') == 'ad') {
                    $pay = DB::table('pay')->join('club', 'pay.clubID', '=', 'club.clubID')
                        ->join('coach', 'club.manager', '=', 'coach.coachID')
                        ->join('class', 'pay.classID', '=', 'class.classID')
                        ->where('club.clubID', 'like', '%' . $payName . '%')->get();
                } else {
                    $pay = DB::table('pay')->join('club', 'pay.clubID', '=', 'club.clubID')
                        ->join('coach', 'club.manager', '=', 'coach.coachID')
                        ->join('class', 'pay.classID', '=', 'class.classID')
                        ->where('club.clubID', 'like', '%' . $payName . '%')
                        ->where('revaccount', '=', Session::get('coachID'))->get();;
                }
                if ($pay) {
                    $count = 1;
                    if (Session::get('roleID') == 'ad') {
                        foreach ($pay as $key => $pay) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td>' . $pay->payID . '</td>
                    <td>' . $pay->clubName . '</td>
                    <td>' . $pay->className . '</td>
                    <td>' . $pay->className . '</td>
                    <td>' . $pay->datePay . '</td>
                    <td>' . $pay->month . '</td>
                    <td>' . $pay->intoMoney . '</td>
                    <td>
                    <i class="fas fa-info-circle" onclick="showDes(\'' . $pay->payID . '\')" data-toggle="modal" data-target=".bs-example-modal-lg"></i>
                    </td>
                    </tr>';
                            $count++;
                        }
                    } else {
                        foreach ($pay as $key => $pay) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td>' . $pay->payID . '</td>
                    <td>' . $pay->clubName . '</td>
                    <td>' . $pay->className . '</td>
                    <td>' . $pay->datePay . '</td>
                    <td>' . $pay->month . '</td>
                    <td>' . $pay->intoMoney . '</td>
                    <td>
                    <i class="fas fa-info-circle" onclick="showDes(\'' . $pay->payID . '\')" data-toggle="modal" data-target=".bs-example-modal-lg"></i>
                    &emsp;<i class="far fa-edit" onclick="location.href=\'revenues_pay_edit/' . $pay->payID . '\'"></i>
                    &emsp;<i class="far fa-trash-alt" onclick="location.href=\'revenues_pay/' . $pay->payID . '\'"></i>
                    </td>
                    </tr>';
                            $count++;
                        }
                    }
                }
                return Response($output);
            }
        } else {
            return view('admin.login');
        }
    }

    public function checkpayID(Request $request)
    {
        $payID =  $request->payID;

        $data = DB::table('pay')->where('payID','=',$payID)->get();
        echo $data;

    }
}

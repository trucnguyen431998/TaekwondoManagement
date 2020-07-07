<?php

namespace App\Http\Controllers;

use App\revenues;
use App\receipt;
use App\Http\Controllers\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class revenuesController extends Controller
{
    //
    //Gọi trang Revenues
    public function getRevenues()
    {
        if (Session::has('key')) {
            return view('admin.revenues');
        } else {
            return view('admin.login');
        }
    }

    public function getRevenuesCol()
    {
        if (Session::has('key')) {
            $query = DB::table("revenues");

            // if (Session::get('roleID') == "ad") {
            //     $query->join('club', 'revenues.clubID', '=', 'club.clubID')
            //         ->join('class', 'class.clubID', '=', 'club.clubID')
            //         ->join('coach', 'club.manager', '=', 'coach.coachID')
            //         ->select('*')->get();
            //     $club = DB::table("club")->select("*")->get();
            // } else {
            //     $query->join('club', 'revenues.clubID', '=', 'club.clubID')
            //         ->join('coach', 'club.manager', '=', 'coach.coachID')
            //         ->join('class', 'class.clubID', '=', 'club.clubID')
            //         ->where('club.manager', '=', Session::get('coachID'))
            //         ->select('*')->get();
            //     $club = DB::table("club")->where('club.manager', '=', Session::get('coachID'))->select("*")->get();
            // }
            if (Session::get('roleID') == 'ad') {
                $query = DB::select('SELECT * FROM (club cl INNER JOIN  revenues rev ON rev.clubID=cl.clubID) INNER JOIN class c ON rev.classID=c.classID');
                $club = DB::table("club")->select("*")->get();
            } else {
                $query = DB::select('SELECT * FROM (club cl INNER JOIN  revenues rev ON rev.clubID=cl.clubID) INNER JOIN class c ON rev.classID=c.classID WHERE cl.manager=\'' . Session::get('coachID') . '\'');
                $club = DB::table("club")->where('club.manager', '=', Session::get('coachID'))->select("*")->get();
            }
            // $query = $query->orderBy("revID", "Desc");
            // $query = $query->select("*");

            // $data = revenues::paginate(8);
            // $data = $query->paginate(8);

            $dataclub = $club;
            return view('admin.revenues_col', ['data' => $query, 'dataclub' => $dataclub]);
        } else {
            return view('admin.login');
        }
    }

    //Thêm revenues
    public function postRevenuesColAdd(Request $request)
    {
        if (Session::has('key')) {

            $this->validate(
                $request,
                [
                    'revID' => 'required',
                    'revName' => 'required',
                    'intoMoney' => 'required',
                    'month' => 'required',
                    // 'note' => 'required',
                ],
                [
                    'revID.required' => 'Revenues ID is not null',
                    'revName.required' => 'Revenues name is not null',
                    'intoMoney.required' => 'Into Money is not null',
                    'month.required' => 'Month is not null',
                    // 'note.required' => 'Note is not null',
                ]
            );
            $revenues = new revenues();
            $revenues->revID = $request->revID;
            $revenues->revName = $request->revName;
            $revenues->intoMoney = $request->intoMoney;
            $revenues->month = $request->month;
            $revenues->note = $request->note;
            $revenues->clubID = $request->clubID;
            $revenues->classID = $request->classID;
            $revenues->revaccount = Session::get('coachID');
            $revenues->save();

            return redirect('revenues_col_add')->with('thongbao', 'Them thanh cong');
        } else {
            return view('admin.login');
        }
    }
    public function getRevenuesColAdd()
    {
        if (Session::has('key')) {
            $queryclub = DB::table('club');
            $queryclub->where('club.manager', '=', Session::get('coachID'));
            $dataclub = $queryclub->get();
            $queryclass = DB::table('club');
            $queryclass->join('class', 'club.clubID', '=', 'class.clubID')->where('club.manager', '=', Session::get('coachID'));
            $dataclass = $queryclass->get();
            return view('admin.revenues_col_add', ['dataclub' => $dataclub, 'dataclass' => $dataclass]);
        } else {
            return view('admin.login');
        }
    }

    //Sửa revenues
    public function postRevenuesColEdit(Request $request, $id)
    {
        if (Session::has('key')) {
            $revenues = revenues::find($id);
            $this->validate(
                $request,
                [
                    'revID' => 'required',
                    'revName' => 'required',
                    'intoMoney' => 'required',
                    'month' => 'required',
                    'note' => 'required',
                ],
                [
                    'revID.required' => 'Revenues ID is not null',
                    'revName.required' => 'Revenues name is not null',
                    'intoMoney.required' => 'Into Money is not null',
                    'month.required' => 'Month is not null',
                    'note.required' => 'Note is not null',
                ]
            );
            $revenues->revID = $request->revID;
            $revenues->revName = $request->revName;
            $revenues->intoMoney = $request->intoMoney;
            $revenues->month = $request->month;
            $revenues->note = $request->note;
            $revenues->clubID = $request->clubID;
            $revenues->classID = $request->classID;
            $revenues->revaccount = Session::get('coachID');
            $revenues->save();

            return redirect('revenues_col');
        } else {
            return view('admin.login');
        }
    }
    public function getRevenuesColEdit($id)
    {
        if (Session::has('key')) {
            $revenues = revenues::find($id);
            $queryclub = DB::table('club');
            $queryclub->where('club.manager', '=', Session::get('coachID'));
            $dataclub = $queryclub->get();
            $queryclass = DB::table('club');
            $queryclass->join('class', 'club.clubID', '=', 'class.clubID')->where('club.manager', '=', Session::get('coachID'));
            $dataclass = $queryclass->get();
            return view('admin.revenues_col_edit', ['revenues' => $revenues, 'id' => $id, 'dataclub' => $dataclub, 'dataclass' => $dataclass]);
        } else {
            return view('admin.login');
        }
    }

    //Xóa revenues
    public function getRevenuesColDelete(Request $request)
    {
        $id = $request->revID;
        if (Session::has('key')) {
            $revenues = revenues::find($id);
            $revenues->delete();
            return redirect('revenues_col');
        } else {
            return view('admin.login');
        }
    }

    //Hien thi DS VS da dong tien
    public function getRevenuesColListcom($id)
    {
        if (Session::has('key')) {
            $query = DB::table("receipt");
            $query->join('martial', 'receipt.maID', '=', 'martial.maID')
                ->join('class', 'martial.classID', '=', 'class.classID')
                ->where('revID', '=', $id)->select('*')->get();
            $count = $query->count();
            $data = receipt::paginate(10);
            $data = $query->paginate(10);
            $revID = $id;
            return view('admin.revenues_col_listcom', ['data' => $data, 'count' => $count, 'revID' => $revID]);
        } else {
            return view('admin.login');
        }
    }
    //Hien thi DS VS chua dong tien
    public function getRevenuesColListincom($idrev, $idclub)
    {
        if (Session::has('key')) {
            $query = DB::select('SELECT * 
                             FROM martial m INNER JOIN class c ON m.classID=c.classID 
                             WHERE NOT EXISTS (SELECT receipt.maID 
                                                FROM receipt INNER JOIN revenues ON receipt.revID=revenues.revID 
                                                WHERE receipt.maID=m.maID AND receipt.revID="' . $idrev . '")
                             AND c.clubID="' . $idclub . '"');
            $data = receipt::paginate(10);
            //$data = $query->paginate(10);
            $data = $query;
            $revID = $idrev;
            $clubID = $idclub;
            return view('admin.revenues_col_listincom', ['data' => $data, 'revID' => $revID, 'clubID' => $clubID]);
        } else {
            return view('admin.login');
        }
    }

    //Lap bien lai
    public function getRevenuesColRecipt(Request $request)
    {
        if (Session::has('key')) {
            $receipt = new receipt();
            $receipt->recID = $request->revID . $request->maID;
            $receipt->maID = $request->maID;
            $receipt->revID = $request->revID;
            $receipt->account = $request->coachID;
            $receipt->save();
            $this->getRevenuesColListincom($request->revID, $request->clubID);
        } else {
            return view('admin.login');
        }
    }

    //Xoa bien lai
    public function getRevenuesColReciptDelete(Request $request)
    {
        if (Session::has('key')) {
            $receipt = receipt::find($request->recID);
            $receipt->delete();
        } else {
            return view('admin.login');
        }
    }

    //Lich su revenues
    public function getRevenuesColHistory()
    {
        if (Session::has('key')) {
            if (Session::has('key')) {
                $query = DB::table("revenues");
                $query->join('coach', 'revenues.revaccount', '=', 'coach.coachID')
                    ->join('club', 'revenues.clubID', '=', 'club.clubID')
                    ->where('club.manager', '=', Session::get('coachID'))
                    ->select('*')->get();
                $query = $query->orderBy("revID", "Desc");
                $query = $query->select("*");
                $data = $query->paginate(100);
                return view('admin.revenues_col_history', ['data' => $data]);
            } else {
                return view('admin.login');
            }
        } else {
            return view('admin.login');
        }
    }

    //Bieu do muc thu
    public function getChart01()
    {
        if (Session::has('key')) {
            $queryChart = DB::select("SELECT rev.month, COUNT(rec.revID)*150000 AS 'intoMoneys' FROM receipt rec INNER JOIN revenues rev ON rec.revID=rev.revID GROUP BY rev.month");
            $data = array();
            //Chuyen thanh json
            foreach ($queryChart as $row) {
                $data[] = $row;
            }
            return json_encode($data);
        } else {
            return view('admin.login');
        }
    }
    //Bieu do muc chi
    public function getChart02()
    {
        if (Session::has('key')) {
            $queryChart = DB::select("SELECT p.month, SUM(p.intoMoney) AS 'intoMoneys' FROM pay p GROUP BY p.month");

            $data = array();
            //Chuyen thanh json
            foreach ($queryChart as $row) {
                $data[] = $row;
            }
            return json_encode($data);
        } else {
            return view('admin.login');
        }
    }

    //Tim kiem ND thu
    public function getSearch(Request $request)
    {
        if (Session::has('key')) {
            $revName = $request->value;
            if ($request->ajax()) {
                $output = '';
                if (Session::get('roleID') == 'ad') {
                    $revenues = DB::table('revenues')->join('club', 'revenues.clubID', '=', 'club.clubID')
                        ->join('class', 'class.clubID', '=', 'club.clubID')
                        ->join('coach', 'club.manager', '=', 'coach.coachID')
                        ->where('revName', 'like', '%' . $revName . '%')->get();
                } else {
                    $revenues = DB::table('revenues')->join('club', 'revenues.clubID', '=', 'club.clubID')
                        ->join('class', 'class.clubID', '=', 'club.clubID')
                        ->join('coach', 'club.manager', '=', 'coach.coachID')
                        ->where('revName', 'like', '%' . $revName . '%')
                        ->where('club.manager', '=', Session::get('coachID'))->get();;
                }
                if ($revenues) {
                    $count = 1;
                    if (Session::get('roleID') == 'ad') {
                        foreach ($revenues as $key => $revenues) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td>' . $revenues->revID . '</td>
                    <td>' . $revenues->revName . '</td>
                    <td>' . $revenues->month . '</td>
                    <td>' . $revenues->clubName . '</td>
                    <td>' . $revenues->className . '</td>
                    <td>' . $revenues->intoMoney . '</td>
                    <td><i class="far fa-smile-beam" onclick="location.href=\'revenues_col_listcom/' . $revenues->revID . '\'"></i></td>
                    <td><i class="far fa-sad-tear" onclick="location.href=\'revenues_col_listincom/' . $revenues->revID . '/' . $revenues->clubID . '\'"></i></td>
                    </tr>';
                            $count++;
                        }
                    } else {
                        foreach ($revenues as $key => $revenues) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td>' . $revenues->revID . '</td>
                    <td>' . $revenues->revName . '</td>
                    <td>' . $revenues->month . '</td>
                    <td>' . $revenues->clubName . '</td>
                    <td>' . $revenues->className . '</td>
                    <td>' . $revenues->intoMoney . '</td>
                    <td><i class="far fa-smile-beam" onclick="location.href=\'revenues_col_listcom/' . $revenues->revID . '\'"></i></td>
                    <td><i class="far fa-sad-tear" onclick="location.href=\'revenues_col_listincom/' . $revenues->revID . '/' . $revenues->clubID . '\'"></i></td>
                    <td>
                    &emsp;<i class="far fa-edit" onclick="location.href=\'revenues_col_edit/' . $revenues->revID . '\'"></i>
                    &emsp;<i class="far fa-trash-alt" onclick="location.href=\'revenues_col/' . $revenues->revID . '\'"></i>
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

    //Tim kiem vo sinh da dong HP
    public function getSearchList(Request $request)
    {
        if (Session::has('key')) {
            $maName = $request->value;
            if ($request->ajax()) {
                $output = '';
                if (Session::get('roleID') == 'ad') {
                    $receipt = DB::table('receipt')->join('martial', 'receipt.maID', '=', 'martial.maID')
                        ->join('class', 'martial.classID', '=', 'class.classID')
                        ->where('receipt.revID', '=', $request->revID)
                        ->where('martial.maName', 'like', '%' . $maName . '%')->get();
                } else {
                    $receipt = DB::table('receipt')->join('martial', 'receipt.maID', '=', 'martial.maID')
                        ->join('class', 'martial.classID', '=', 'class.classID')
                        ->join('club', 'class.clubID', '=', 'club.clubID')
                        ->where('receipt.revID', '=', $request->revID)
                        ->where('martial.maName', 'like', '%' . $maName . '%')
                        ->where('club.manager', '=', Session::get('coachID'))->get();
                }
                if ($receipt) {
                    $count = 1;
                    if (Session::get('roleID') == 'ad') {
                        foreach ($receipt as $key => $receipt) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td>' . $receipt->maID . '</td>
                    <td>' . $receipt->maName . '</td>
                    <td>' . $receipt->maDOB . '</td>
                    <td>' . $receipt->className . '</td>
                    </tr>';
                            $count++;
                        }
                    } else {
                        foreach ($receipt as $key => $receipt) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td>' . $receipt->maID . '</td>
                    <td>' . $receipt->maName . '</td>
                    <td>' . $receipt->maDOB . '</td>
                    <td>' . $receipt->className . '</td>
                    <td>
                    &emsp;<i class="far fa-trash-alt" onclick="deleteCom(\'' . $receipt->recID . '\')"></i>
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

    //Loc ND thu
    public function getFilterRev(Request $request)
    {
        if (Session::has('key')) {
            $revName = $request->value;
            if ($request->ajax()) {
                $output = '';
                if (Session::get('roleID') == 'ad') {
                    $revenues = DB::table('revenues')->join('club', 'revenues.clubID', '=', 'club.clubID')
                        ->join('class', 'class.clubID', '=', 'club.clubID')
                        ->join('coach', 'club.manager', '=', 'coach.coachID')
                        ->where('club.clubID', 'like', '%' . $revName . '%')->get();
                } else {
                    $revenues = DB::table('revenues')->join('club', 'revenues.clubID', '=', 'club.clubID')
                        ->join('class', 'class.clubID', '=', 'club.clubID')
                        ->join('coach', 'club.manager', '=', 'coach.coachID')
                        ->where('club.clubID', 'like', '%' . $revName . '%')
                        ->where('revaccount', '=', Session::get('coachID'))->get();;
                }
                if ($revenues) {
                    $count = 1;
                    if (Session::get('roleID') == 'ad') {
                        foreach ($revenues as $key => $revenues) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td>' . $revenues->revID . '</td>
                    <td>' . $revenues->revName . '</td>
                    <td>' . $revenues->month . '</td>
                    <td>' . $revenues->clubName . '</td>
                    <td>' . $revenues->className . '</td>
                    <td>' . $revenues->intoMoney . '</td>
                    <td><i class="far fa-smile-beam" onclick="location.href=\'revenues_col_listcom/' . $revenues->revID . '\'"></i></td>
                    <td><i class="far fa-sad-tear" onclick="location.href=\'revenues_col_listincom/' . $revenues->revID . '/' . $revenues->clubID . '\'"></i></td>
                    </tr>';
                            $count++;
                        }
                    } else {
                        foreach ($revenues as $key => $revenues) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td>' . $revenues->revID . '</td>
                    <td>' . $revenues->revName . '</td>
                    <td>' . $revenues->month . '</td>
                    <td>' . $revenues->clubName . '</td>
                    <td>' . $revenues->className . '</td>
                    <td>' . $revenues->intoMoney . '</td>
                    <td><i class="far fa-smile-beam" onclick="location.href=\'revenues_col_listcom/' . $revenues->revID . '\'"></i></td>
                    <td><i class="far fa-sad-tear" onclick="location.href=\'revenues_col_listincom/' . $revenues->revID . '/' . $revenues->clubID . '\'"></i></td>
                    <td>
                    &emsp;<i class="far fa-edit" onclick="location.href=\'revenues_col_edit/' . $revenues->revID . '\'"></i>
                    &emsp;<i class="far fa-trash-alt" onclick="location.href=\'revenues_col/' . $revenues->revID . '\'"></i>
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

    //Export ND thu
    public function exportRev()
    {
        if (Session::has('key')) {
            return view("admin.exportRev");
        } else {
            return view("admin.login");
        }
    }
    public function getexportRev()
    {
        if (Session::has('key')) {
            if (Session::get('roleID') == 'ad') {
                $query = DB::select('SELECT * FROM (club cl INNER JOIN  revenues rev ON rev.clubID=cl.clubID) INNER JOIN class c ON rev.classID=c.classID');
            } else {
                $query = DB::select('SELECT * FROM (club cl INNER JOIN  revenues rev ON rev.clubID=cl.clubID) INNER JOIN class c ON rev.classID=c.classID WHERE cl.manager=\'' . Session::get('coachID') . '\'');
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

    //Export DS VS da dong HP
    public function exportRevList($id)
    {
        if (Session::has('key')) {
            return view("admin.exportRevList", ["id" => $id]);
        } else {
            return view("admin.login");
        }
    }
    public function getexportRevList(Request $request)
    {
        if (Session::has('key')) {
            $query = DB::select('SELECT * FROM (receipt rec INNER JOIN martial ma ON rec.maID=ma.maID) INNER JOIN class c ON ma.classID=c.classID WHERE rec.revID = \'' . $request->id . '\'');
            $data = array();
            foreach ($query as $row) {
                $data[] = $row;
            }
            echo json_encode($data);
        } else {
            return view('admin.login');
        }
    }

    //Export DS VS chua dong HP
    public function exportRevListIn($id)
    {
        if (Session::has('key')) {
            return view("admin.exportRevListIn", ["idrev" => $id]);
        } else {
            return view("admin.login");
        }
    }
    public function getexportRevListIn(Request $request)
    {
        if (Session::has('key')) {
            $query = DB::select('SELECT * 
                                FROM martial m INNER JOIN class c ON m.classID=c.classID 
                                WHERE NOT EXISTS (SELECT receipt.maID 
                                                FROM receipt INNER JOIN revenues ON receipt.revID=revenues.revID 
                                                WHERE receipt.maID=m.maID AND receipt.revID="' . $request->idrev . '")
                                                AND c.clubID="' . $request->idclub . '"');
            $data = array();
            foreach ($query as $row) {
                $data[] = $row;
            }
            echo json_encode($data);
        } else {
            return view('admin.login');
        }
    }

    public function getClass(Request $request)
    {
        $clubName =  $request->text;
        $data = DB::select('select c.classID,c.className from class c inner join club cl on cl.clubID =c.clubID  where cl.clubName = ?', [$clubName]);
        $dataJson = array();
        foreach ($data as $row) {
            $dataJson[] = $row;
        }
        echo json_encode($dataJson);
    }

    public function checkrevID(Request $request)
    {
        $revID =  $request->revID;

        $data = DB::table('revenues')->where('revID','=',$revID)->get();
        echo $data;

    }
}

<?php

namespace App\Http\Controllers;

use App\club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class clubController extends Controller
{
    //
    //Gọi trang Club
    public function getClub()
    {
        if (Session::has('key')) {
            if (Session::get('roleID') == 'ad') {
                $query = DB::table("club");
                $query->join('coach', 'club.manager', '=', 'coach.coachID')->select('*')->get();
                $query = $query->orderBy("clubID", "Desc");
                $data = club::paginate(5);
                $data = $query->paginate(5);
                return view('admin.club', ['data' => $data]);
            } else {
                $query = DB::table("club");
                $query->join('coach', 'club.manager', '=', 'coach.coachID')->select('*')->get();
                $query = $query->orderBy("clubID", "Desc");
                $query->where('club.manager', '=', Session::get('coachID'));
                $data = club::paginate(5);
                $data = $query->paginate(5);
                return view('admin.club', ['data' => $data]);
            }
        } else {
            return view('admin.login');
        }
    }
    //Thêm club
    public function postClubAdd(Request $request)
    {
        if (Session::has('key')) {
            if (Session::get('roleID') == 'ad') {
                //Bắt lỗi
                $this->validate(
                    $request,
                    [
                        'clubID' => 'required',
                        'clubName' => 'required',
                        'clubAddress' => 'required',
                        'manager' => 'required',
                       // 'clubImage' => 'required',
                    ],
                    [
                        'clubID.required' => 'Club ID is not null',
                        'clubName.required' => 'Club name is not null',
                        'clubAddress.required' => 'Club address is not null',
                        'manager.required' => 'Manager is not null',
                        //'clubImage.required' => 'Club image is not null',
                    ]
                );
                $club = new club();
                $club->clubID = $request->clubID;
                $club->clubName = $request->clubName;
                $club->clubAddress = $request->clubAddress;
                $club->manager = $request->manager;
                $club->clubImage = $request->clubImage;
                $club->clubaccount = Session::get('coachID');
                $club->save();

                return redirect('club_add')->with('thongbao', 'Them thanh cong');
            } else {
                return redirect('club_add')->with('thongbao', 'Ban khong co quyen them');;
            }
        } else {
            return view('admin.login');
        }
    }
    public function getClubAdd()
    {
        if (Session::has('key')) {
            if (Session::get('roleID') == 'ad') {
                $query = DB::table("coach");
                $query = $query->orderBy("coachID", "Desc");
                $query = $query->select("*");
                $data = $query->paginate(100);
                return view('admin.club_add', ['data' => $data]);
            } else {
                return redirect('club')->with('thongbao', 'Ban khong co quyen');;
            }
        } else {
            return view('admin.login');
        }
    }

    //Sua club
    public function getClubEdit($id)
    {
        if (Session::has('key')) {
            $club = club::find($id);
            $query = DB::table("coach");
            $query = $query->orderBy("coachID", "Desc");
            $query = $query->select("*");
            $data = $query->paginate(100);
            $data1 = DB::select('select * from coach c INNER JOIN club cl ON cl.manager=c.coachID where clubID = ?', [$id]);

            // dd($club);
            return view('admin.club_edit', ['club' => $club, 'id' => $id, 'data' => $data,'data1'=>$data1]);
        } else {
            return view('admin.login');
        }
    }
    public function postClubEdit(Request $request, $id)
    {
        if (Session::has('key')) {
            $club = club::find($id);
            //Bắt lỗi
            $this->validate(
                $request,
                [
                    'clubID' => 'required',
                    'clubName' => 'required',
                    'clubAddress' => 'required',
                    'manager' => 'required',
                    'clubImage' => 'required',
                ],
                [
                    'clubID.required' => 'Club ID is not nullis not null',
                    'clubName.required' => 'Club name is not null',
                    'clubAddress.required' => 'Club address is not null',
                    'manager.required' => 'Manager is not null',
                    'clubImage.required' => 'Club image is not null',
                ]
            );
            $club->clubID = $request->clubID;
            $club->clubName = $request->clubName;
            $club->clubAddress = $request->clubAddress;
            $club->manager = $request->manager;
            $club->clubImage = $request->clubImage;
            $club->clubaccount = Session::get('coachID');
            $club->save();

            return redirect('club');
            //->with('thongbao', 'Sua "'.$club->clubName. '" thanh cong');
        } else {
            return view('admin.login');
        }
    }


    //Xoa club
    public function getClubDelete(Request $request)
    {
        $id =  $request->id;
        //echo $id;
        if (Session::has('key')) {
            $club = club::find($id);
            $club->delete();
            return redirect('club');
        } else {
            return view('admin.login');
        }
    }

    //view chi tiet thong tin
    public function getDetailClub(Request $request)
    {
        if (Session::has('key')) {
            $id = $request->clubID;
            $query = DB::select('SELECT * FROM club 
                            WHERE club.clubID=?', [$id]);

            $data = array();
            foreach ($query as $row) {
                $data[] = $row;
            }
            return json_encode($data);
        } else {
            return view('admin.login');
        }
    }

    //Lich su club
    public function getClubHistory()
    {
        if (Session::has('key')) {
            $query = DB::table("club");
            $query->join('coach', 'club.manager', '=', 'coach.coachID')->select('*')->get();
            $query = $query->orderBy("clubID", "Desc");
            $data = $query->paginate(100);
            return view('admin.club_history', ['data' => $data]);
        } else {
            return view('admin.login');
        }
    }

    //Hien thi DS HLV cua moi CLB POPUP
    public function getpopup(Request $request)
    {
        $id = $request->clubID;
        $query = DB::select('SELECT * FROM (class c INNER JOIN club cl ON cl.clubID=c.clubID) INNER JOIN coach co ON co.coachID=c.coachID WHERE cl.clubID=?', [$id]);

        $data = array();
        foreach ($query as $row) {
            $data[] = $row;
        }
        return json_encode($data);
    }

    //Tim kiem CLB
    public function getSearch(Request $request)
    {
        if (Session::has('key')) {
            $clubName = $request->value;
            if ($request->ajax()) {
                $output = '';
                if (Session::get('roleID') == 'ad') {
                    $club = DB::table('club')->where('clubName', 'like', '%' . $clubName . '%')
                        ->join('coach', 'club.manager', '=', 'coach.coachID')->get();
                } else {
                    $club = DB::table('club')->where('clubName', 'like', '%' . $clubName . '%')
                        ->where('club.manager', '=', Session::get('coachID'))
                        ->join('coach', 'club.manager', '=', 'coach.coachID')->get();
                }
                if ($club) {
                    $count = 1;
                    if (Session::get('roleID') == 'ad') {
                        foreach ($club as $key => $club) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td><img src="' . $club->clubImage . '" style="width: 30px; height: 30px;"></td>
                    <td>' . $club->clubID . '</td>
                    <td>' . $club->clubName . '</td>
                    <td>' . $club->clubAddress . '</td>
                    <td>' . $club->coachName . '</td>
                    <td>' . $club->phone . '</td>
                    <td><i class="fas fa-list" onclick="location.href=\'class/' . $club->clubID . '\'"></i></a>
                    &emsp;<i class="fas fa-clipboard-list" onclick="showvalue(\'' . $club->clubID . '\')" data-toggle="modal" data-target=".bs-example-modal-lg"></i>
                    &emsp;<i class="far fa-edit" onclick="location.href=\'club_edit/' . $club->clubID . '\'"></i>
                    &emsp;<i class="far fa-trash-alt" onclick="location.href=\'club_edit/' . $club->clubID . '\'"></i></td>
                    </tr>';
                            $count++;
                        }
                    } else {
                        foreach ($club as $key => $club) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td><img src="' . $club->clubImage . '" style="width: 30px; height: 30px;"></td>
                    <td>' . $club->clubID . '</td>
                    <td>' . $club->clubName . '</td>
                    <td>' . $club->clubAddress . '</td>
                    <td>' . $club->coachName . '</td>
                    <td>' . $club->phone . '</td>
                    <td><i class="fas fa-list" onclick="location.href=\'class/' . $club->clubID . '\'"></i></a>
                    &emsp;<i class="fas fa-clipboard-list" onclick="showvalue(\'' . $club->clubID . '\')" data-toggle="modal" data-target=".bs-example-modal-lg"></i>
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

    //Fliter CLB
    public function getfiltercl(Request $request)
    {
        if (Session::has('key')) {
            $selected = $request->selected;
            if ($selected == "coach") {
                $query = DB::table('coach')->select("coachName")->get();
                //DS HLV CUA TUNG CLB
                // $query = DB::table('coach')->join('class', 'coach.coachID', '=', 'class.coachID')
                //     ->join('club', 'class.clubID', '=', 'club.clubID')
                //     ->where('club.manager', '=', Session::get('coachID'))
                //     ->select("coachName")->get();

            } else if ($selected == "club") {
                if (Session::get('roleID') == 'ad') {
                    $query = DB::table('club')->select("clubName")->get();
                } else {
                    $query = DB::table('club')->where('club.manager', '=', Session::get('coachID'))->select("clubName")->get();
                }
            }
            $data = array();
            foreach ($query as $row) {
                $data[] = $row;
            }
            return json_encode($data);
        } else {
            return view('admin.login');
        }
    }

    //Loc CLB
    public function getFilter(Request $request)
    {     
        if (Session::has('key')) {
            $clubName = $request->value;
            if ($request->ajax()) {
                $output = '';
                if (Session::get('roleID') == 'ad') {
                    $club = DB::table('club')->join('coach', 'club.manager', '=', 'coach.coachID')
                        ->where('club.clubName', 'like', '%' . $clubName . '%')
                        ->orWhere('coach.coachName', 'like', '%' . $clubName . '%')->get();
                } else {
                    $club = DB::table('club')->where('club.manager', '=', Session::get('coachID'))
                        ->join('coach', 'club.manager', '=', 'coach.coachID')
                        ->where('club.clubName', 'like', '%' . $clubName . '%')
                        ->orWhere('coach.coachName', 'like', '%' . $clubName . '%')->get();
                }
                if ($club) {
                    $count = 1;
                    if (Session::get('roleID') == 'ad') {
                        foreach ($club as $key => $club) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td><img src="' . $club->clubImage . '" style="width: 30px; height: 30px;"></td>
                    <td>' . $club->clubID . '</td>
                    <td>' . $club->clubName . '</td>
                    <td>' . $club->clubAddress . '</td>
                    <td>' . $club->coachName . '</td>
                    <td>' . $club->phone . '</td>
                    <td><i class="fas fa-list" onclick="location.href=\'class/' . $club->clubID . '\'"></i></a>
                    &emsp;<i class="fas fa-clipboard-list" onclick="showvalue(\'' . $club->clubID . '\')" data-toggle="modal" data-target=".bs-example-modal-lg"></i>
                    &emsp;<i class="far fa-edit" onclick="location.href=\'club_edit/' . $club->clubID . '\'"></i>
                    &emsp;<i class="far fa-trash-alt" onclick="location.href=\'club_edit/' . $club->clubID . '\'"></i></td>
                    </tr>';
                            $count++;
                        }
                    } else {
                        foreach ($club as $key => $club) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td><img src="' . $club->clubImage . '" style="width: 30px; height: 30px;"></td>
                    <td>' . $club->clubID . '</td>
                    <td>' . $club->clubName . '</td>
                    <td>' . $club->clubAddress . '</td>
                    <td>' . $club->coachName . '</td>
                    <td>' . $club->phone . '</td>
                    <td><i class="fas fa-list" onclick="location.href=\'class/' . $club->clubID . '\'"></i></a>
                    &emsp;<i class="fas fa-clipboard-list" onclick="showvalue(\'' . $club->clubID . '\')" data-toggle="modal" data-target=".bs-example-modal-lg"></i>
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

    //Export club
    public function exportClub()
    {
        if (Session::has('key')) {
            return view("admin.exportClub");
        } else {
            return view("admin.login");
        }
    }
    public function getexportClub()
    {
        if (Session::has('key')) {
            if (Session::get('roleID') == 'ad') {
                $query = DB::select('SELECT * FROM club cl INNER JOIN  coach c ON c.coachID=cl.manager');
            } else {
                $query = DB::select('SELECT * FROM club cl INNER JOIN  coach c ON c.coachID=cl.manager WHERE cl.manager=\'' . Session::get('coachID') . '\'');
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

    //load hinh them CLB
    public function imageUploadClubAdd()
    {
        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time() . '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('imageClub'), $imageName);
        return back()
            ->with("success", "thanh cong")
            ->with('image1', $imageName)
            ->with('image', $imageName);
    }

    //load hinh sua CLB
    public function imageUploadClubEdit()
    {
        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time() . '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('imageClub'), $imageName);
        return back()
            ->with("success", "thanh cong")
            ->with('image1', $imageName)
            ->with('image', $imageName);
    }

    public function checkclubID(Request $request)
    {
        $clubID =  $request->clubID;

        $data = DB::table('club')->where('clubID','=',$clubID)->get();
        echo $data;

    }
}

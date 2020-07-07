<?php

namespace App\Http\Controllers;

use App\martial;
use App\classes;
use App\club;
use App\coach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use function GuzzleHttp\Promise\all;

class martialController extends Controller
{
    //
    //Gọi trang Martial Artist
    public function getMartial()
    {
        if (Session::has('key')) {
            $query = DB::table("martial");
            if (Session::get('roleID') == "ad") {
                $query->join('class', 'martial.classID', '=', 'class.classID')
                    ->join('club', 'class.clubID', '=', 'club.clubID')
                    ->join('coach', 'class.coachID', '=', 'coach.coachID')
                    ->select('*')->get();
            } else {
                $query->join('class', 'martial.classID', '=', 'class.classID')
                    ->join('club', 'class.clubID', '=', 'club.clubID')
                    ->join('coach', 'class.coachID', '=', 'coach.coachID')
                    ->where('club.manager', '=', Session::get('coachID'))
                    ->select('*')->get();
            }
            $query->count();
            $query = $query->orderBy("maID", "Desc");
            $query = $query->select("*");
            $data = martial::paginate(10);
            $data = $query->paginate(10);
            return view('admin.martial', ['data' => $data]);
        } else {
            return view('admin.login');
        }
    }

    // filter martial
    public function getfilter(Request $request)
    {
        if (Session::has('key')) {
            $selected = $request->selected;
            if ($selected == "coach") {
                $query = DB::table('coach')->select("coachName")->get();
            } else if ($selected == "club") {
                $query = DB::table('club')->select("clubName")->get();
            } else if ($selected == "class") {
                if (Session::get('roleID') == 'ad') {
                    $query = DB::table('class')->select("className")->get();
                } else {
                    $query = DB::table('class')->join('club', 'class.clubID', '=', 'club.clubID')
                        ->where('club.manager', '=', Session::get('coachID'))
                        ->select("class.className")->get();
                }
            } else if ($selected == "level") {
                $query = array();
                for ($i = 1; $i < 9; $i++) {
                    $query[] = array("keys" => $i);
                }
                return json_encode($query);
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

    //Thêm martial
    public function postMartialAdd(Request $request)
    {
        if (Session::has('key')) {
            $this->validate(
                $request,
                [
                    'maID' => 'required',
                    'maName' => 'required',
                    'maDOB' => 'required',
                    'school' => 'required',
                    'phone' => 'required',
                    'maImage' => 'required',
                    'level' => 'required',
                    'status' => 'required',
                    'maDOA' => 'required',
                    'note' => 'required',
                ],
                [
                    'maID.required' => 'Martial artist ID is not null',
                    'maName.required' => 'Martial artist name is not null',
                    'maDOB.required' => 'Date of birth is not null',
                    'school.required' => 'School is not null',
                    'phone.required' => 'Phone is not null',
                    'maImage.required' => 'Image is not null',
                    'level.required' => 'Level is not null',
                    'status.required' => 'Status is not null',
                    'maDOA.required' => 'Date of addmission name is not null',
                    'note.required' => 'Note is not null',
                ]
            );
            $martial = new martial();
            // if ($_FILES['maImage']['name'] != "") {
            //     $image = basename($_FILES['maImage']['name']);
            //     $target_file = "C:/xampp/htdocs/projectTruc/public/" . $image;
            //     move_uploaded_file($_FILES['maImage']['name'], $target_file);
            // }
            $martial->maID = $request->maID;
            $martial->maName = $request->maName;
            $martial->maGender = $request->maGender;
            $martial->maDOB = $request->maDOB;
            $martial->school = $request->school;
            $martial->maphone = $request->phone;
            $martial->maImage = $request->maImage;
            $martial->malevel = $request->level;
            $martial->status = $request->status;
            $martial->maDOA = $request->maDOA;
            $martial->classID = $request->classID;
            $martial->note = $request->note;
            $martial->maaccount = Session::get('coachID');
            $martial->save();

            return redirect('martial_add')->with('thongbao', 'Them "' . $martial->maName . '" thanh cong');
        } else {
            return view('admin.login');
        }
    }
    public function getMartialAdd()
    {
        if (Session::has('key')) {
            $queryclass = DB::table("class");
            $queryclass = $queryclass->join('club', 'class.clubID', '=', 'club.clubID')
                ->where('club.manager', '=', Session::get('coachID'));
            $queryclass = $queryclass->orderBy("class.classID", "Asc");
            $dataclass = $queryclass->paginate(100);
            return view('admin.martial_add', ['dataclass' => $dataclass]);
        } else {
            return view('admin.login');
        }
    }

    //Sửa martial
    public function postMartialEdit(Request $request, $id)
    {
        if (Session::has('key')) {
            $martial = martial::find($id);
            $this->validate(
                $request,
                [
                    'maID' => 'required',
                    'maName' => 'required',
                    'maDOB' => 'required',
                    'school' => 'required',
                    'phone' => 'required',
                    'maImage' => 'required',
                    'level' => 'required',
                    'status' => 'required',
                    'maDOA' => 'required',
                    'note' => 'required',
                ],
                [
                    'maID.required' => 'Martial artist ID is not null',
                    'maName.required' => 'Martial artist name is not null',
                    'maDOB.required' => 'Date of birth is not null',
                    'school.required' => 'School is not null',
                    'phone.required' => 'Phone is not null',
                    'maImage.required' => 'Image is not null',
                    'level.required' => 'Level is not null',
                    'status.required' => 'Status is not null',
                    'maDOA.required' => 'Date of addmission name is not null',
                    'note.required' => 'Note is not null',
                ]
            );
            // if ($_FILES['maImage']['name'] != "") {
            //     $image = basename($_FILES['maImage']['name']);
            //     $target_file = "C:/xampp/htdocs/projectTruc/public/" . $image;
            //     move_uploaded_file($_FILES['maImage']['name'], $target_file);
            // }
            $martial->maID = $request->maID;
            $martial->maName = $request->maName;
            $martial->maGender = $request->maGender;
            $martial->maDOB = $request->maDOB;
            $martial->school = $request->school;
            $martial->maphone = $request->phone;
            $martial->maImage = $request->maImage;
            $martial->malevel = $request->level;
            $martial->status = $request->status;
            $martial->maDOA = $request->maDOA;
            $martial->classID = $request->classID;
            $martial->note = $request->note;
            $martial->maaccount = Session::get('coachID');
            $martial->save();

            return redirect('martial')->with('thongbao', 'Sua thanh cong');
        } else {
            return view('admin.login');
        }
    }
    public function getMartialEdit($id)
    {
        if (Session::has('key')) {
            $martial = martial::find($id);
            $queryclass = DB::table("class");
            $queryclass = $queryclass->join('club', 'class.clubID', '=', 'club.clubID')
                ->where('club.manager', '=', Session::get('coachID'));
            $queryclass = $queryclass->orderBy("class.classID", "Asc");
            $dataclass = $queryclass->paginate(100);
            $data1 = DB::select('select * from martial ma inner join class c on ma.classID=c.classID where ma.maID = ?', [$id]);
            return view('admin.martial_edit', ['martial' => $martial, 'id' => $id, 'dataclass' => $dataclass, 'data1' => $data1]);
        } else {
            return view('admin.login');
        }
    }

    //Xóa martial
    public function getMartialDelete(Request $request)
    {
        $id=$request->maID;
        if (Session::has('key')) {
            $martial = martial::find($id);
            $martial->delete();
            return redirect('martial');
        } else {
            return view('admin.login');
        }
    }

    //View martial
    public function getMartialView($id)
    {
        if (Session::has('key')) {
            $martial = martial::find($id);
            $query = DB::table('martial');
            $query->join('class', 'martial.classID', '=', 'class.classID')
                ->join('club', 'class.clubID', '=', 'club.clubID')
                ->join('coach', 'class.coachID', '=', 'coach.coachID')
                ->where('martial.maID', '=', $id);
            $data = $query->select('*')->get();
            return view('admin.martial_view', ['martial' => $martial, 'data' => $data]);
        } else {
            return view('admin.login');
        }
    }

    //Lich su martial
    public function getMartialHistory()
    {
        if (Session::has('key')) {
            $query = DB::table("martial");
            $query->join('class', 'martial.classID', '=', 'class.classID')
                ->join('club', 'class.clubID', '=', 'club.clubID')
                ->join('coach', 'class.coachID', '=', 'coach.coachID')
                ->where('club.manager', '=', Session::get('coachID'))
                ->select('*')->get();
            $query->count();
            $query = $query->orderBy("maID", "Desc");
            $query = $query->select("*");
            $data = $query->paginate(1000);
            return view('admin.martial_history', ['data' => $data]);
        } else {
            return view('admin.login');
        }
    }

    //Tim kiem vo sinh
    public function getSearch(Request $request)
    {
        if (Session::has('key')) {
            $maName = $request->value;
            if ($request->ajax()) {
                $output = '';
                if (Session::get('roleID') == 'ad') {
                    $martial = DB::table('martial')->where('maName', 'like', '%' . $maName . '%')
                        ->join('class', 'martial.classID', '=', 'class.classID')
                        ->join('club', 'class.clubID', '=', 'club.clubID')
                        ->join('coach', 'class.coachID', '=', 'coach.coachID')
                        ->orWhere('club.clubName', 'like', '%' . $maName . '%')
                        ->orWhere('class.className', 'like', '%' . $maName . '%')
                        ->orWhere('coach.coachName', 'like', '%' . $maName . '%')
                        ->orWhere('martial.malevel', 'like', $maName)->get();
                } else {
                    $martial = DB::table('martial')->where('maName', 'like', '%' . $maName . '%')
                        ->join('class', 'martial.classID', '=', 'class.classID')
                        ->join('club', 'class.clubID', '=', 'club.clubID')
                        ->join('coach', 'class.coachID', '=', 'coach.coachID')
                        ->where('club.manager', '=', Session::get('coachID'))
                        ->orWhere('club.clubName', 'like', '%' . $maName . '%')
                        ->orWhere('class.className', 'like', '%' . $maName . '%')
                        ->orWhere('coach.coachName', 'like', '%' . $maName . '%')
                        ->orWhere('martial.malevel', 'like', $maName)->get();
                }
                if ($martial) {
                    $count = 1;
                    if (Session::get('roleID') == 'ad') {
                        foreach ($martial as $key => $martial) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td><img src="' . $martial->maImage . '" style="width: 30px; height: 30px;"></td>
                    <td>' . $martial->maID . '</td>
                    <td>' . $martial->maName . '</td>
                    <td>' . $martial->clubName . '</td>
                    <td>' . $martial->className . '</td>
                    <td>' . $martial->coachName . '</td>
                    <td>' . $martial->malevel . '</td>
                    <td><i class="far fa-eye" onclick="location.href=\'martial_view/' . $martial->maID . '\'"></i></td>
                    </tr>';
                            $count++;
                        }
                    } else {
                        foreach ($martial as $key => $martial) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td><img src="' . $martial->maImage . '" style="width: 30px; height: 30px;"></td>
                    <td>' . $martial->maID . '</td>
                    <td>' . $martial->maName . '</td>
                    <td>' . $martial->clubName . '</td>
                    <td>' . $martial->className . '</td>
                    <td>' . $martial->coachName . '</td>
                    <td>' . $martial->malevel . '</td>
                    <td><i class="far fa-eye" onclick="location.href=\'martial_view/' . $martial->maID . '\'"></i>
                    &emsp;<i class="far fa-edit" onclick="location.href=\'martial_edit/' . $martial->maID . '\'"></i>
                    &emsp;<i class="far fa-trash-alt" onclick="location.href=\'martial/' . $martial->maID . '\'"></i></td>
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

    //Loc DS vo sinh
    public function getFilterMA(Request $request)
    {
        if (Session::has('key')) {
            $maName = $request->value;
            if ($request->ajax()) {
                $output = '';
                if (Session::get('roleID') == 'ad') {
                    $martial = DB::table('martial')->where('maName', 'like', '%' . $maName . '%')
                        ->join('class', 'martial.classID', '=', 'class.classID')
                        ->join('club', 'class.clubID', '=', 'club.clubID')
                        ->join('coach', 'class.coachID', '=', 'coach.coachID')
                        ->orWhere('club.clubName', 'like', '%' . $maName . '%')
                        ->orWhere('class.className', 'like', '%' . $maName . '%')
                        ->orWhere('martial.malevel', 'like', $maName)
                        ->orWhere('coach.coachName', 'like', '%' . $maName . '%')->get();
                } else {
                    $martial = DB::table('martial')->where('maName', 'like', '%' . $maName . '%')
                        ->join('class', 'martial.classID', '=', 'class.classID')
                        ->join('club', 'class.clubID', '=', 'club.clubID')
                        ->join('coach', 'class.coachID', '=', 'coach.coachID')
                        ->where('club.manager', '=', Session::get('coachID'))
                        ->orWhere('club.clubName', 'like', '%' . $maName . '%')
                        ->orWhere('class.className', 'like', '%' . $maName . '%')
                        ->orWhere('martial.malevel', 'like', $maName)
                        ->orWhere('coach.coachName', 'like', '%' . $maName . '%')->get();
                }
                if ($martial) {
                    $count = 1;
                    if (Session::get('roleID') == 'ad') {
                        foreach ($martial as $key => $martial) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td><img src="' . $martial->maImage . '" style="width: 30px; height: 30px;"></td>
                    <td>' . $martial->maID . '</td>
                    <td>' . $martial->maName . '</td>
                    <td>' . $martial->clubName . '</td>
                    <td>' . $martial->className . '</td>
                    <td>' . $martial->coachName . '</td>
                    <td>' . $martial->malevel . '</td>
                    <td><i class="far fa-eye" onclick="location.href=\'martial_view/' . $martial->maID . '\'"></i></td>
                    </tr>';
                            $count++;
                        }
                    } else {
                        foreach ($martial as $key => $martial) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td><img src="' . $martial->maImage . '" style="width: 30px; height: 30px;"></td>
                    <td>' . $martial->maID . '</td>
                    <td>' . $martial->maName . '</td>
                    <td>' . $martial->clubName . '</td>
                    <td>' . $martial->className . '</td>
                    <td>' . $martial->coachName . '</td>
                    <td>' . $martial->malevel . '</td>
                    <td><i class="far fa-eye" onclick="location.href=\'martial_view/' . $martial->maID . '\'"></i>
                    &emsp;<i class="far fa-edit" onclick="location.href=\'martial_edit/' . $martial->maID . '\'"></i>
                    &emsp;<i class="far fa-trash-alt" onclick="location.href=\'martial/' . $martial->maID . '\'"></i></td>
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

    //Export vo sinh
    public function exportMartial()
    {
        if (Session::has('key')) {
            return view("admin.exportMartial");
        } else {
            return view("admin.login");
        }
    }
    public function getexportMartial()
    {
        if (Session::has('key')) {
            if (Session::get('roleID') == 'ad') {
                $query = DB::select('SELECT * FROM ((martial m INNER JOIN class c ON m.classID=c.classID) INNER JOIN club cl ON c.clubID=cl.clubID) INNER JOIN coach co ON cl.manager=co.coachID');
            } else {
                $query = DB::select('SELECT * FROM ((martial m INNER JOIN class c ON m.classID=c.classID) INNER JOIN club cl ON c.clubID=cl.clubID) INNER JOIN coach co ON cl.manager=co.coachID WHERE cl.manager=\'' . Session::get('coachID') . '\'');
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

    //load hinh them vo sinh
    public function imageUploadMartialAdd()
    {
        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time() . '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('imageMa'), $imageName);
        return back()
            ->with("success", "thanh cong")
            ->with('image1', $imageName)
            ->with('image', $imageName);
    }

    //load hinh sua CLB
    public function imageUploadMartialEdit()
    {
        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time() . '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('imageMa'), $imageName);
        return back()
            ->with("success", "thanh cong")
            ->with('image1', $imageName)
            ->with('image', $imageName);
    }

    //check ma ID
    public function checkmaID(Request $request)
    {
        $maID =  $request->maID;
        $data = DB::table('martial')->where('maID','=',$maID)->get();
        echo $data;

    }
}

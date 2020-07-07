<?php

namespace App\Http\Controllers;

use App\classes;
use App\club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class classController extends Controller
{
    //
    //Gọi trang Class
    public function getClass($id)
    {
        if (Session::has('key')) {
            $query = DB::table("class");
            $query->join('club', 'class.clubID', '=', 'club.clubID')->join('coach', 'class.coachID', '=', 'coach.coachID')
            ->where('club.clubID', '=', $id)->select('*')->get();
            $data = classes::paginate(5);
            $data = $query->paginate(5);
            return view('admin.class', ['data' => $data, 'clubID' => $id]);
        } else {
            return view('admin.login');
        }
    }

    //Thêm class
    public function postClassAdd(Request $request)
    {
        if (Session::has('key')) {
            $class = new classes();
            $class->classID = $request->classID;
            $class->className = $request->className;
            $class->clubID = $request->clubID;
            $class->date = $request->date;
            $class->startTime = $request->startTime;
            $class->endTime = $request->endTime;
            $class->coachID = $request->coachID;
            $class->assistant = $request->assistant;
            $class->rentalMoney = $request->rentalMoney;
            $class->classImage = $request->classImage;
            $class->classaccount = 'co01';
            $class->save();

            return redirect('class_add')->with('thongbao', 'Them thanh cong');
        } else {
            return view('admin.login');
        }
    }
    public function getClassAdd()
    {
        if (Session::has('key')) {
            $queryclub = DB::table("club");
            $queryclub = $queryclub->where('club.manager', '=', Session::get('coachID'))->orderBy("clubID", "Desc");
            $dataclub = $queryclub->paginate(100);
            $querycoach = DB::table("coach");
            $querycoach = $querycoach->orderBy("coachID", "Desc");
            $datacoach = $querycoach->paginate(100);
            return view('admin.class_add', ['dataclub' => $dataclub, 'datacoach' => $datacoach]);
        } else {
            return view('admin.login');
        }
    }

    //Sua class
    public function postClassEdit(Request $request, $idclub, $idclass)
    {
        if (Session::has('key')) {
            $class = classes::find($idclass);
            $class->classID = $request->classID;
            $class->className = $request->className;
            $class->clubID = $request->clubID;
            $class->date = $request->date;
            $class->startTime = $request->startTime;
            $class->endTime = $request->endTime;
            $class->coachID = $request->coachID;
            $class->assistant = $request->assistant;
            $class->rentalMoney = $request->rentalMoney;
            $class->classImage = $request->classImage;
            $class->classaccount = Session::get('coachID');
            $class->save();

            return redirect('class/' . $class->clubID);
            //->with('thongbao', 'Sua "'.$club->clubName. '" thanh cong');
        } else {
            return view('admin.login');
        }
    }
    public function getClassEdit($idclub, $idclass)
    {
        if (Session::has('key')) {
            $class = classes::find($idclass);
            $queryclub = DB::table("club");
            $queryclub = $queryclub->where('club.manager', '=', Session::get('coachID'))->orderBy("clubID", "Desc");
            $dataclub = $queryclub->paginate(100);
            $querycoach = DB::table("coach");
            $querycoach = $querycoach->orderBy("coachID", "Desc");
            $datacoach = $querycoach->paginate(100);
            $data1 = DB::select('select * from (class c inner join club cl on c.clubID=cl.clubID) inner join coach co on c.coachID=co.coachID where c.classID = ?', [$idclass]);
            // dd($club);
            return view('admin.class_edit', ['class' => $class, 'id' => $idclass, 'dataclub' => $dataclub, 'datacoach' => $datacoach, 'data1' => $data1]);
        } else {
            return view('admin.login');
        }
    }
    //Xoa class
    public function getClassDelete(Request $request)
    {
        $idclass=$request->idclass;
        if (Session::has('key')) {
            $class = classes::find($idclass);
            $class->delete();
            return redirect('class/' . $class->clubID);
        } else {
            return view('admin.login');
        }
    }

    //Lich su class
    public function getClassHistory()
    {
        if (Session::has('key')) {
            $query = DB::table("class");
            $query->join('club', 'class.clubID', '=', 'club.clubID')
                ->join('coach', 'class.coachID', '=', 'coach.coachID')
                ->where('club.manager', '=', Session::get('coachID'))
                ->select('*')->get();
            $data = $query->paginate(100);
            return view('admin.class_history', ['data' => $data]);
        } else {
            return view('admin.login');
        }
    }

    //Hien thi popup
    public function getPopup(Request $request)
    {
        if (Session::has('key')) {
            $id = $request->classID;
            $query = DB::select("SELECT * FROM class c INNER JOIN martial m ON c.classID=m.classID WHERE c.classID=?", [$id]);

            $data = array();
            foreach ($query as $row) {
                $data[] = $row;
            }
            return json_encode($data);
        } else {
            return view('admin.login');
        }
    }

    //Tim kiem class
    public function getSearch(Request $request)
    {
        if (Session::has('key')) {
            $className = $request->value;
            if ($request->ajax()) {
                $output = '';
                $class = DB::table('class')->where('className', 'like', '%' . $className . '%')
                    ->join('club', 'class.clubID', '=', 'club.clubID')
                    ->join('coach', 'class.coachID', '=', 'coach.coachID')
                    ->where('club.clubID', '=', $request->clubID)
                    ->orWhere('coach.coachName', 'like', '%' . $className . '%')
                    ->where('club.manager', '=', Session::get('coachID'))->get();
                if ($class) {
                    $count = 1;
                    if (Session::get('roleID') == 'ad') {
                        foreach ($class as $key => $class) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td><img src="/projectTruc/public/' . $class->classImage . '" style="width: 40px; height: 40px;"></td>
                    <td>' . $class->classID . '</td>
                    <td>' . $class->className . '</td>
                    <td>' . $class->date . '</td>
                    <td>' . $class->startTime . ' - ' . $class->endTime . '</td>
                    <td>' . $class->coachName . '</td>
                    <td>' . $class->phone . '</td>
                    <td>' . $class->assistant . '</td>
                    <td>
                    <i class="fas fa-list" onclick="showvalue(\'' . $class->classID . '\')" data-toggle="modal" data-target=".bs-example-modal-lg"></i>
                    </td>
                    </tr>';
                            $count++;
                        }
                    } else {
                        foreach ($class as $key => $class) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td><img src="/projectTruc/public/' . $class->classImage . '" style="width: 40px; height: 40px;"></td>
                    <td>' . $class->classID . '</td>
                    <td>' . $class->className . '</td>
                    <td>' . $class->date . '</td>
                    <td>' . $class->startTime . ' - ' . $class->endTime . '</td>
                    <td>' . $class->coachName . '</td>
                    <td>' . $class->phone . '</td>
                    <td>' . $class->assistant . '</td>
                    <td>
                    <i class="fas fa-list" onclick="showvalue(\'' . $class->classID . '\')" data-toggle="modal" data-target=".bs-example-modal-lg"></i>
                    &emsp;<i class="far fa-edit" onclick="location.href=\'' . $class->clubID . '/' . $class->classID . '\'"></i>
                    &emsp;<i class="far fa-trash-alt" onclick="location.href=\'delete/' . $class->clubID . '/' . $class->classID . '\'"></i>
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


    //Export class
    public function exportClass($id)
    {
        if (Session::has('key')) {
            return view("admin.exportClass", ["id" => $id]);
        } else {
            return view("admin.login");
        }
    }
    public function getexportClass(Request $request)
    {
        if (Session::has('key')) {
            if (Session::get('roleID') == 'ad') {
                $query = DB::select('SELECT * FROM (class c INNER JOIN club cl ON c.clubID=cl.clubID) INNER JOIN coach co ON c.coachID=co.coachID WHERE cl.clubID = \'' . $request->id . '\'');
            } else {
                $query = DB::select('SELECT * FROM (class c INNER JOIN club cl ON c.clubID=cl.clubID) INNER JOIN coach co ON c.coachID=co.coachID WHERE cl.clubID = \'' . $request->id . '\' AND cl.manager=\'' . Session::get('coachID') . '\'');
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

    //load hinh them class
    public function imageUploadClassAdd()
    {
        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time() . '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('imageClass'), $imageName);
        return back()
            ->with("success", "thanh cong")
            ->with('image1', $imageName)
            ->with('image', $imageName);
    }

    //load hinh sua class
    public function imageUploadClassEdit()
    {
        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time() . '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('imageClass'), $imageName);
        return back()
            ->with("success", "thanh cong")
            ->with('image1', $imageName)
            ->with('image', $imageName);
    }

    //check class ID
    public function checkclassID(Request $request)
    {
        $classID =  $request->classID;

        $data = DB::table('class')->where('classID','=',$classID)->get();
        echo $data;

    }
}

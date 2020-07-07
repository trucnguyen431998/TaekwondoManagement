<?php

namespace App\Http\Controllers;

use App\club;
use App\coach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class coachController extends Controller
{
    //
    //Goi trang Login
    public function getLogin()
    {
        return view('admin.login');
    }
    public function postLogin(Request $request)
    {
        //Bắt lỗi
        $this->validate(
            $request,
            [
                'email' => 'required',
                'password' => 'required',
            ],
            [
                'accountName.required' => 'Bạn chưa nhập tên đăng nhập',
                'password.required' => 'Bạn chưa nhập password',
                // 'password.min' => 'Mã kỳ thi từ 1 đến 100 ký tự',
                // 'password.max' => 'Mã kỳ thi từ 1 đến 100 ký tự',
            ]
        );
        $email = $request->email;
        $pass = $request->password;
        //$queryCoachID = DB::select('select c.coachID from coach c where c.email = ? AND c.password = ?', [$email,$pass]);
        $coachID = DB::table('coach')->where('email', $email)->value('coachID');
        $roleID = DB::table('coach')->where('email', $email)->value('roleID');
        Session::put('roleID', $roleID);
        Session::put('coachID', $coachID);
        if (Auth::attempt(['email' => $email, 'password' => $pass])) {
            Session::put('key', $request->email);
            return redirect('dashboard');
        } else {
            return redirect('login')->with('thongbao', 'Đăng nhập không thành công');
        }
    }

    //Dang xuat
    public function detroySesion()
    {
        Session::forget('key');
        return view('admin.login');
    }

    //Gọi trang Coach
    public function getCoach()
    {
        if (Session::has('key')) {
            $query = DB::table("coach");
            $query = $query->orderBy("coachID", "Desc");
            $query = $query->select("*");
            $data = coach::paginate(10);
            $data = $query->paginate(10);
            return view('admin.coach', ['data' => $data]);
        } else {
            return view('admin.login');
        }
    }
    //Thêm coach
    public function postCoachAdd(Request $request)
    {
        if (Session::has('key')) {
            //Bắt lỗi
            $this->validate(
                $request,
                [
                    'coachID' => 'required',
                    'coachName' => 'required',
                    'coachAddress' => 'required',
                    'coachDOB' => 'required',
                    'coachGender' => 'required',
                    'accountName' => 'required',
                    'password' => 'required',
                    'coachImage' => 'required',
                    // 'facebook' => 'required',
                    // 'zalo' => 'required',
                    // 'phone' => 'required',
                    'email' => 'required',
                ],
                [
                    'coachID.required' => 'Coach ID is not null',
                    'coachName.required' => 'Coach name is not null',
                    'coachAddress.required' => 'Coach address is not null',
                    'coachDOB.required' => 'DOB is not null',
                    'coachGender.required' => 'Gender is not null',
                    'accountName.required' => 'Account name is not null',
                    'password.required' => 'Password is not null',
                    'coachImage.required' => 'Coach image is not null',
                    // 'facebook.required' => 'Facebook is not null',
                    // 'zalo.required' => 'Zalo is not null',
                    // 'phone.required' => 'Phone is not null',
                    'email.required' => 'Email is not null',
                ]
            );
            $coach = new coach();
            $coach->coachID = $request->coachID;
            $coach->coachName = $request->coachName;
            $coach->coachAddress = $request->coachAddress;
            $coach->coachDOB = $request->coachDOB;
            $coach->coachGender = $request->coachGender;
            $coach->accountName = $request->accountName;
            if ($request->password == $request->repassword) {
                $coach->password = bcrypt($request->password);
            } else {
                //with('thongbao', 'Re - Password khong trung voi password');
            }
            //$coach->password = bcrypt($request->password);
            $coach->coachImage = $request->coachImage;
            $coach->facebook = $request->facebook;
            $coach->zalo = $request->zalo;
            $coach->phone = $request->phone;
            $coach->email = $request->email;
            $coach->roleID = 'us';
            $coach->save();

            return redirect('coach_add')->with('thongbao', 'Them thanh cong');
        } else {
            return view('admin.login');
        }
    }
    public function getCoachAdd()
    {
        if (Session::has('key')) {
            return view('admin.coach_add');
        } else {
            return view('admin.login');
        }
    }

    //Sua coach
    public function postCoachEdit(Request $request, $id)
    {
        if (Session::has('key')) {
            $coach = coach::find($id);
            //Bắt lỗi
            $this->validate(
                $request,
                [
                    'coachID' => 'required',
                    'coachName' => 'required',
                    'coachAddress' => 'required',
                    'coachDOB' => 'required',
                    'coachGender' => 'required',
                    'accountName' => 'required',
                    'password' => 'required',
                    'coachImage' => 'required',
                    // 'facebook' => 'required',
                    // 'zalo' => 'required',
                    // 'phone' => 'required',
                    'email' => 'required',
                ],
                [
                    'coachID.required' => 'Coach ID is not null',
                    'coachName.required' => 'Coach name is not null',
                    'coachAddress.required' => 'Coach address is not null',
                    'coachDOB.required' => 'DOB is not null',
                    'coachGender.required' => 'Gender is not null',
                    'accountName.required' => 'Account name is not null',
                    'password.required' => 'Password is not null',
                    'coachImage.required' => 'Coach image is not null',
                    // 'facebook.required' => 'Facebook is not null',
                    // 'zalo.required' => 'Zalo is not null',
                    // 'phone.required' => 'Phone is not null',
                    'email.required' => 'Email is not null',
                ]
            );
            $coach->coachID = $request->coachID;
            $coach->coachName = $request->coachName;
            $coach->coachAddress = $request->coachAddress;
            $coach->coachDOB = $request->coachDOB;
            $coach->coachGender = $request->coachGender;
            $coach->accountName = $request->accountName;
            $coach->password = bcrypt($request->password);
            $coach->coachImage = $request->coachImage;
            $coach->facebook = $request->facebook;
            $coach->zalo = $request->zalo;
            $coach->phone = $request->phone;
            $coach->email = $request->email;
            $coach->roleID = $request->roleID;
            $coach->save();

            return redirect('coach_edit/' . $id)->with('thongbao', 'Sua "' . $coach->coachName . '" thanh cong');
        } else {
            return view('admin.login');
        }
    }
    public function getCoachEdit($id)
    {
        if (Session::has('key')) {
            $coach = coach::find($id);
            return view('admin.coach_edit', ['coach' => $coach, 'id' => $id]);
        } else {
            return view('admin.login');
        }
    }

    //Xoa coach
    public function getCoachDelete(Request $request)
    {
        $id=$request->coachID;
        if (Session::has('key')) {
            $coach = coach::find($id);
            $coach->delete();
            return redirect('coach');
        } else {
            return view('admin.login');
        }
    }

    //View coach
    public function getCoachView($id)
    {
        if (Session::has('key')) {
            $coach = coach::find($id);
            return view('admin.coach_view', ['coach' => $coach, 'id' => $id]);
        } else {
            return view('admin.login');
        }
    }

    //Lich su coach
    public function getCoachHistory()
    {
        if (Session::has('key')) {
            $query = DB::table("coach");
            $query = $query->orderBy("coachID", "Desc");
            $query = $query->select("*");
            $data = $query->paginate(1000);
            return view('admin.coach_history', ['data' => $data]);
        } else {
            return view('admin.login');
        }
    }

    //Hien thi DS lop cua moi HLV
    public function getPopup(Request $request)
    {
        if (Session::has('key')) {
            $id = $request->coachID;
            $query = DB::select('SELECT * FROM class cl INNER JOIN coach co ON cl.coachID=co.coachID WHERE co.coachID=?', [$id]);

            $data = array();
            foreach ($query as $row) {
                $data[] = $row;
            }
            return json_encode($data);
        } else {
            return view('admin.login');
        }
    }

    //Tim kiem lop
    public function getSearch(Request $request)
    {
        if (Session::has('key')) {
            $coachName = $request->value;
            if ($request->ajax()) {
                $output = '';
                $coach = DB::table('coach')->where('coachName', 'like', '%' . $coachName . '%')
                    ->orWhere('email', 'like', '%' . $coachName . '%')
                    ->orWhere('facebook', 'like', '%' . $coachName . '%')->get();

                if ($coach) {
                    $count = 1;
                    if (Session::get('roleID') == 'ad') {
                        foreach ($coach as $key => $coach) {
                            $output .= '<tr>
                        <td>' . $count . '</td>
                        <td><img src="' . $coach->coachImage . '" style="width: 30px; height: 30px;"></td>
                        <td>' . $coach->coachID . '</td>
                        <td>' . $coach->coachName . '</td>
                        <td>' . $coach->phone . '</td>
                        <td>' . $coach->email . '</td>
                        <td>' . $coach->facebook . '</td>
                        <td>' . $coach->zalo . '</td>
                        <td><i class="fas fa-clipboard-list" onclick="showvalue(\'' . $coach->coachID . '\')" data-toggle="modal" data-target=".bs-example-modal-lg"></i>
                        &emsp;<i class="far fa-edit" onclick="location.href=\'coach_edit/' . $coach->coachID . '\'"></i>
                        &emsp;<i class="far fa-trash-alt" onclick="location.href=\'coach/' . $coach->coachID . '\'"></i></td>
                        </tr>';
                            $count++;
                        }
                    } else {
                        foreach ($coach as $key => $coach) {
                            $output .= '<tr>
                        <td>' . $count . '</td>
                        <td><img src="' . $coach->coachImage . '" style="width: 30px; height: 30px;"></td>
                        <td>' . $coach->coachID . '</td>
                        <td>' . $coach->coachName . '</td>
                        <td>' . $coach->phone . '</td>
                        <td>' . $coach->email . '</td>
                        <td>' . $coach->facebook . '</td>
                        <td>' . $coach->zalo . '</td>
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

    //Export coach
    public function exportCoach()
    {
        if (Session::has('key')) {
            return view("admin.exportCoach");
        } else {
            return view("admin.login");
        }
    }
    public function getexportCoach()
    {
        if (Session::has('key')) {
            $query = DB::select('SELECT * FROM coach');
            $data = array();
            foreach ($query as $row) {
                $data[] = $row;
            }
            echo json_encode($data);
        } else {
            return view('admin.login');
        }
    }

    //load hinh them HLV
    public function imageUploadCoachAdd()
    {
        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time() . '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('imageCoach'), $imageName);
        return back()
            ->with("success", "thanh cong")
            ->with('image1', $imageName)
            ->with('image', $imageName);
    }

    //load hinh sua HLV
    public function imageUploadCoachEdit()
    {
        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time() . '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('imageCoach'), $imageName);
        return back()
            ->with("success", "thanh cong")
            ->with('image1', $imageName)
            ->with('image', $imageName);
    }

    // check coachID
    function checkcoachID(Request $request)
    {
        $coachID =  $request->coachID;
        $data = DB::table('coach')->where('coachID','=',$coachID)->get();
        echo $data;
    }

}

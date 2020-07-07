<?php

namespace App\Http\Controllers;

use App\exam;
use App\maofexam;
use App\result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\See;

class examController extends Controller
{
    //
    //Gọi trang Exam
    public function getExam()
    {
        if (Session::has('key')) {
            $query = DB::table("exam");
            $query = $query->orderBy("examID", "Desc");
            $query = $query->select("*");
            $data = exam::paginate(10);
            $data = $query->paginate(10);
            return view('admin.exam', ['data' => $data]);
        } else {
            return view('admin.login');
        }
    }
    //Thêm exam
    public function postExamAdd(Request $request)
    {
        if (Session::has('key')) {
            //Bắt lỗi
            $this->validate(
                $request,
                [
                    'examID' => 'required',
                    'examName' => 'required',
                    'address' => 'required',
                    'organizers' => 'required',
                ],
                [
                    'examID.required' => 'Exam ID is not null',
                    'examName.required' => 'Exam name is not null',
                    'address.required' => 'Address is not null',
                    'organizers.required' => 'Organizers is not null',
                ]
            );

            $exam = new exam;
            $exam->examID = $request->examID;
            $exam->examName = $request->examName;
            $exam->address = $request->address;
            $exam->dateStart = $request->dateStart;
            $exam->dateEnd = $request->dateEnd;
            $exam->organizers = $request->organizers;
            $exam->note = $request->note;
            $exam->examaccount = Session::get('coachID');
            $exam->save();

            return redirect('exam_add')->with('thongbao', 'Them thanh cong');
        } else {
            return view('admin.login');
        }
    }
    public function getExamAdd()
    {
        if (Session::has('key')) {
            return view('admin.exam_add');
        } else {
            return view('admin.login');
        }
    }

    //Sửa exam
    public function getExamEdit($id)
    {
        if (Session::has('key')) {
            $exam = exam::find($id);
            return view('admin.exam_edit', ['exam' => $exam, 'id' => $id]);
        } else {
            return view('admin.login');
        }
    }
    public function postExamEdit(Request $request, $examID)
    {
        if (Session::has('key')) {
            $exam = exam::find($examID);
            //Bắt lỗi
            $this->validate(
                $request,
                [
                    'examID' => 'required',
                    'examName' => 'required',
                    'address' => 'required',
                    'organizers' => 'required',
                ],
                [
                    'examID.required' => 'Exam ID is not null',
                    'examName.required' => 'Exam name is not null',
                    'address.required' => 'Address is not null',
                    'organizers.required' => 'Organizers is not null',
                ]
            );
            $exam->examID = $request->examID;
            $exam->examName = $request->examName;
            $exam->address = $request->address;
            $exam->dateStart = $request->dateStart;
            $exam->dateEnd = $request->dateEnd;
            $exam->organizers = $request->organizers;
            $exam->note = $request->note;
            $exam->examaccount = Session::get('coachID');
            $exam->save();

            return redirect('exam')->with('thongbao', 'Sua ' . $exam->examID . ' thanh cong');
        } else {
            return view('admin.login');
        }
    }

    //Xóa exam
    public function getExamDelete(Request $request)
    {
        $id = $request->examID;
        if (Session::has('key')) {
            $exam = exam::find($id);
            $exam->delete();
            return redirect('exam');
        } else {
            return view('admin.login');
        }
    }

    //DS vo sinh co trong Exam
    public function getExamList($id)
    {
        if (Session::has('key')) {
            $query = DB::table("maofexam");
            if (Session::get('roleID') == "ad") {
                $query->join('martial', 'maofexam.maID', '=', 'martial.maID')
                    ->join('class', 'martial.classID', '=', 'class.classID')
                    ->join('club', 'club.clubID', '=', 'class.clubID')
                    ->join('coach', 'class.coachID', '=', 'coach.coachID')
                    ->where('examID', '=', $id)->select('*')->get();
            } else {
                $query->join('martial', 'maofexam.maID', '=', 'martial.maID')
                    ->join('class', 'martial.classID', '=', 'class.classID')
                    ->join('club', 'club.clubID', '=', 'class.clubID')
                    ->join('coach', 'class.coachID', '=', 'coach.coachID')
                    ->where('examID', '=', $id)
                    ->where('club.manager', '=', Session::get('coachID'))
                    ->select('*')->get();
            }
            $count = $query->count();
            $data = maofexam::paginate(10);
            $data = $query->paginate(10);
            return view('admin.exam_list', ['data' => $data, 'count' => $count, 'examID' => $id]);
        } else {
            return view('admin.login');
        }
    }

    //DS vo sinh chua co trong ky thi
    public function getExamListin($idexam)
    {
        if (Session::has('key')) {
            if (Session::get('roleID') == 'ad') {
                $query = DB::select('SELECT * 
                             FROM martial m INNER JOIN class c ON m.classID=c.classID INNER JOIN club cl ON c.clubID=cl.clubID INNER JOIN coach co ON c.coachID=co.coachID
                             WHERE NOT EXISTS (SELECT moe.maID
                                                FROM maofexam moe INNER JOIN exam ex ON moe.examID =ex.examID 
                                                WHERE moe.maID=m.maID AND moe.examID="' . $idexam . '")');
            } else {
                $query = DB::select('SELECT * 
                             FROM martial m INNER JOIN class c ON m.classID=c.classID INNER JOIN club cl ON c.clubID=cl.clubID INNER JOIN coach co ON c.coachID=co.coachID
                             WHERE NOT EXISTS (SELECT moe.maID
                                                FROM maofexam moe INNER JOIN exam ex ON moe.examID =ex.examID 
                                                WHERE moe.maID=m.maID AND moe.examID="' . $idexam . '")
                            AND cl.manager="' . Session::get('coachID') . '"');
            }

            $data = maofexam::paginate(10);
            $data = $query;
            $examID = $idexam;
            return view('admin.exam_listin', ['data' => $data, 'examID' => $examID]);
        } else {
            return view('admin.login');
        }
    }

    //Them vo sinh vao DS thi
    public function getMartialAddList(Request $request)
    {
        if (Session::has('key')) {
            $maofexam = new maofexam();
            $maofexam->moeID = $request->examID . $request->maID;
            $maofexam->maID = $request->maID;
            $maofexam->examID = $request->examID;
            $maofexam->moeaccount = $request->coachID;
            $maofexam->level = $request->level;
            $maofexam->save();
        } else {
            return view('admin.login');
        }
    }
    //Xoa vo sinh ra khoi ky thi
    public function getMartialDeleteList(Request $request)
    {
        if (Session::has('key')) {
            $maofexam = maofexam::find($request->moeID);
            $maofexam->delete();
        } else {
            return view('admin.login');
        }
    }

    //DS ket qua cua Exam
    public function getExamResult($idexam)
    {
        if (Session::has('key')) {
            $query = DB::table('result');
            if (Session::get('roleID') == 'ad') {
                $query->join('exam', 'result.examID', '=', 'exam.examID')
                    ->join('martial', 'result.maID', '=', 'martial.maID')
                    ->join('class', 'martial.classID', '=', 'class.classID')
                    ->join('club', 'class.clubID', '=', 'club.clubID')
                    ->join('coach', 'class.coachID', '=', 'coach.coachID')
                    ->where('result.examID', '=', $idexam)->select('*')
                    ->get();
            } else {
                $query->join('exam', 'result.examID', '=', 'exam.examID')
                    ->join('martial', 'result.maID', '=', 'martial.maID')
                    ->join('class', 'martial.classID', '=', 'class.classID')
                    ->join('club', 'class.clubID', '=', 'club.clubID')
                    ->join('coach', 'class.coachID', '=', 'coach.coachID')
                    ->where('result.examID', '=', $idexam)->select('*')
                    ->where('club.manager', '=', Session::get('coachID'))->get();
            }
            $data = result::paginate(10);
            $data = $query->paginate(10);
            return view('admin.exam_result', ['data' => $data]);
        } else {
            return view('admin.login');
        }
    }
    //Lich su Exam
    public function getExamHistory()
    {
        if (Session::has('key')) {
            $query = DB::table("exam");
            $query = $query->orderBy("examID", "Desc");
            $query = $query->select("*");
            $data = $query->paginate(100);
            return view('admin.exam_history', ['data' => $data]);
        } else {
            return view('admin.login');
        }
    }
    //Xóa vo sinh trong tung exam
    public function getMartialDelete($idlist, $idma)
    {
        if (Session::has('key')) {
            $maofexam = maofexam::find($idma);
            $maofexam->delete();
            return redirect('exam_list/{' . $idlist . '}');
        } else {
            return view('admin.login');
        }
    }

    //Nhap diem cho vo sinh trong moi exam
    public function getScore($maID, $examID)
    {
        if (Session::has('key')) {
            $query = DB::table('maofexam');
            $query->join('exam', 'maofexam.examID', '=', 'exam.examID')
                ->join('martial', 'maofexam.maID', '=', 'martial.maID')
                ->where('exam.examID', '=', $examID)
                ->where('martial.maID', '=', $maID)->select('*')->get();
            $data = $query->paginate(100);
            //echo $maID.$examID;
            return view('admin.score_add', ['data' => $data, 'maID' => $maID, 'examID' => $examID]);
        } else {
            return view('admin.login');
        }
    }
    public function postScore(Request $request, $maID, $examID)
    {
        if (Session::has('key')) {
            //Bắt lỗi
            $this->validate(
                $request,
                [
                    'scoreOfPunch' => 'required',
                    'scoreOfKick' => 'required',
                    'scoreOfMain' => 'required',
                    'scoreOfPractice' => 'required',
                    'scoreOfCountervailing' => 'required',
                    'scoreOfEndurance' => 'required',
                    'rank' => 'required',
                    'examiner' => 'required',
                ],
                [
                    'scoreOfPunch.required' => 'Score of punch is not null',
                    'scoreOfKick.required' => 'Score of kick is not null',
                    'scoreOfMain.required' => 'Score of main is not null',
                    'scoreOfPractice.required' => 'Score of practice is not null',
                    'scoreOfCountervailing.required' => 'Score of counntervailing is not null',
                    'scoreOfEndurance.required' => 'Score of endurance is not null',
                    'rank.required' => 'Rank is not null',
                    'examiner.required' => 'Examiner is not null',
                ]
            );
            $result = new result();
            $result->resID = $examID . $maID;
            $result->examID = $examID;
            $result->maID = $maID;
            $result->scoreOfPunch = $request->scoreOfPunch;
            $result->scoreOfKich = $request->scoreOfKick;
            $result->scoreOfMain = $request->scoreOfMain;
            $result->scoreOfPractice = $request->scoreOfPractice;
            $result->scoreOfCountervailing = $request->scoreOfCountervailing;
            $result->scoreOfEndurance = $request->scoreOfEndurance;
            $result->totalScore = $request->scoreTotal;
            $result->rank = $request->rank;
            $result->examiner = $request->examiner;
            $result->resLevel = $request->resLevel;
            $result->resaccount = Session::get('coachID');
            $result->save();

            return redirect('exam_list/' . $examID);
        } else {
            return view('admin.login');
        }
    }

    //Sua diem cho vo sinh trong moi exam
    public function getScoreEdit($idexam, $idres)
    {
        if (Session::has('key')) {
            $result = result::find($idres);
            return view('admin.score_edit', ['result' => $result, 'idexam' => $idexam, 'idres' => $idres]);
        } else {
            return view('admin.login');
        }
    }
    public function postScoreEdit(Request $request, $idexam, $idres)
    {
        if (Session::has('key')) {
            $result = result::find($idres);
            //Bắt lỗi
            $this->validate(
                $request,
                [
                    'resID' => 'required',
                    'scoreOfPunch' => 'required',
                    'scoreOfKick' => 'required',
                    'scoreOfMain' => 'required',
                    'scoreOfPractice' => 'required',
                    'scoreOfCountervailing' => 'required',
                    'scoreOfEndurance' => 'required',
                    'rank' => 'required',
                    'examiner' => 'required',
                ],
                [
                    'resID.required' => 'resID is not null',
                    'scoreOfPunch.required' => 'Score of punch is not null',
                    'scoreOfKich.required' => 'Score of kick is not null',
                    'scoreOfMain.required' => 'Score of main is not null',
                    'scoreOfPractice.required' => 'Score of practice is not null',
                    'scoreOfCountervailing.required' => 'Score of counntervailing is not null',
                    'scoreOfEndurance.required' => 'Score of endurance is not null',
                    'rank.required' => 'Rank is not null',
                    'examiner.required' => 'Examiner is not null',
                ]
            );
            $result->resID = $request->resID;
            $result->examID = $idexam;
            $result->maID = $request->maID;
            $result->scoreOfPunch = $request->scoreOfPunch;
            $result->scoreOfKich = $request->scoreOfKick;
            $result->scoreOfMain = $request->scoreOfMain;
            $result->scoreOfPractice = $request->scoreOfPractice;
            $result->scoreOfCountervailing = $request->scoreOfCountervailing;
            $result->scoreOfEndurance = $request->scoreOfEndurance;
            $result->totalScore = $request->scoreTotal;
            $result->rank = $request->rank;
            $result->examiner = $request->examiner;
            $result->resLevel = $request->resLevel;
            $result->resaccount = Session::get('coachID');
            $result->save();

            return redirect('exam_result/' . $result->examID);
        } else {
            return view('admin.login');
        }
    }

    //view diem cho vo sinh trong moi exam
    public function getScoreView(Request $request)
    {
        if (Session::has('key')) {
            $id = $request->resID;
            $query = DB::select('SELECT * FROM (result res INNER JOIN exam ex ON res.examID=ex.examID) INNER JOIN martial ma ON res.maID=ma.maID
                            WHERE res.resID=?', [$id]);

            $data = array();
            foreach ($query as $row) {
                $data[] = $row;
            }
            return json_encode($data);
        } else {
            return view('admin.login');
        }
    }

    //Tim kiem exam
    public function getSearch(Request $request)
    {
        if (Session::has('key')) {
            $examName = $request->value;
            if ($request->ajax()) {
                $output = '';
                $exam = DB::table('exam')->where('examName', 'like', '%' . $examName . '%')->get();
                if ($exam) {
                    $count = 1;
                    if (Session::get('roleID') == 'ad') {
                        foreach ($exam as $key => $exam) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td>' . $exam->examID . '</td>
                    <td>' . $exam->examName . '</td>
                    <td>' . $exam->address . '</td>
                    <td>' . $exam->dateStart . '</td>
                    <td>' . $exam->dateEnd . '</td>
                    <td>' . $exam->organizers . '</td>
                    <td><i class="fas fa-clipboard-list" onclick="location.href=\'exam_list/' . $exam->examID . '\'"></i>
                        &ensp;<i class="fas fa-list" onclick="location.href=\'exam_listin/' . $exam->examID . '\'"></i>
                        &ensp;<i class="fas fa-medal" onclick="location.href=\'exam_result/' . $exam->examID . '\'"></i>
                        &ensp;<i class="far fa-edit" onclick="location.href=\'exam_edit/' . $exam->examID . '\'"></i>
                        &ensp;<i class="far fa-trash-alt" onclick="location.href=\'exam/' . $exam->examID . '\'"></i>
                    </td>
                    </tr>';
                            $count++;
                        }
                    } else {
                        foreach ($exam as $key => $exam) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td>' . $exam->examID . '</td>
                    <td>' . $exam->examName . '</td>
                    <td>' . $exam->address . '</td>
                    <td>' . $exam->dateStart . '</td>
                    <td>' . $exam->dateEnd . '</td>
                    <td>' . $exam->organizers . '</td>
                    <td><i class="fas fa-clipboard-list" onclick="location.href=\'exam_list/' . $exam->examID . '\'"></i>
                        &ensp;<i class="fas fa-list" onclick="location.href=\'exam_listin/' . $exam->examID . '\'"></i>
                        &ensp;<i class="fas fa-medal" onclick="location.href=\'exam_result/' . $exam->examID . '\'"></i>
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

    //Tim kiem DS vo sinh trong exam
    public function getSearchList(Request $request)
    {
        if (Session::has('key')) {
            $moeName = $request->value;
            if ($request->ajax()) {
                $output = '';
                if (Session::get('roleID') == 'ad') {
                    $moe = DB::table('maofexam')->join('martial', 'maofexam.maID', '=', 'martial.maID')
                        ->join('class', 'martial.classID', '=', 'class.classID')
                        ->join('club', 'club.clubID', '=', 'class.clubID')
                        ->join('coach', 'class.coachID', '=', 'coach.coachID')
                        ->where('examID', '=', $request->examID)
                        ->where('martial.maName', 'like', '%' . $moeName . '%')
                        ->orWhere('class.className', 'like', '%' . $moeName . '%')->get();
                } else {
                    $moe = DB::table('maofexam')->join('martial', 'maofexam.maID', '=', 'martial.maID')
                        ->join('class', 'martial.classID', '=', 'class.classID')
                        ->join('club', 'club.clubID', '=', 'class.clubID')
                        ->join('coach', 'class.coachID', '=', 'coach.coachID')
                        ->where('examID', '=', $request->examID)
                        ->where('martial.maName', 'like', '%' . $moeName . '%')
                        ->where('club.manager', '=', Session::get('coachID'))->get();
                }
                if ($moe) {
                    $count = 1;
                    if (Session::get('roleID') == 'ad') {
                        foreach ($moe as $key => $moe) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td>' . $moe->maName . '</td>
                    <td>' . $moe->maDOB . '</td>
                    <td>' . $moe->clubName . '</td>
                    <td>' . $moe->className . '</td>
                    <td>' . $moe->coachName . '</td>
                    <td>' . $moe->level . '</td>
                    <td>
                    &emsp;<i class="fas fa-pencil-alt" onclick="location.href=\'' . $moe->maID . '/' . $request->examID . '\'"></i>
                    </td>
                    </tr>';
                            $count++;
                        }
                    } else {
                        foreach ($moe as $key => $moe) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td>' . $moe->maName . '</td>
                    <td>' . $moe->maDOB . '</td>
                    <td>' . $moe->clubName . '</td>
                    <td>' . $moe->className . '</td>
                    <td>' . $moe->coachName . '</td>
                    <td>' . $moe->level . '</td>
                    <td>
                    &emsp;<i class="fas fa-pencil-alt" onclick="location.href=\'' . $moe->maID . '/' . $request->examID . '\'"></i>
                    &emsp;<i class="far fa-trash-alt" onclick="deleteMoe(\'' . $moe->moeID . '\')"></i>
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

    //Tim kiem DS vo sinh khong co trong Exam
    public function getSearchListin(Request $request)
    {
        if (Session::ha('key')) {
            $moeNamein = $request->value;
            if ($request->ajax()) {
                $output = '';
                if (Session::get('roleID') == 'ad') {
                    $moein = DB::table('maofexam')->join('martial', 'maofexam.maID', '=', 'martial.maID')
                        ->join('class', 'martial.classID', '=', 'class.classID')
                        ->join('club', 'club.clubID', '=', 'class.clubID')
                        ->join('coach', 'class.coachID', '=', 'coach.coachID')
                        ->where('examID', '=', $request->examID)
                        ->where('martial.maName', 'like', '%' . $moeNamein . '%');
                } else {
                }
                if ($moein) {
                    $count = 1;
                    if (Session::get('roleID') == 'ad') {
                        foreach ($moein as $key => $moein) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td>' . $moein->maName . '</td>
                    <td>' . $moein->maDOB . '</td>
                    <td>' . $moein->clubName . '</td>
                    <td>' . $moein->className . '</td>
                    <td>' . $moein->coachName . '</td>
                    <td>' . $moein->malevel . '</td>
                    </tr>';
                            $count++;
                        }
                    } else {
                        foreach ($moein as $key => $moein) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td>' . $moein->maName . '</td>
                    <td>' . $moein->maDOB . '</td>
                    <td>' . $moein->clubName . '</td>
                    <td>' . $moein->className . '</td>
                    <td>' . $moein->coachName . '</td>
                    <td>' . $moein->malevel . '</td>
                    <td>
                    &emsp;<i class="fas fa-plus-square" onclick="insertMa(\'' . $request->examID . '\',\'' . $moein->maID . '\',\'' . $moein->malevel . '\')"></i>
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

    // filter Exam_list va Exam _Listin
    public function getfilter(Request $request)
    {
        if (Session::has('key')) {
            $selected = $request->selected;
            if ($selected == "coach") {
                if (Session::get('roleID') == "ad") {
                    $query = DB::table('coach')->select("coachName")->get();
                } else {
                    $query = DB::table('coach')->join('class', 'coach.coachID', '=', 'class.coachID')
                        ->join('club', 'class.clubID', '=', 'club.clubID')
                        ->where('club.manager', '=', Session::get('coachID'))
                        ->select("coachName")->get();
                }
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
    //Loc Exam _List
    public function getFilterList(Request $request)
    {
        if (Session::has('key')) {
            $moeName = $request->value;
            if ($request->ajax()) {
                $output = '';
                if (Session::get('roleID') == 'ad') {
                    $moe = DB::table('maofexam')->join('martial', 'maofexam.maID', '=', 'martial.maID')
                        ->join('class', 'martial.classID', '=', 'class.classID')
                        ->join('club', 'club.clubID', '=', 'class.clubID')
                        ->join('coach', 'class.coachID', '=', 'coach.coachID')
                        ->where('examID', '=', $request->examID)
                        ->where('club.clubName', 'like', '%' . $moeName . '%')
                        ->orWhere('class.className', 'like', '%' . $moeName . '%')
                        ->orWhere('coach.coachName', 'like', '%' . $moeName . '%')
                        ->orWhere('maofexam.level', 'like', $moeName)->get();
                } else {
                    $moe = DB::table('maofexam')->join('martial', 'maofexam.maID', '=', 'martial.maID')
                        ->join('class', 'martial.classID', '=', 'class.classID')
                        ->join('club', 'club.clubID', '=', 'class.clubID')
                        ->join('coach', 'class.coachID', '=', 'coach.coachID')
                        ->where('examID', '=', $request->examID)
                        ->where('club.clubName', 'like', '%' . $moeName . '%')
                        ->orWhere('class.className', 'like', '%' . $moeName . '%')
                        ->orWhere('coach.coachName', 'like', '%' . $moeName . '%')
                        ->orWhere('maofexam.level', 'like', $moeName)
                        ->where('club.manager', '=', Session::get('coachID'))->get();
                }
                if ($moe) {
                    $count = 1;
                    if (Session::get('roleID') == 'ad') {
                        foreach ($moe as $key => $moe) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td>' . $moe->maName . '</td>
                    <td>' . $moe->maDOB . '</td>
                    <td>' . $moe->clubName . '</td>
                    <td>' . $moe->className . '</td>
                    <td>' . $moe->coachName . '</td>
                    <td>' . $moe->level . '</td>
                    <td>
                    &emsp;<i class="fas fa-pencil-alt" onclick="location.href=\'' . $moe->maID . '/' . $request->examID . '\'"></i>
                    </td>
                    </tr>';
                            $count++;
                        }
                    } else {
                        foreach ($moe as $key => $moe) {
                            $output .= '<tr>
                    <td>' . $count . '</td>
                    <td>' . $moe->maName . '</td>
                    <td>' . $moe->maDOB . '</td>
                    <td>' . $moe->clubName . '</td>
                    <td>' . $moe->className . '</td>
                    <td>' . $moe->coachName . '</td>
                    <td>' . $moe->level . '</td>
                    <td>
                    &emsp;<i class="fas fa-pencil-alt" onclick="location.href=\'' . $moe->maID . '/' . $request->examID . '\'"></i>
                    &emsp;<i class="far fa-trash-alt" onclick="deleteMoe(\'' . $moe->moeID . '\')"></i>
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

    //Loc Exam_List_in
    public function getFilterListin(Request $request)
    {
        if (Session::has('key')) {
            $moeNamein = $request->value;
            if ($request->ajax()) {
                $output = '';
                if (Session::get('roleID') == 'ad') {
                    $moein = DB::table('maofexam')->join('martial', 'maofexam.maID', '=', 'martial.maID')
                        ->join('class', 'martial.classID', '=', 'class.classID')
                        ->join('club', 'club.clubID', '=', 'class.clubID')
                        ->join('coach', 'class.coachID', '=', 'coach.coachID')
                        ->where('examID', '=', $request->examID)
                        ->where('martial.maName', 'like', '%' . $moeNamein . '%');
                } else {
                }
                if ($moein) {
                    $count = 1;
                    if (Session::get('roleID') == 'ad') {
                        foreach ($moein as $key => $moein) {
                            $output .= '<tr>
                        <td>' . $count . '</td>
                        <td>' . $moein->maName . '</td>
                        <td>' . $moein->maDOB . '</td>
                        <td>' . $moein->clubName . '</td>
                        <td>' . $moein->className . '</td>
                        <td>' . $moein->coachName . '</td>
                        <td>' . $moein->malevel . '</td>
                        </tr>';
                            $count++;
                        }
                    } else {
                        foreach ($moein as $key => $moein) {
                            $output .= '<tr>
                        <td>' . $count . '</td>
                        <td>' . $moein->maName . '</td>
                        <td>' . $moein->maDOB . '</td>
                        <td>' . $moein->clubName . '</td>
                        <td>' . $moein->className . '</td>
                        <td>' . $moein->coachName . '</td>
                        <td>' . $moein->malevel . '</td>
                        <td>
                        &emsp;<i class="fas fa-plus-square" onclick="insertMa(\'' . $request->examID . '\',\'' . $moein->maID . '\',\'' . $moein->malevel . '\')"></i>
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

    //Export exam
    public function exportExam()
    {
        if (Session::has('key')) {
            return view("admin.exportExam");
        } else {
            return view("admin.login");
        }
    }
    public function getexportExam()
    {
        if (Session::has('key')) {
            $query = DB::select('SELECT * FROM exam');
            $data = array();
            foreach ($query as $row) {
                $data[] = $row;
            }
            echo json_encode($data);
        } else {
            return view('admin.login');
        }
    }

    //Export DS VS co trong ky thi
    public function exportExamList($id)
    {
        if (Session::has('key')) {
            return view("admin.exportExamList", ["examID" => $id]);
        } else {
            return view("admin.login");
        }
    }
    public function getexportExamList(Request $request)
    {
        if (Session::has('key')) {
            $query = DB::select('SELECT * FROM (((maofexam moe INNER JOIN martial ma ON moe.maID=ma.maID) INNER JOIN class c ON ma.classID=c.classID) INNER JOIN club cl ON c.clubID=cl.clubID) INNER JOIN coach co ON c.coachID=co.coachID WHERE moe.examID = \'' . $request->examID . '\'');
            $data = array();
            foreach ($query as $row) {
                $data[] = $row;
            }
            echo json_encode($data);
        } else {
            return view('admin.login');
        }
    }

    //Export DS VS co trong ky thi
    public function exportExamListIn($id)
    {
        if (Session::has('key')) {
            //echo $id;
            return view("admin.exportExamListIn", ["examID" => $id]);
        } else {
            return view("admin.login");
        }
    }
    public function getexportExamListIn(Request $request)
    {
        if (Session::has('key')) {
            $query = DB::select('SELECT * 
                                FROM martial m INNER JOIN class c ON m.classID=c.classID INNER JOIN club cl ON c.clubID=cl.clubID INNER JOIN coach co ON c.coachID=co.coachID
                                WHERE NOT EXISTS (SELECT moe.maID
                                                FROM maofexam moe INNER JOIN exam ex ON moe.examID =ex.examID 
                                                WHERE moe.maID=m.maID AND moe.examID="' . $request->examID . '")');
            $data = array();
            foreach ($query as $row) {
                $data[] = $row;
            }
            echo json_encode($data);
        } else {
            return view('admin.login');
        }
    }

    //check exam ID
    public function checkexamID(Request $request)
    {
        $examID =  $request->examID;

        $data = DB::table('exam')->where('examID','=',$examID)->get();
        echo $data;

    }
}

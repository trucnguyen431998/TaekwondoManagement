<?php

namespace App\Http\Controllers;

use App\club;
use App\exam;
use App\coach;
use App\martial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class mainController extends Controller
{
    //
    //Gọi trang Dashboard
    public function getDashboard()
    {
        if (Session::has('key')) {
            $queryclub = DB::table("club")->count();
            $queryexam = DB::table("exam")->count();
            $querycoach = DB::table("coach")->count();
            $querymartial = DB::table("martial")->count();
            return view('admin.dashboard', ['queryclub' => $queryclub, 'queryexam' => $queryexam, 'querycoach' => $querycoach, 'querymartial' => $querymartial]);
        } else {
            return view('admin.login');
        }
    }
    public function getChart01()
    {
        $queryChart= DB::select("SELECT cl.clubID,COUNT(c.classID) AS 'countClass' FROM class c INNER JOIN 
        club cl ON cl.clubID=c.clubID GROUP BY cl.clubID");

        $data = array(); 
        //Chuyen thanh json
        foreach($queryChart as $row)
        {
            $data[] = $row;
        }
        return json_encode($data);
        //return view('admin.dashboard',['dataChart'=>$en_json]);
    }

    public function getChart02()
    {
        $queryChart= DB::select("SELECT c.classID,COUNT(m.maID) AS 'countMartial' 
                                 FROM class c INNER JOIN martial m ON c.classID=m.classID GROUP BY c.classID");

        $data = array(); 
        //Chuyen thanh json
        foreach($queryChart as $row)
        {
            $data[] = $row;
        }
        return json_encode($data);
        //return view('admin.dashboard',['dataChart'=>$en_json]);
    }



    public function getScoreView()
    {
        return view('admin.score_view');
    }
    public function getScoreAdd()
    {
        return view('admin.score_add');
    }
    public function getScoreEdit()
    {
        return view('admin.score_edit');
    }

    public function getCalendar()
    {
        if (request()->ajax()) {
            $data = array();
            $query = DB::select('SELECT * FROM exam ORDER BY examID');
            foreach ($query as  $row) {
                $data[] = array(
                    'id'   => ($row->examID),
                    'title'   => ($row->examName),
                    'start'   => ($row->dateStart),
                    'end'   => ($row->dateEnd)
                );

                //$array = Arr::add(['id' =>  $row->tourID], ['title'=> $row->tourName], ['start'=> $row->openingTime],['end'=> $row->endTime]);
            }
            return json_encode($data);
        }
    }
}

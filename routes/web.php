<?php

use App\Http\Controllers\mainController;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//mainController
Route::get('dashboard', 'mainController@getDashboard');
Route::get('chart01', 'mainController@getChart01');
Route::get('chart02', 'mainController@getChart02');
Route::get('calendar', 'mainController@getCalendar');


//clubController
//Hien thi DS CLB
Route::get('club', 'clubController@getClub');
//Them CLB
Route::get('club_add', 'clubController@getClubAdd');
Route::post('club_add', 'clubController@postClubAdd');
//Sua CLB
Route::get('club_edit/{id}', 'clubController@getClubEdit');
Route::post('club_edit/{id}', 'clubController@postClubEdit');
//Xoa CLB
// Route::get('club/{id}', 'clubController@getClubDelete');
Route::get('deleteclub', 'clubController@getClubDelete');
//View chi tiet CLB
Route::get('club_view', 'clubController@getDetailClub');
//Lich su CLB
Route::get('club_history', 'clubController@getClubHistory');
//Hien thi DS HLV cua moi CLB
Route::get('popup', 'clubController@getpopup');
//Tim kiem CLB
Route::get('searchclub','clubController@getSearch');
//filter CLB
Route::get('filtercl', 'clubController@getfiltercl');
//Loc CLB
Route::get('filterclub','clubController@getFilter');
// export club
Route::get('exportclub','clubController@exportClub');
Route::get('getexportclub','clubController@getexportClub');
//load hinh them CLB
Route::post('image-upload', 'clubController@imageUploadClubAdd')->name('image.uploadclubadd.post');
//load hinh sua CLB
Route::post('image-upload-edit', 'clubController@imageUploadClubEdit')->name('image.uploadclubedit.post');
//check club ID
Route::get('checkClubID','clubController@checkclubID');


//classController

//Hien thi DS lop hoc cua moi CLUB
Route::get('class/{id}', 'classController@getClass');
//Them Class - CHUA DUOC
Route::get('class_add', 'classController@getClassAdd');
Route::post('class_add', 'classController@postClassAdd');
//Sua Class
Route::get('class/{idclub}/{idclass}', 'classController@getClassEdit');
Route::post('class/{idclub}/{idclass}', 'classController@postClassEdit');
//Xoa Class
// Route::get('class/delete/{idclub}/{idclass}', 'classController@getClassDelete');
Route::get('classdelete', 'classController@getClassDelete');
//Lich su Class
Route::get('class_history', 'classController@getClassHistory');
//Hien thi DS Vo sinh cua moi lop
Route::get('popupclass', 'classController@getPopup');
//Tim kiem lop
Route::get('searchclass','classController@getSearch');
//export lop
Route::get('class/exportclass/export/{id}','classController@exportClass');
Route::get('getexportclass','classController@getexportClass');
//load hinh them lop
Route::post('image-upload-class-add', 'classController@imageUploadClassAdd')->name('image.uploadclassadd.post');
//load hinh sua vo sinh
Route::post('image-upload-class-edit', 'classController@imageUploadClassEdit')->name('image.uploadclassedit.post');
//check class ID
Route::get('checkClassID','classController@checkclassID');


//coachController
//Dang nhap
Route::get('login', 'coachController@getLogin');
Route::post('login', 'coachController@postLogin');
//Dang xuat
Route::get('/detroySession', 'coachController@detroySesion');
//Hien thi DS HLV
Route::get('coach', 'coachController@getCoach');
//Them HLV
Route::get('coach_add', 'coachController@getCoachAdd');
Route::post('coach_add', 'coachController@postCoachAdd');
//Sua HLV
Route::get('coach_edit/{id}', 'coachController@getCoachEdit');
Route::post('coach_edit/{id}', 'coachController@postCoachEdit');
//Xoa HLV
// Route::get('coach/{id}', 'coachController@getCoachDelete');
Route::get('coachdelete', 'coachController@getCoachDelete');
//View HLV
Route::get('coach_view/{id}', 'coachController@getCoachView');
//Lich su HLV
Route::get('coach_history', 'coachController@getCoachHistory');
//Hien thi DS lop cua moi HLV
Route::get('popupcoach', 'coachController@getPopup');
//Tim kiem vo sinh
Route::get('searchcoach','coachController@getSearch');
// export HLV
Route::get('exportcoach','coachController@exportCoach');
Route::get('getexportcoach','coachController@getexportCoach');
//load hinh them HLV
Route::post('image-upload-coach-add', 'coachController@imageUploadCoachAdd')->name('image.uploadcoachadd.post');
//load hinh sua HLV
Route::post('image-upload-coach-edit', 'coachController@imageUploadCoachEdit')->name('image.uploadcoachedit.post');
// checkcoahID
Route::get('checkCoachID','coachController@checkcoachID');


//martialController
//Hien thi DS Vo sinh
Route::get('martial', 'martialController@getMartial');
//Them Vo sinh
Route::get('martial_add', 'martialController@getMartialAdd');
Route::post('martial_add', 'martialController@postMartialAdd');
//Sua Vo sinh
Route::get('martial_edit/{id}', 'martialController@getMartialEdit');
Route::post('martial_edit/{id}', 'martialController@postMartialEdit');
//Xoa Vo sinh
// Route::get('martial/{id}', 'martialController@getMartialDelete'); 
Route::get('martialdelete', 'martialController@getMartialDelete'); 
//View Vo sinh
Route::get('martial_view/{id}', 'martialController@getMartialView');
//Lich su Vo sinh
Route::get('martial_history', 'martialController@getMartialHistory');
//Tim kiem vo sinh
Route::get('searchmartial','martialController@getSearch');
//filter vo sinh
Route::get('filtermartial', 'martialController@getfilter');
//Loc vo sinh
Route::get('filtermartialma','martialController@getFilterMA');
//export vo sinh
Route::get('exportmartial','martialController@exportMartial');
Route::get('getexportmartial','martialController@getexportMartial');
//load hinh them vo sinh
Route::post('image-upload-ma-add', 'martialController@imageUploadMartialAdd')->name('image.uploadmaadd.post');
//load hinh sua vo sinh
Route::post('image-upload-martial-edit', 'martialController@imageUploadMartialEdit')->name('image.uploadmaedit.post');
//check ma ID
Route::get('checkmaID','martialController@checkmaID');


//examController
//Hien thi DS ky thi
Route::get('exam', 'examController@getExam');
//Them ky thi
Route::get('exam_add', 'examController@getExamAdd');
Route::post('exam_add', 'examController@postExamAdd');
//Sua ky thi
Route::get('exam_edit/{id}', 'examController@getExamEdit');
Route::post('exam_edit/{id}', 'examController@postExamEdit');
//Xoa ky thi
// Route::get('exam/{id}', 'examController@getExamDelete');
Route::get('examdelete', 'examController@getExamDelete');
//Lich su ky thi
Route::get('exam_history', 'examController@getExamHistory');
//Hien thi DS VS co trong ky thi
Route::get('exam_list/{id}', 'examController@getExamList');
//Hien thi DS VS chua co trong ky thi 
Route::get('exam_listin/{idexam}', 'examController@getExamListin');
//Them vo sinh vao DS thi
Route::get('exam_listadd', 'examController@getMartialAddList');
//xoa vo sinh ra DS thi
Route::get('exam_listdelete', 'examController@getMartialDeleteList');
//Ket qua ky thi
Route::get('exam_result/{idexam}', 'examController@getExamResult');
//Nhap diem cho vo sinh
Route::get('exam_list/{maID}/{examID}', 'examController@getScore');
Route::post('exam_list/{maID}/{examID}', 'examController@postScore');
//Sua diem cho vo sinh
Route::get('exam_result/{idexam}/{idres}', 'examController@getScoreEdit');
Route::post('exam_result/{idexam}/{idres}', 'examController@postScoreEdit');
//View chi tiet diem cua vo sinh
Route::get('score_view', 'examController@getScoreView');
//Tim kiem ky thi
Route::get('searchexam','examController@getSearch');
//Tim kiem DS vo sinh trong ky thi
Route::get('searchexamlist','examController@getSearchList');
//Tim kiem DS vo sinh khong co trong ky thi
Route::get('searchexamlistin','examController@getSearchListin');
//filter ky thi
Route::get('filterexam', 'examController@getfilter');
//Loc danh sach vo sinh thi
Route::get('filterlistma', 'examController@getFilterList');
//Loc danh sach vo sinh khong thi
Route::get('filterlistinma', 'examController@getFilterListin');
//export DS ky thi
Route::get('exportexam','examController@exportExam');
Route::get('getexportexam','examController@getexportExam');
//export DS VS co trong ky thi
Route::get('exam_list/exportexamlist/export/{id}','examController@exportExamList');
Route::get('getexportexamlist','examController@getexportExamList');
//export DS VS chua co trong ky thi
Route::get('exam_listin/exportexamlistin/export/{id}','examController@exportExamListIn');
Route::get('getexportexamlistin','examController@getexportExamListIn');
//check exam ID
Route::get('checkExamID','examController@checkexamID');


//revenuesController
Route::get('revenues', 'revenuesController@getRevenues');
//Bieu do 01
Route::get('chartRev01', 'revenuesController@getChart01');
//Bieu do 02
Route::get('chartRev02', 'revenuesController@getChart02');
//Hien thi DS ND thu
Route::get('revenues_col', 'revenuesController@getRevenuesCol');
//Them ND thu
Route::get('revenues_col_add', 'revenuesController@getRevenuesColAdd');
Route::post('revenues_col_add', 'revenuesController@postRevenuesColAdd');
//Sua ND thu
Route::get('revenues_col_edit/{id}', 'revenuesController@getRevenuesColEdit');
Route::post('revenues_col_edit/{id}', 'revenuesController@postRevenuesColEdit');
//Xoa ND thu
// Route::get('revenues_col/{id}', 'revenuesController@getRevenuesColDelete');
Route::get('revenues_col_delete', 'revenuesController@getRevenuesColDelete');
//List ND thu
Route::get('revenues_col_listcom', 'revenuesController@getRevenuesColListcom');
//Lich su ND thu
Route::get('revenues_col_history', 'revenuesController@getRevenuesColHistory');
//Hien thi DS vo sinh da dong tien
Route::get('revenues_col_listcom/{id}', 'revenuesController@getRevenuesColListcom');
//Hien thi DS vo sinh chua dong tien
Route::get('revenues_col_listincom/{idrev}/{idclub}', 'revenuesController@getRevenuesColListincom');
//Lap bien lai
Route::get('revenues_col_listcommm', 'revenuesController@getRevenuesColRecipt');
//Xoa bien lai
Route::get('revenues_col_listcommt', 'revenuesController@getRevenuesColReciptDelete');
//Tim kiem ND thu
Route::get('searchrev','revenuesController@getSearch');
//Tim kiem DS vo sinh da dong hoc phi
Route::get('searchrevlist','revenuesController@getSearchList');
//Loc ND thu
Route::get('filterrevenues','revenuesController@getFilterRev');
//export DS ND thu
Route::get('exportrev','revenuesController@exportRev');
Route::get('getexportrev','revenuesController@getexportRev');
//export DS vo sinh da dong HP
Route::get('revenues_col_listcom/exportlistcom/export/{id}','revenuesController@exportRevList');
Route::get('getexportlistcom','revenuesController@getexportRevList');
//export DS vo sinh chua dong HP
Route::get('revenues_col_listincom/exportlistcomin/exportlist/{id}','revenuesController@exportRevListIn');
Route::get('getexportlistincom','revenuesController@getexportRevListIn');
Route::get('getclass','revenuesController@getClass');
//check rev ID
Route::get('checkRevID','revenuesController@checkrevID');


//payController
//Hien thi DS ND chi
Route::get('revenues_pay', 'payController@getRevenuesPay');
//Them ND chi
Route::get('revenues_pay_add', 'payController@getRevenuesPayAdd');
Route::post('revenues_pay_add', 'payController@postRevenuesPayAdd');
//Sua ND chi
Route::get('revenues_pay_edit/{id}', 'payController@getRevenuesPayEdit');
Route::post('revenues_pay_edit/{id}', 'payController@postRevenuesPayEdit');
//Xoa ND chi
// Route::get('revenues_pay/{id}', 'payController@getRevenuesPayDelete');
Route::get('revenues_pay_delete', 'payController@getRevenuesPayDelete');
//Lich su ND chi
Route::get('revenues_pay_history', 'payController@getRevenuesPayHistory');
//Loc ND chi
Route::get('filterpay','payController@getFilterPay');
//Mo ta chi tiet ND chi
Route::get('popuppay', 'payController@getPopup');
//Tim kiem ND chi
Route::get('searchpay','payController@getSearch');
//export DS ND thu
Route::get('exportpay','payController@exportPay');
Route::get('getexportpay','payController@getexportPay');
//check pay ID
Route::get('checkPayID','payController@checkpayID');



//1 coach - n club va 1 club - 1 coach
Route::get('relationship_coach_club', function () {
    $coach=App\coach::all();
    foreach($coach as $coach){
        echo $coach->coachName;
        echo '<br>';
        foreach($coach->club as $clubName){
            echo $clubName->clubName.' - ';
        }
        echo '<hr>'; 
    }
});
Route::get('relationship_club_coach', function () {
    $club = App\club::all();
    foreach ($club as $club) {
        echo $club->clubName;
        echo '<br>';
        echo $club->coach->coachName;
        echo '<hr>';
    }
});


//1 role - n coach va 1 coach - 1 role
Route::get('relationship_role_coach', function () {
    $role=App\role::all();
    foreach($role as $role){
        echo $role->roleName;
        echo '<br>';
        foreach($role->coach as $coachName){
            echo $coachName->coachName.' - ';
        }
        echo '<hr>'; 
    }
});
Route::get('relationship_coach_role', function () {
    $coach = App\coach::all();
    foreach ($coach as $coach) {
        echo $coach->coachName;
        echo '<br>';
        echo $coach->role->roleName;
        echo '<hr>';
    }
});


//1 club - n class va 1 class - 1 club
Route::get('relationship_club_class', function () {
    $club=App\club::all();
    foreach($club as $club){
        echo $club->clubName;
        echo '<br>';
        foreach($club->class as $className){
            echo $className->className.' - ';
        }
        echo '<hr>'; 
    }
});
Route::get('relationship_class_club', function () {
    $class = App\classes::all();
    foreach ($class as $class) {
        echo $class->className;
        echo '<br>';
        echo $class->club->clubName;
        echo '<hr>';
    }
});



//1 class - n martial va 1 martial - 1 class
Route::get('relationship_class_martial', function () {
    $class=App\classes::all();
    foreach($class as $class){
        echo $class->className;
        echo '<br>';
        foreach($class->martial as $maName){
            echo $maName->maName.' - ';
        }
        echo '<hr>';
    }
});
Route::get('relationship_martial_class', function () {
    $martial = App\martial::all();
    foreach ($martial as $martial) {
        echo $martial->maName;
        echo '<br>';
        echo $martial->class->className;
        echo '<hr>';
    }
});

//1 coach - n class va 1 class - 1 coach
Route::get('relationship_coach_class', function () {
    $coach=App\coach::all();
    foreach($coach as $coach){
        echo $coach->coachName;
        echo '<br>';
        foreach($coach->class as $className){
            echo $className->className.' - ';
        }
        echo '<hr>';
    }
});
Route::get('relationship_class_coach', function () {
    $class=App\classes::all();
    foreach($class as $class){
        echo $class->className;
        echo '<br>';
        echo $class->coach->coachName;
        echo '<hr>';
    }
});


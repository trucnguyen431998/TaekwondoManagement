@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <!-- Tên kỳ thi trong CSDL -->
    <h2><span class="fa fa-calendar fa-fw mr-3"></span>RESULT OF EXAM</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="{{action('examController@getExam')}}">Exam</a> &emsp; / &emsp; Result of exam &emsp;&emsp; </div>


<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-4">
            <!-- Filter -->
            <!-- <input type="text" class="form-control" /> -->
        </div>
        <div class="col-4">
            <!-- Filter -->
            <!-- <input type="text" class="form-control" /> -->
        </div>
    </div>
    <div class="row mt-4">
        <table class="table table-striped table-hover" style="font-size: 15px; background: #eee;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">DOB</th>
                    <th scope="col">Class</th>
                    <th scope="col">Coach</th>
                    <th scope="col">Level</th>
                    <th scope="col">Total Score</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <?php $i = 1; ?>
            <tbody>
                @foreach($data as $row)
                <tr>
                    <th scope="row"><?php echo $i++; ?></th>
                    <td>{{$row->maName}}</td>
                    <td>{{$row->maDOB}}</td>
                    <td>{{$row->className}}</td>
                    <td>{{$row->coachName}}</td>
                    <td>{{$row->resLevel}}</td>
                    <td>{{$row->totalScore}}</td>
                    <td>
                        @if (Session::get('roleID')=="ad")
                        <!-- Button sua kết quả của võ sinh --><i class="far fa-edit" onclick="location.href='{{$row->examID}}/{{$row->resID}}'"></i></a>
                        @endif
                        <!-- Button view kết quả của võ sinh -->&emsp;<i class="far fa-eye" onclick="viewResult('{{$row->resID}}')" data-toggle="modal" data-target=".bs-example-modal-lg"></i>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <!-- Popup Danh sách lop của mỗi HLV giang day -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="row mt-4">
                    <div class="col-2"></div>
                    <div class="col-2" style="background-color: #000033; color: #fff;">
                        <b>
                            <div class="row mt-4" style="padding-left: 20px; font-size: 27px;" id="maName"></div>
                        </b>
                    </div>
                    <div class="col-6" style="background-color: #ccffff; color:#000033">
                        <!-- START Basic Information -->
                        <div class="row mt-3">
                            <div class="col">
                                <b><span class="fas fa-atom fa-fw mr-3"></span>Basic Information</b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">&ensp; Gender</div>
                            <div class="col-8" id="maGender"></div> <!-- Giới tính trong CSDL -->
                        </div>
                        <div class="row">
                            <div class="col-4">&ensp; DOB</div>
                            <div class="col-8" id="maDOB"></div> <!-- DOB trong CSDL -->
                        </div>
                        <div class="row">
                            <div class="col-4">&ensp; Phone</div>
                            <div class="col-8" id="phone"></div> <!-- Phone trong CSDL -->
                        </div>
                        <div class="row">
                            <div class="col-4">&ensp; School</div>
                            <div class="col-8" id="school">Di An Highschool</div> <!-- School trong CSDL -->
                        </div>
                        <!-- END Basic Information -->

                        <!-- START score Information -->
                        <div class="row mt-4" style="font-size: 18px;">
                            <b>
                                <div class="col" id="examName"></div>
                            </b>
                        </div>
                        <div class="row mt-1" style="color:#000033;">
                            <div class="col-5">&ensp; Organizers</div>
                            <div class="col-7" id="organizers"></div> <!-- Organizers trong CSDL -->
                        </div>
                        <div class="row mt-1" style="color:#000033;">
                            <div class="col-5">&ensp; Punch</div>
                            <div class="col-6" id="scorePunch"></div> <!-- score of Punch trong CSDL -->
                        </div>
                        <div class="row mt-1" style="color:#000033;">
                            <div class="col-5">&ensp; Kick</div>
                            <div class="col-6" id="scoreKick"></div> <!-- score of Kick trong CSDL -->
                        </div>
                        <div class="row mt-1" style="color:#000033;">
                            <div class="col-5">&ensp; Main</div>
                            <div class="col-6" id="scoreMain"></div> <!-- score of Main trong CSDL -->
                        </div>
                        <div class="row mt-1" style="color:#000033;">
                            <div class="col-5">&ensp; Practice</div>
                            <div class="col-6" id="scorePractice"></div> <!-- score of Practice trong CSDL -->
                        </div>
                        <div class="row mt-1" style="color:#000033;">
                            <div class="col-5">&ensp; Countervailing</div>
                            <div class="col-6" id="scoreCountervailing"></div> <!-- score of Countervailing trong CSDL -->
                        </div>
                        <div class="row mt-1" style="color:#000033;">
                            <div class="col-5">&ensp; Endurance</div>
                            <div class="col-6" id="scoreEndurance"></div> <!-- score of Countervailing trong CSDL -->
                        </div>
                        <div class="row mt-1" style="color:#000033;">
                            <div class="col-5">&ensp; Total</div>
                            <div class="col-6" id="scoreTotal"></div> <!-- score of total trong CSDL -->
                        </div>
                        <div class="row mt-1" style="color:#000033;">
                            <div class="col-5">&ensp; Rank</div>
                            <div class="col-6" id="rank"></div> <!-- rank trong CSDL -->
                        </div>
                        <div class="row mt-1" style="color:#000033;">
                            <div class="col-5">&ensp; Level</div>
                            <div class="col-6" id="resLevel"></div> <!-- Level trong CSDL -->
                        </div><br>
                        <!-- END score Information -->

                    </div>
                </div><br/>
            </div>
        </div>
        
    </div>

</div>

<script>
    function viewResult(resID) {
        $s = $($)
        $.ajax({
            url: '{{action("examController@getScoreView")}}',
            type: 'GET',
            dataType: 'JSON',
            data: {
                resID: resID
            },
            success: function(data) {
                if (data.length > 0) {
                    $('#maName').text(data[0].maName);
                    $('#maGender').text(data[0].maGender);
                    $('#maDOB').text(data[0].maDOB);
                    $('#phone').text(data[0].phone);
                    $('#school').text(data[0].school);
                    $('#examName').text(data[0].examName);
                    $('#organizers').text(data[0].organizers);
                    $('#scorePunch').text(data[0].scoreOfPunch);
                    $('#scoreKick').text(data[0].scoreOfKich);
                    $('#scoreMain').text(data[0].scoreOfMain);
                    $('#scorePractice').text(data[0].scoreOfPractice);
                    $('#scoreCountervailing').text(data[0].scoreOfCountervailing);
                    $('#scoreEndurance').text(data[0].scoreOfEndurance);
                    $('#scoreTotal').text(data[0].totalScore);
                    $('#resLevel').text(data[0].resLevel);
                    $('#rank').text(data[0].rank);
                }
            }

        });
    }
</script>
@endsection
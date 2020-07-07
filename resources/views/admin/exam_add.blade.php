@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fa fa-calendar fa-fw mr-3"></span>ADD EXAM</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="exam">Exam</a> &emsp; / &emsp; Add Exam</div>


<div class="container-fluid">
    <div class="row mt-4"></div>
    @if(count($errors)>0)
    <div class="alert alert-danger">
        @foreach($errors->all() as $err)
        {{$err}}<br>
        @endforeach
    </div>
    @endif

    @if(session('thongbao'))
    <div class="alert alert-success">
        {{session('thongbao')}}
    </div>
    @endif
    <form action="exam_add" method="POST">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        <!-- Exam ID -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">ExamID</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" id="examID" name="examID" onfocusout="alertmaExam();" /></div>
            <p id ="alertt" style="color: red;" >examID is exsists!!!</p>
        </div>
        <!-- Exam's Name -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Exam's Name</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="examName" /></div>
        </div>

        <!-- Address of exam -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Address</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="address" /></div>
        </div>

        <!-- Date Start-->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Date start</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="datetime-local" class="form-control" id="dateStart" name="dateStart" onchange="validDate();"/></div>
        </div>

        <!-- Date End -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Date end</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="datetime-local" class="form-control" id="dateEnd" name="dateEnd" onchange="validDate();" /></div>
            <p id="alertCheck" style="color: red;"></p>
        </div>

        <!-- Organizers -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Organizers</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="organizers" /></div>
        </div>

        <!-- Note -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Note</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="note" /></div>
        </div>

        <!-- Button -->
        <div class="row mt-4">
            <div class="col-9 text-right">
                <button class="button" type="submit" style="color: #0099ff; font-size: 15px;" id="menu-toggle"><i class="far fa-save"></i>&nbsp; Save</button>
            </div>
        </div>
    </form>
</div>
<script>
    //Rang buoc ngay start - end
    function validDate() {
        var dateStart = document.getElementById("dateStart").value;
        var dateEnd = document.getElementById("dateEnd").value;
        if (dateStart > dateEnd) {
            $("#alertCheck").text("Date start is greater than date end!!!");
            $("#menu-toggle").attr("disabled", true);

        } else {
            $("#alertCheck").text("");
            $("#menu-toggle").attr("disabled", false);
        }
    }

    //Bao loi khi trung ma
    $(document).ready(function(){
        $('#alertt').hide();
    });

    function alertmaExam()
    {
        var examID = $("#examID").val();
        //alert(examID); 
        $.ajax({

            url:'{{action("examController@checkexamID")}}',
            type:'GET',
            data:{examID:examID},
            success:function(data){
              if (data.length == 2)
              {
                $('#alertt').hide();
               
                $('#menu-toggle').attr('disabled',false);

              }
              else
              {
                $('#alertt').show();
               $('#menu-toggle').attr('disabled',true);
              }
            }

        });
    }
</script>
@endsection
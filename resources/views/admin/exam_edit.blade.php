@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fa fa-calendar fa-fw mr-3"></span>EDIT EXAM</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="{{action('examController@getExam')}}">Exam</a> &emsp; / &emsp; Edit Exam </div>


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
    <form action="{{$id}}" method="POST">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        <!-- ExamID -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">ExamID</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="examID" value="{{$id}}" /></div>
        </div>

        <!-- Exam's Name -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Exam's Name</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="examName" value="{{$exam->examName}}" /></div>
        </div>

        <!-- Address of exam -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Address</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="address" value="{{$exam->address}}" /></div>
        </div>

        <!-- Date Start-->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Date start</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="datetime-local" class="form-control" name="dateStart" id="dateStart" value="{{$exam->dateStart}}" onchange="validDate();"/></div>
        </div>

        <!-- Date End -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Date end</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="datetime-local" class="form-control" name="dateEnd" id="dateEnd" value="{{$exam->dateEnd}}" onchange="validDate();"/></div>
            <p id="alertCheck" style="color: red;"></p>
        </div>

        <!-- Organizers -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Organizers</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="organizers" value="{{$exam->organizers}}" /></div>
        </div>

        <!-- Note -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Note</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="note" value="{{$exam->note}}" /></div>
        </div>

        <!-- Button -->
        <div class="row mt-4">
            <div class="col-9 text-right">
                <button class="button" id="submitAdd" style="color: #0099ff; font-size: 15px;" id="menu-toggle"><i class="far fa-save"></i>&nbsp; Save</button>
            </div>
    </form>
</div>

<script>
    function validDate() {
        var dateStart = document.getElementById("dateStart").value;
        var dateEnd = document.getElementById("dateEnd").value;
        if (dateStart > dateEnd) {
            $("#alertCheck").text("Date start is greater than date end!!!");
            $("#submitAdd").attr("disabled", true);

        } else {
            $("#alertCheck").text("");
            $("#submitAdd").attr("disabled", false);
        }
    }
</script>
@endsection
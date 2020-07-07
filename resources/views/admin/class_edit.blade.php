@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fas fa-chalkboard fa-fw mr-3"></span>EDIT CLASS</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp;<a href="{{action('clubController@getClub')}}">Club</a> &emsp; / &emsp; Class</a> &emsp; / &emsp; Edit class &emsp; / &emsp; {{$class->className}}</div>


<div class="container-fluid">
    <div class="row mt-4"></div>
    @if(session('thongbao'))
    <div class="alert alert-success">
        {{session('thongbao')}}
    </div>
    @endif

    <form action="{{ route('image.uploadclassedit.post') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        <div class="row mt-2 mb-2" style="background-color: #000;">
            <div class="col-1"></div>
            <div class="col-3 card card-body">
                <div class="row">
                    <div class="col">
                        @if ($message = Session::get('success'))
                        <img src="/projectTruc/public/imageClass/{{ Session::get('image')}}" width="220" height="150">
                        @else
                        <img id="hinh" src="{{asset($class->classImage) }}" width="220" height="150" />
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-8 mt-2"><input type="file" id="file" class="form-control" name="image" /></div>
                    <div class="col-1 mt-2"><button type="submit" id="p" class="button" style="color: #0099ff; font-size: 18px;"><i class="fas fa-upload"></i></button></div>
                </div>
            </div>
        </div>
    </form>

    <form action="{{$id}}" method="POST">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        @if ($message = Session::get('success'))
        <input type="hidden" name="classImage" value="imageClass/{{ Session::get('image1')}}">
        @else
        <input type="hidden" name="classImage" value="{{$class->classImage}}">
        @endif



        <div class="row mt-4" style="color: #fff;">
            <div class="col-xl-6 col-lg-6">
                <div class="row" style="color: #fff; font-size: 25px;">
                    <div class="col">
                        <b><span class="fas fa-atom fa-fw mr-3"></span>Basic Information</b>
                    </div>
                </div>
                <div class="row">
                    <div class="col">Club's name:</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- Club Name -->
                        <select name="clubID" id="clubID" class="form-control">
                            @foreach($data1 as $row)
                            <option value="{{$row->clubID}}">{{$row->clubName}}</option>
                            @endforeach

                            @foreach($dataclub as $row)
                            <option value="{{$row->clubID}}">{{$row->clubName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col">Class ID:</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- input nhập Class ID -->
                        <input type="text" class="form-control" name="classID" value="{{$id}}" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">Class's Name:</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- input nhập Class Name -->
                        <input type="text" class="form-control" name="className" value="{{$class->className}}" />
                        <p></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col">Coach's Name:</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- input nhập Coach Name -->
                        <select name="coachID" id="coachID" class="form-control">
                            @foreach($data1 as $row)
                            <option value="{{$row->coachID}}">{{$row->coachName}}</option>
                            @endforeach
                            @foreach($datacoach as $row)
                            <option value="{{$row->coachID}}">{{$row->coachName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col">Assistant:</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- input nhập Assistant -->
                        <input type="text" class="form-control" name="assistant" />
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6">
                <div class="row" style="color: #fff; font-size: 25px;">
                    <div class="col">
                        <b><span class="fab fa-battle-net fa-fw mr-3"></span>Contact Information</b>
                    </div>
                </div>

                <div class="row">
                    <div class="col">Date:</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- Date -->
                        <input type="text" class="form-control" name="date" value="{{$class->date}}" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">Start Time:</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- input nhập Start Time -->
                        <input type="time" class="form-control" name="startTime" id="startTime" value="{{$class->startTime}}" onchange="checkTime();" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">End Time:</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- input nhập End Time -->
                        <input type="time" class="form-control" name="endTime" value="{{$class->endTime}}" id="endTime" onchange="checkTime();" />
                        <p id="alertCheck" style="color: red;"></p>
                    </div>
                </div>
                <script>
                    function checkTime() {
                        var start = $("#startTime").val();
                        var endTime = $("#endTime").val();
                        //alert(start + "-" +endTime);

                        if (start > endTime) {
                            $("#alertCheck").text("time start is greater than time end!!!");
                            $("#submitAdd").attr("disabled", true);

                        } else {
                            $("#alertCheck").text("");
                            $("#submitAdd").attr("disabled", false);
                        }
                    }
                </script>

                <div class="row">
                    <div class="col">Rental Money:</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- input nhập Rental Money -->
                        <input type="text" class="form-control" name="rentalMoney" value="{{$class->rentalMoney}}" />
                    </div>
                </div>

                <!-- <div class="row"><div class="col"></div></div> -->
                <div class="row mt-4">
                    <div class="col text-right">
                        <!-- Button -->
                        <button class="button" type="submit" id="submitAdd" style="color: #0099ff; font-size: 15px;" id="menu-toggle"><i class="far fa-save"></i>&nbsp; Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
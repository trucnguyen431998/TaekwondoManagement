@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fas fa-chalkboard fa-fw mr-3"></span>ADD CLASS</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp;<a href="{{action('clubController@getClub')}}"> Club</a> &emsp; / &emsp; Class</a> &emsp; / &emsp; Add class</div>


<div class="container-fluid">
    <div class="row mt-4"></div>
    @if(session('thongbao'))
    <div class="alert alert-success">
        {{session('thongbao')}}
    </div>
    @endif

    <form action="{{ route('image.uploadclassadd.post') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        <div class="row mt-2 mb-2" style="background-color: #000;">
            <div class="col-1"></div>
            <div class="col-3 card card-body">
                <div class="row">
                    <div class="col">
                        @if ($message = Session::get('success'))
                        <img src="imageClass/{{ Session::get('image')}}" width="220" height="150">
                        @else
                        <img id="hinh" src="imageClass/1588870845.jpg" width="220" height="150" />
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

    <form action="class_add" method="POST">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        @if ($message = Session::get('success'))
        <input type="hidden" name="classImage" value="imageClass/{{ Session::get('image1')}}">
        @else
        <input type="hidden" name="classImage" value="imageClass/1588870845.jpg">
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
                            @foreach($dataclub as $row)
                            <option value="{{$row->clubID}}">{{$row->clubName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col">Class ID:</div>
                    <p id ="alertt" style="color: red;" >classID is exsists!!!</p>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- input nhập Class ID -->
                        <input type="text" class="form-control" id="classID" name="classID" onfocusout="alertmaClass();" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">Class's Name:</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- input nhập Class Name -->
                        <input type="text" class="form-control" name="className" />
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
                        <input type="text" class="form-control" name="date" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">Start Time:</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- input nhập Start Time -->
                        <input type="time" class="form-control" id="startTime" name="startTime" onchange="checkTime();" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">End Time:</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- input nhập End Time -->
                        <input type="time" class="form-control" id="endTime" name="endTime" onchange="checkTime();" />
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
                            $("#menu-toggle").attr("disabled", true);

                        } else {
                            $("#alertCheck").text("");
                            $("#menu-toggle").attr("disabled", false);
                        }
                    }
                </script>

                <div class="row">
                    <div class="col">Rental Money:</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- input nhập Rental Money -->
                        <input type="text" class="form-control" name="rentalMoney" />
                    </div>
                </div>

                <!-- <div class="row"><div class="col"></div></div> -->
                <div class="row mt-4">
                    <div class="col text-right">
                        <!-- Button -->
                        <button class="button" type="submit" style="color: #0099ff; font-size: 15px;" id="menu-toggle"><i class="far fa-save"></i>&nbsp; Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#alertt').hide();
    });

    function alertmaClass()
    {
        var classID = $("#classID").val();
        //alert(classID); 
        $.ajax({

            url:'{{action("classController@checkclassID")}}',
            type:'GET',
            data:{classID:classID},
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
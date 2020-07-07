@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fa fa-university fa-fw mr-3"></span>ADD CLUB</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="club">Club</a> &emsp; / &emsp; Add club</div>


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

    <form action="{{ route('image.uploadclubadd.post') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        <div class="row mt-2 mb-2" style="background-color: #000;">
            <div class="col-2"></div>
            <div class="col-3 card card-body">
                <div class="row">
                    <div class="col">
                        @if ($message = Session::get('success'))
                        <img src="imageClub/{{ Session::get('image')}}" width="220" height="150">
                        @else
                        <img id="hinh" src="imageClub/1588870321.jpg" width="220" height="150" />
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


    <form action="club_add" method="POST">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        @if ($message = Session::get('success'))
        <input type="hidden" name="clubImage" value="imageClub/{{ Session::get('image1')}}">
        @else
        <input type="hidden" name="clubImage" value="imageClub/1588870321.jpg">
        @endif
        <!-- ClubID -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">ClubID</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" id="clubID" name="clubID" onfocusout="alertmaClub();" /></div>
            <p id ="alertt" style="color: red;" >clubID is exsists!!!</p>
        </div>

        <!-- Club's Name -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Club's name</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="clubName" /></div>
        </div>

        <!-- Address -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Address</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="clubAddress" /></div>
        </div>

        <!-- Manager -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Manager</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right">
                <select name="manager" id="manager" class="form-control">
                    @foreach($data as $row)
                    <option value="{{$row->coachID}}">{{$row->coachName}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!-- Button -->
        <div class="row mt-4">
            <div class="col-7"></div>
            <div class="col-2 text-right">
                <button class="button" type="submit" style="color: #0099ff; font-size: 15px;" id="menu-toggle"><i class="far fa-save"></i>&nbsp; Save</button>
                <!-- &emsp;<a href="{{action('clubController@getClub')}}"><button class="button" style="color: #0099ff; font-size: 15px;" id="menu-toggle"><i class="fas fa-times"></i>&nbsp; Exit</button></a> -->
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#alertt').hide();
    });

    function alertmaClub()
    {
        var clubID = $("#clubID").val();
        //alert(clubID); 
        $.ajax({

            url:'{{action("clubController@checkclubID")}}',
            type:'GET',
            data:{clubID:clubID},
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
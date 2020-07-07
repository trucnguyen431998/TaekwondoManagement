@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fa fa-university fa-fw mr-3"></span>EDIT CLUB</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="{{action('clubController@getClub')}}">Club</a> &emsp; / &emsp; Edit club &emsp; / &emsp; {{$club->clubName}}</div>


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

    <form action="{{ route('image.uploadclubedit.post') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        <div class="row mt-2 mb-2" style="background-color: #000;">
            <div class="col-2"></div>
            <div class="col-3 card card-body">
                <div class="row">
                    <div class="col">
                        @if ($message = Session::get('success'))
                        <img src="/projectTruc/public/imageClub/{{ Session::get('image')}}" width="220" height="150">
                        @else
                        <img id="hinh" src="{{asset($club->clubImage) }}" width="220" height="150" />
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-10 mt-2"><input type="file" id="file" class="form-control" name="image" /></div>
                    <div class="col-1 mt-2"><button type="submit" id="p" class="button" style="color: #0099ff; font-size: 18px;"><i class="fas fa-upload"></i></button></div>
                </div>
            </div>
        </div>
    </form>

    <form action="{{$id}}" method="POST">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        @if ($message = Session::get('success'))
        <input type="hidden" name="clubImage" value="imageClub/{{ Session::get('image1')}}">
        @else
        <input type="hidden" name="clubImage" value="{{$club->clubImage}}">
        @endif
        <!-- ClubID -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">ClubID</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="clubID" value="{{$id}}" /></div>
        </div>

        <!-- Club's Name -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Club's name</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="clubName" value="{{$club->clubName}}" /></div>
        </div>

        <!-- Address -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Address</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="clubAddress" value="{{$club->clubAddress}}" /></div>
        </div>

        <!-- Manager -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Manager</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <!-- <div class="col-4 text-right"><input type="text" class="form-control" name="manager" value="{{$club->manager}}" /></div> -->
            <div class="col-4 text-right">
                <select name="manager" id="manager" class="form-control">
                    @foreach($data1 as $row)
                    <option value="{{$row->coachID}}">{{$row->coachName}}</option>
                    @endforeach
                    @foreach($data as $row)
                    <option value="{{$row->coachID}}">{{$row->coachName}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!-- Button -->
        <div class="row mt-4">
            <div class="col-9 text-right">
                <button class="button" type="submit" style="color: #0099ff; font-size: 15px;" id="menu-toggle"><i class="far fa-save"></i>&nbsp; Save</button>
            </div>
    </form>
</div>
@endsection
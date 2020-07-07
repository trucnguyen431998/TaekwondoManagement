@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fa fa-user fa-fw mr-3"></span>EDIT MARTIAL ARTIST</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="{{action('martialController@getMartial')}}">Martial Artist</a> &emsp; / &emsp; Edit martial artist &emsp; / &emsp; {{$martial->maName}}</div>


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

    <form action="{{ route('image.uploadmaedit.post') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        <div class="row mt-2 mb-2" style="background-color: #000;">
            <div class="col-1"></div>
            <div class="col-3 card card-body">
                <div class="row">
                    <div class="col">
                        @if ($message = Session::get('success'))
                        <img src="/projectTruc/public/imageMa/{{ Session::get('image')}}" width="220" height="150">
                        @else
                        <img id="hinh" src="{{asset($martial->maImage) }}" width="220" height="150" />
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
        <input type="hidden" name="maImage" value="imageMa/{{ Session::get('image1')}}">
        @else
        <input type="hidden" name="maImage" value="{{$martial->maImage}}">
        @endif

        <div class="row mt-4" style="color: #fff;">
            <div class="col-xl-6 col-lg-6">
                <div class="row" style="color: #fff; font-size: 25px;">
                    <div class="col"><b><span class="fas fa-atom fa-fw mr-3"></span>Basic Information</b></div>
                </div>

                <div class="row">
                    <div class="col">Ma ID:</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- input nhập Ma ID -->
                        <input type="text" class="form-control" name="maID" value="{{$id}}" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">Martail's Name:</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- input nhập Martail's Name -->
                        <input type="text" class="form-control" name="maName" value="{{$martial->maName}}" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">Gender:</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- input nhập Gender -->
                        <select name="maGender" id="maGender" class="form-control">
                            @foreach($data1 as $row)
                            <option value="{{$row->maGender}}">{{$row->maGender}}</option>
                            @endforeach
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col">Date of birth</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- input nhập DOB -->
                        <input type="date" class="form-control" name="maDOB" value="{{$martial->maDOB}}" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">School:</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- input nhập School -->
                        <input type="text" class="form-control" name="school" value="{{$martial->school}}" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">Phone:</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- input nhập Phone -->
                        <input type="text" class="form-control" name="phone" value="{{$martial->maphone}}" />
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6">
                <div class="row" style="color: #fff; font-size: 25px;">
                    <div class="col"><b><span class="fab fa-battle-net fa-fw mr-3"></span>Contact Information</b></div>
                </div>

                <div class="row">
                    <div class="col">Class's Name:</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- input nhập Class's Name -->
                        <select name="classID" id="classID" class="form-control">
                            @foreach($data1 as $row)
                            <option value="{{$row->classID}}">{{$row->className}}</option>
                            @endforeach
                            @foreach($dataclass as $row)
                            <option value="{{$row->classID}}">{{$row->className}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col">Date of Admission:</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- input nhập DOA -->
                        <input type="date" class="form-control" name="maDOA" value="{{$martial->maDOA}}" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">Level:</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- input nhập Level -->
                        <input type="text" class="form-control" name="level" value="{{$martial->malevel}}" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">Status:</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- input nhập Status -->
                        <input type="text" class="form-control" name="status" value="{{$martial->status}}" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">Note:</div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- input nhập Note -->
                        <input type="text" class="form-control" name="note" value="{{$martial->note}}" />
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col text-right">
                        <button class="button" type="submit" style="color: #0099ff; font-size: 15px;" id="menu-toggle"><i class="far fa-save"></i>&nbsp; Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
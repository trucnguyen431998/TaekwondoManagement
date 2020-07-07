@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fa fa-user fa-fw mr-3"></span>VIEW MARTIAL ARTIST</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="{{action('martialController@getMartial')}}">Martial Artist</a> &emsp; / &emsp; View martial artist &emsp; / &emsp; {{$martial->maName}}</div>


<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-2"></div>
        <div class="col-3" style="background-color: #000033; color: #fff;">
            <div class="row mt-3">
                <!-- <div class="col"><img src="imageMa/1587995435.jpg" style="width: 100px; height: 150px;"></div> -->
                <div class="col"><img src='{{asset($martial->maImage) }}' style="width: 100px; height: 150px;"></div>
            </div>
            <div class="row mt-4" style="font-size: 27px;">&ensp;<b>{{$martial->maName}}</b></div>
            <div class="row mt-3">
                <div class="col-8">
                    <b><span class="fas fa-atom fa-fw mr-3"></span>Basic Information</b>
                </div>
                <div class="col-4">
                    <hr width="100%" color="#ffffff" />
                </div>
            </div>
            <div class="row">
                <div class="col-4">&ensp; Gender</div>
                <div class="col-8">{{$martial->maGender}}</div> <!-- Giới tính trong CSDL -->
            </div>
            <div class="row">
                <div class="col-4">&ensp; DOB</div>
                <div class="col-8">{{$martial->maDOB}}</div> <!-- DOB trong CSDL -->
            </div>
            <div class="row">
                <div class="col-4">&ensp; Phone</div>
                <div class="col-8">{{$martial->maphone}}</div> <!-- Phone trong CSDL -->
            </div>
            <div class="row">
                <div class="col-4">&ensp; School</div>
                <div class="col-8">{{$martial->school}}</div> <!-- School trong CSDL -->
            </div><br>
        </div>
        <div class="col-5" style="background-color: #fff; color:#000033">
            <!-- START Club Information -->
            <div class="row mt-4" style="font-size: 18px;">
                <div class="col-6">
                    <b><span class="fa fa-university fa-fw mr-3"></span>Club Information</b>
                </div>
                <div class="col-6">
                    <hr width="100%" color="#000033" />
                </div>
            </div>
            @foreach($data as $row)
            <div class="row mt-1" style="color:#000033;">
                <div class="col-1 text-right"></div>
                <div class="col-3">Club's Name</div>
                <div class="col-6">{{$row->clubName}}</div> <!-- Club Name trong CSDL -->
            </div>
            <div class="row mt-1" style="color:#000033;">
                <div class="col-1 text-right"></div>
                <div class="col-3">Address</div>
                <div class="col-6">{{$row->clubAddress}}</div> <!-- Address trong CSDL -->
            </div>
            <div class="row mt-1" style="color:#000033;">
                <div class="col-1 text-right"></div>
                <div class="col-3">Manager</div>
                <div class="col-6">{{$row->manager}}</div> <!-- Manager trong CSDL -->
            </div>
            <!-- END Club Information -->

            <!-- START Class Information -->
            <div class="row mt-4" style="font-size: 18px;">
                <div class="col-6">
                    <b><span class="fas fa-chalkboard fa-fw mr-3"></span>Class Information</b>
                </div>
                <div class="col-6">
                    <hr width="100%" color="#000033" />
                </div>
            </div>
            <div class="row mt-1" style="color:#000033;">
                <div class="col-1 text-right"></div>
                <div class="col-3">Class's Name</div>
                <div class="col-6">{{$row->className}}</div> <!-- Class Name trong CSDL -->
            </div>
            <div class="row mt-1" style="color:#000033;">
                <div class="col-1 text-right"></div>
                <div class="col-3">Date</div>
                <div class="col-6">{{$row->date}}</div> <!-- ngày tập trong CSDL -->
            </div>
            <div class="row mt-1" style="color:#000033;">
                <div class="col-1 text-right"></div>
                <div class="col-3">Time</div>
                <div class="col-6">{{$row->startTime}} - {{$row->endTime}}</div> <!-- giờ tập trong CSDL -->
            </div>
            <div class="row mt-1" style="color:#000033;">
                <div class="col-1 text-right"></div>
                <div class="col-3">Coach</div>
                <div class="col-6">{{$row->coachName}}</div> <!-- HLV trong CSDL -->
            </div>
            <div class="row mt-1" style="color:#000033;">
                <div class="col-1 text-right"></div>
                <div class="col-3">Phone</div>
                <div class="col-6">{{$row->phone}}</div> <!-- Phone trong CSDL -->
            </div>
            <div class="row mt-1" style="color:#000033;">
                <div class="col-1 text-right"></div>
                <div class="col-3">Assistant</div>
                <div class="col-6">{{$row->assistant}}</div> <!-- Tro ta trong CSDL -->
            </div>
            <!-- END Class Information -->

            <!-- START Level Information -->
            <div class="row mt-4" style="font-size: 18px;">
                <div class="col-6">
                    <b><span class="far fa-address-card fa-fw mr-3"></span>Level Information</b>
                </div>
                <div class="col-6">
                    <hr width="100%" color="#000033" />
                </div>
            </div>
            @endforeach
            <div class="row mt-1" style="color:#000033;">
                <div class="col-1 text-right"></div>
                <div class="col-3">DOA</div>
                <div class="col-6">{{$martial->maDOA}}</div> <!-- DOA trong CSDL -->
            </div>
            <div class="row mt-1" style="color:#000033;">
                <div class="col-1 text-right"></div>
                <div class="col-3">Level</div>
                <div class="col-6">{{$martial->malevel}}</div> <!-- Level trong CSDL -->
            </div><br>
            <!-- END Level Information -->
        </div>
    </div>
</div>
@endsection
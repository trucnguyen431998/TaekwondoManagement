@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fa fa-user fa-fw mr-3"></span>VIEW COACH</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="{{action('coachController@getCoach')}}">Coach</a> &emsp; / &emsp; View coach &emsp; / &emsp; {{$coach->coachName}}</div>


<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-2"></div>
        <div class="col-3" style="background-color: #000033; color: #fff;">
            <div class="row mt-3">
                <!-- <div class="col"><img src="imageMa/1587995435.jpg" style="width: 100px; height: 150px;"></div> -->
                <div class="col"><img src='{{asset($coach->coachImage) }}' style="width: 100px; height: 150px;"></div>
            </div>
            <div class="row mt-4" style="font-size: 27px;">&ensp;<b>{{$coach->coachName}}</b></div>
        </div>
        <div class="col-5" style="background-color: #fff; color:#000033">
            <!-- START Basic Information -->
            <div class="row mt-4" style="font-size: 18px;">
                <div class="col-6">
                    <b><span class="fas fa-atom fa-fw mr-3"></span>Basic Information</b>
                </div>
                <div class="col-6">
                    <hr width="100%" color="#000033" />
                </div>
            </div>
            <div class="row mt-1" style="color:#000033;">
                <div class="col-1 text-right"></div>
                <div class="col-3">Coach ID</div>
                <div class="col-6">{{$id}}</div> 
            </div>
            <div class="row mt-1" style="color:#000033;">
                <div class="col-1 text-right"></div>
                <div class="col-3">Gender</div>
                <div class="col-6">{{$coach->coachGender}}</div>
            </div>
            <div class="row mt-1" style="color:#000033;">
                <div class="col-1 text-right"></div>
                <div class="col-3">Date of birth</div>
                <div class="col-6">{{$coach->coachDOB}}</div> 
            </div>
            <div class="row mt-1" style="color:#000033;">
                <div class="col-1 text-right"></div>
                <div class="col-3">Address</div>
                <div class="col-6">{{$coach->coachAddress}}</div>
            </div>
            <!-- END Basic Information -->

            <!-- START Contact Information -->
            <div class="row mt-4" style="font-size: 18px;">
                <div class="col-6">
                    <b><span class="fab fa-battle-net fa-fw mr-3"></span>Contact Information</b>
                </div>
                <div class="col-6">
                    <hr width="100%" color="#000033" />
                </div>
            </div>
            <div class="row mt-1" style="color:#000033;">
                <div class="col-1 text-right"></div>
                <div class="col-3">Phone</div>
                <div class="col-6">{{$coach->phone}}</div>
            </div>
            <div class="row mt-1" style="color:#000033;">
                <div class="col-1 text-right"></div>
                <div class="col-3">Email</div>
                <div class="col-6">{{$coach->email}}</div>
            </div>
            <div class="row mt-1" style="color:#000033;">
                <div class="col-1 text-right"></div>
                <div class="col-3">Facebook</div>
                <div class="col-6">{{$coach->facebook}}</div>
            </div>
            <div class="row mt-1" style="color:#000033;">
                <div class="col-1 text-right"></div>
                <div class="col-3">Zalo</div>
                <div class="col-6">{{$coach->zalo}}</div> 
            </div>
            <!-- END Contact Information -->

            <!-- START Account Information -->
            <div class="row mt-4" style="font-size: 18px;">
                <div class="col-6">
                    <b><span class="fas fa-user-circle fa-fw mr-3"></span>Account Information</b>
                </div>
                <div class="col-6">
                    <hr width="100%" color="#000033" />
                </div>
            </div>
            <div class="row mt-1" style="color:#000033;">
                <div class="col-1 text-right"></div>
                <div class="col-3">Account</div>
                <div class="col-6">{{$coach->accountName}}</div>
            </div>
            <div class="row mt-1" style="color:#000033;">
                <div class="col-1 text-right"></div>
                <div class="col-3">Role</div>
                <div class="col-6">{{$coach->roleID}}</div> 
            </div><br>
            <!-- END Account Information -->
        </div>
    </div>
</div>
@endsection
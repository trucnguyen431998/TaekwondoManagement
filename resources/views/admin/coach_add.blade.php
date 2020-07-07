@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fab fa-joomla fa-fw mr-3"></span>ADD COACH</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="coach">Coach</a> &emsp; / &emsp; Add Coach</div>


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

    <form action="{{ route('image.uploadcoachadd.post') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        <div class="row mt-2 mb-2" style="background-color: #000;">
            <div class="col-1"></div>
            <div class="col-3 card card-body">
                <div class="row">
                    <div class="col">
                        @if ($message = Session::get('success'))
                        <img src="imageCoach/{{ Session::get('image')}}" width="100" height="150">
                        @else
                        <img id="hinh" src="imageCoach/1588870120.jpg" width="100" height="150" />
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

    <form action="coach_add" method="POST">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        <!-- Upload hình -->
        <div class="row mt-4">
            @if ($message = Session::get('success'))
            <input type="hidden" name="coachImage" value="imageCoach/{{ Session::get('image1')}}">
            @else
            <input type="hidden" name="coachImage" value="imageCoach/1588870120.jpg">
            @endif
            <div class="col-6 col-lg-6" style="color: #fff;">
            </div>
        </div>

        <div class="row mt-4" style="color: #fff;">
            <div class="col-xl-6 col-lg-6">
                <div class="row" style="color: #fff; font-size: 25px;">
                    <div class="col"><b><span class="fas fa-atom fa-fw mr-3"></span>Basic Information</b></div>
                </div>

                <div class="row"> 
                    <div class="col">Coach ID:</div><p id ="alertt" style="color: red;" >coachID is exsists!!!</p>
                </div>
                <div class="row">
                    <!-- input nhập Coach ID -->
                    <div class="col">
                        <input type="text" class="form-control" name="coachID" id="coachID" onfocusout="checkCoachID();" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">Coach's Name:</div>
                </div>
                <div class="row">
                    <!-- input nhập Coach Name -->
                    <div class="col">
                        <input type="text" class="form-control" name="coachName" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">Gender:</div>
                </div>
                <div class="row">
                    <!-- input nhập Gender -->
                    <div class="col">
                        <select name="coachGender" id="coachGender" class="form-control">
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col">Date of birth:</div>
                </div>
                <div class="row">
                    <!-- input nhập DOB -->
                    <div class="col">
                        <input type="date" id="dateofbirth" class="form-control" name="coachDOB" onfocusout="validDate();" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">Address:</div>
                </div>
                <div class="row">
                    <!-- input nhập Address -->
                    <div class="col">
                        <input type="text" class="form-control" name="coachAddress" />
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6">
                <div class="row" style="color: #fff; font-size: 25px;">
                    <div class="col"><b><span class="fab fa-battle-net fa-fw mr-3"></span>Contact Information</b></div>
                </div>

                <div class="row">
                    <div class="col">Phone:</div>
                </div>
                <div class="row">
                    <!-- input nhập Phone -->
                    <div class="col">
                        <input type="text" class="form-control" name="phone" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">Email:</div>
                </div>
                <div class="row">
                    <!-- input nhập Email -->
                    <div class="col">
                        <input type="email" class="form-control" name="email" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">Facebook:</div>
                </div>
                <div class="row">
                    <!-- input nhập Facebook -->
                    <div class="col">
                        <input type="text" class="form-control" name="facebook" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">Zalo:</div>
                </div>
                <div class="row">
                    <!-- input nhập Zalo -->
                    <div class="col">
                        <input type="text" class="form-control" name="zalo" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4" style="color: #fff;">
            <div class="col-xl-6 col-lg-6">
                <div class="row" style="color: #fff; font-size: 25px;">
                    <div class="col"><b><span class="fas fa-user-circle fa-fw mr-3"></span>Account Information</b></div>
                </div>

                <div class="row">
                    <div class="col">Account Name:</div>
                </div>
                <div class="row">
                    <!-- input nhập Account Name -->
                    <div class="col">
                        <input type="text" class="form-control" name="accountName" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">Role ID:</div>
                </div>
                <div class="row">
                    <!-- input nhập Role ID -->
                    <div class="col">
                        <input type="text" class="form-control" name="roleID" />
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6">
                <div class="row mt-3"></div>
                <div class="row mt-4">
                    <div class="col">Password:</div>
                </div>
                <div class="row">
                    <!-- input nhập Password -->
                    <div class="col">
                        <input type="password" class="form-control" name="password" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">Re - password:</div>
                </div>
                <div class="row">
                    <!-- input nhập Re - password -->
                    <div class="col">
                        <input type="password" class="form-control" name="repassword" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-xl-6 col-lg-6"></div>
            <div class="col-xl-6 col-lg-6 text-right">
                <button class="button" style="color: #0099ff; font-size: 15px;" id="menu-toggle"><i class="far fa-save"></i>&nbsp; Save</button>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('#alertt').hide();
    });

    function validDate() {
        var date = document.getElementById("dateofbirth").value;
        var varDate = new Date(date);
        var today = new Date();
        today.setHours(0, 0, 0, 0);

        if (varDate > today) {
            alert("Date of birth must to not greatter than today")
        }
    }

    function checkCoachID() {
        var coachID = $("#coachID").val();
        //alert(coachID);
        $.ajax({
                url: '{{action("coachController@checkcoachID")}}',
                type: 'GET',
                data: {
                    coachID: coachID
                },
                success: function(data) {

                    if (data.length == 2) {
                        $('#alertt').hide();

                        $('#menu-toggle').attr('disabled', false);

                    } else {
                        $('#alertt').show();
                        $('#menu-toggle').attr('disabled', true);
                    }
                }
        });
    }
</script>
@endsection
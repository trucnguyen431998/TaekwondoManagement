@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fa fa-university fa-fw mr-3"></span>EDIT SCORE</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="{{action('examController@getExam')}}">Exam</a> &emsp; / &emsp;List Martial Artist</a> &emsp;/&emsp; Edit score </div>


<div class="container-fluid">
    @if(count($errors)>0)
    <div class="row mt-4"></div>
    <div class="alert alert-danger">
        @foreach($errors->all() as $err)
        {{$err}}<br>
        @endforeach
    </div>
    @endif
    @if(session('thongbao'))
    <div class="row mt-4"></div>
    <div class="alert alert-success">
        {{session('thongbao')}}
    </div>
    @endif
    <form action="{{$idres}}" method="POST">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        <div class="row mt-4" style="color: #fff">
            <div class="col-6 text-left" style="color: #fff; font-size: 20px;">
                <h2>{{$result->examID}}</h2>
            </div>
            <div class="col-6 text-left" style="color: #fff; font-size: 20px;">
                <h2><input type="hidden" class="form-control" name="resID" value="{{$idres}}" /></h2>
            </div>
        </div>
        <!-- Tên võ sinh -->
        <div class="row mt-3">
            <div class="col-2"></div>
            <div class="col-3 text-left" style="color: #fff; font-size: 20px;">Full Name</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-left" style="color: #fff; font-size: 20px;">{{$result->maID}}</div>
            <div class="col-4 text-right"><input type="hidden" class="form-control" name="maID" value="{{$result->maID}}" /></div>
        </div>

        <!-- Level -->
        <div class="row mt-3">
            <div class="col-2"></div>
            <div class="col-3 text-left" style="color: #fff; font-size: 20px;">Level</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">{{$result->resLevel}}</div>
            <div class="col-4 text-right"><input type="hidden" class="form-control" name="resLevel" value="{{$result->resLevel}}" /></div>
        </div>
        <!-- Punch -->
        <div class="row mt-2">
            <div class="col-2"></div>
            <div class="col-3 text-left" style="color: #fff; font-size: 20px;">Score punch</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="int" class="form-control" name="scoreOfPunch" id="scoreOfPunch" value="{{$result->scoreOfPunch}}" /></div>
        </div>

        <!-- Kick -->
        <div class="row mt-2">
            <div class="col-2"></div>
            <div class="col-3 text-left" style="color: #fff; font-size: 20px;">Score kick</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="scoreOfKick" id="scoreOfKick" value="{{$result->scoreOfKich}}" /></div>
        </div>

        <!-- Main -->
        <div class="row mt-2">
            <div class="col-2"></div>
            <div class="col-3 text-left" style="color: #fff; font-size: 20px;">Score main</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="scoreOfMain" id="scoreOfMain" value="{{$result->scoreOfMain}}" /></div>
        </div>

        <!-- Practice -->
        <div class="row mt-2">
            <div class="col-2"></div>
            <div class="col-3 text-left" style="color: #fff; font-size: 20px;">Score practice</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="scoreOfPractice" id="scoreOfPractice" value="{{$result->scoreOfPractice}}" /></div>
        </div>

        <!-- Countervailing -->
        <div class="row mt-2">
            <div class="col-2"></div>
            <div class="col-3 text-left" style="color: #fff; font-size: 20px;">Score countervailing</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="scoreOfCountervailing" id="scoreOfCountervailing" value="{{$result->scoreOfCountervailing}}" /></div>
        </div>

        <!-- Endurance -->
        <div class="row mt-2">
            <div class="col-2"></div>
            <div class="col-3 text-left" style="color: #fff; font-size: 20px;">Score endurance</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="scoreOfEndurance" id="scoreOfEndurance" onfocusout="sumTotal();" value="{{$result->scoreOfEndurance}}" value="{{$result->scoreOfPunch}}" /></div>
        </div>

        <!-- Total -->
        <div class="row mt-2">
            <div class="col-2"></div>

            <div class="col-3 text-left" style="color: #fff; font-size: 20px;">Score Total</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;"><label name="scoreTotal" id="scoreTotal">{{$result->totalScore}}</label></div>
            <div class="col-2 text-right"><input type="hidden" class="form-control" name="scoreTotal" id="scoreTotal1" value="{{$result->totalScore}}" /></div>
        </div>

        <!-- Rank -->
        <div class="row mt-2">
            <div class="col-2"></div>
            <div class="col-3 text-left" style="color: #fff; font-size: 20px;">Rank</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="rank" value="{{$result->rank}}" /></div>
        </div>

        <!-- Examiner -->
        <div class="row mt-2">
            <div class="col-2"></div>
            <div class="col-3 text-left" style="color: #fff; font-size: 20px;">Examiner</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="examiner" value="{{$result->examiner}}" /></div>
        </div>


        <!-- Button -->
        <div class="row mt-4">
            <div class="col-10 text-right">
                <button class="button" type="submit" style="color: #0099ff; font-size: 15px;" id="menu-toggle"><i class="far fa-save"></i>&nbsp; Save</button>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    function sumTotal() {
        var scoreOfEndurance = parseInt($("#scoreOfEndurance").val());
        var scoreOfCountervailing = parseInt($("#scoreOfCountervailing").val());
        var scoreOfPractice = parseInt($("#scoreOfPractice").val());
        var scoreOfMain = parseInt($("#scoreOfMain").val());
        var scoreOfKick = parseInt($("#scoreOfKick").val());
        var scoreOfPunch = parseInt($("#scoreOfPunch").val());
        var sum = scoreOfEndurance + scoreOfCountervailing + scoreOfPractice + scoreOfMain + scoreOfKick + scoreOfPunch;
        $("#scoreTotal").text(sum);
        $("#scoreTotal1").val(sum);
        //$("input[id=scoreTotal]").val(sum);
        // $('#scoreTotal').attr('value', sum.toString());
    }
</script>
@endsection
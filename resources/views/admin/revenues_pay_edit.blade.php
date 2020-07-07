@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fa fa-university fa-fw mr-3"></span>EDIT PAY CONTENT</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="{{action('revenuesController@getRevenues')}}">Revenues</a> &emsp;/&emsp; <a href="{{action('payController@getRevenuesPay')}}">Pay content</a> &emsp;/&emsp; Edit pay content &emsp;/&emsp; {{$id}}</div>


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
        <!-- Pay ID -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Pay ID</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="payID" value="{{$id}}" /></div>
        </div>

        <!-- Club Name -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Club's name</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right">
                <select name="clubID" id="clubID" class="form-control">
                    @foreach($dataclub as $row)
                    <option value="{{$row->clubID}}">{{$row->clubName}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Class's name -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Class's name</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right">
                <!-- <input type="text" class="form-control" name="clubName" /> -->
                <select name="classID" id="classID" class="form-control">
                    @foreach($dataclass as $row)
                    <option value="{{$row->classID}}">{{$row->className}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Description -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Description</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="description" value="{{$pay->description}}" /></div>
        </div>

        <!-- Into Money -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Into money</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="intoMoney" value="{{$pay->intoMoney}}" /></div>
        </div>

        <!-- Month -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Month</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="month" value="{{$pay->month}}" /></div>
        </div>

        <!-- Date -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Date</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="date" class="form-control" name="date" value="{{$pay->date}}" /></div>
        </div>

        <!-- Button -->
        <div class="row mt-4">
            <div class="col-9 text-right">
                <button class="button" type="submit" style="color: #0099ff; font-size: 15px;" id="menu-toggle"><i class="far fa-save"></i>&nbsp; Save</button>
            </div>
        </div>
    </form>
</div>
@endsection
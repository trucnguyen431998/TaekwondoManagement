@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fa fa-university fa-fw mr-3"></span>ADD COLLECTION CONTENT</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="revenues">Revenues</a> &emsp;/&emsp; <a href="revenues_col">Collection content</a> &emsp;/&emsp; Add collection content</div>


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
    <form action="revenues_col_add" method="POST">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        <!-- CollectionID -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">CollectionID</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="revID" id="revID" onfocusout="alertmaRev();"/></div>
            <p id ="alertt" style="color: red;" >revenues ID is exsists!!!</p>
        </div>

        <!-- Collection Name -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Collection name</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="revName" /></div>
        </div>

        <!-- Club's name -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Club's name</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right">
                <!-- <input type="text" class="form-control" name="clubName" /> -->
                <select name="clubID" id="clubID" class="form-control" onfocusout="getValue();">
                    @foreach($dataclub as $row)
                    <option id ="op" value="{{$row->clubID}}">{{$row->clubName}}</option>
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
        <!-- Into Money -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Into money</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="intoMoney" /></div>
        </div>
        <!-- Month -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Month</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="month" /></div>
        </div>
        <!-- Note -->
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-2 text-left" style="color: #fff; font-size: 20px;">Note</div>
            <div class="col-1 text-left" style="color: #fff; font-size: 20px;">:</div>
            <div class="col-4 text-right"><input type="text" class="form-control" name="note" /></div>
        </div>
        <!-- Button -->
        <div class="row mt-4">
            <div class="col-9 text-right">
                <button class="button" type="submit" style="color: #0099ff; font-size: 15px;" id="menu-toggle" onclick="location.href='revenues_col'"><i class="far fa-save"></i>&nbsp; Save</button>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    // function getValue(){
    //     var text = $('#clubID :selected').text();
    //     //alert(text);
    //     $.ajax({
    //         url:'{{action("revenuesController@getClass")}}',
    //         type:'GET',
    //         dataType:'JSON',
    //         data:{text:text},
    //         success:function(data){
    //             var html ='';
    //           $.each(data,function(key,item){
    //               html +='<option value ="'+item.classID+'">'+item.className+'</option>';
    //           })
    //           $("#classID").html(html);
    //         }
    //     })
    // }

    $(document).ready(function(){
        $('#alertt').hide();
    });

    function alertmaRev()
    {
        var revID = $("#revID").val();
        //alert(revID); 
        $.ajax({

            url:'{{action("revenuesController@checkrevID")}}',
            type:'GET',
            data:{revID:revID},
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
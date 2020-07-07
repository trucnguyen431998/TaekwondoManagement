@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <!-- Tên kỳ thi trong CSDL -->
    <h2><span class="fa fa-calendar fa-fw mr-3"></span>LIST MARTIAL ARTIST IN EXAM</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="{{action('examController@getExam')}}">Exam</a> &emsp; / &emsp; List Martial Artist &emsp; / &emsp; {{$examID}}</div>

<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-3">
            <!-- Filter -->
            <select name="type" id="type" class="form-control">
                <option></option>
                @if(Session::get('roleID')=="ad")
                <option value="club">Club</option>
                @endif
                <option value="class">Class</option>
                <option value="coach">Coach</option>
                <option value="level">Level</option>
            </select>
        </div>
        <div class="col-3">
            <!-- Filter -->
            <select name="datatype" id="datatype" class="form-control" onchange="hideButton();">
            </select>
        </div>
        <script>
            $(document).ready(function() {
                $("#add").hide();
            });

            function hideButton() {
                $("#add").show();
            }
        </script>
        <div class="col-1">
            <button class="button" style="color: #0099ff; font-size: 18px;" id="add" onclick="location.href='/projectTruc/public/exam_list/{{$examID}}'"><i class="fas fa-filter"></i></button>
        </div>
        <div class="col-5 text-right">
            @if (Session::get('roleID')=="ad")
            <!-- Nút export -->
            &emsp;<button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='exportexamlist/export/{{$examID}}'"><i class="fas fa-cloud-download-alt"></i>&ensp; Export</button>
            @endif
            <!-- Nút home -->
            &emsp;<a href="{{action('examController@getExam')}}"><button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle"><i class="fas fa-ellipsis-v"></i></button></a>
        </div>
    </div>

    <div class="row mt-4">
        <table class="table table-striped table-hover" style="font-size: 15px; background: #eee;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Full name</th>
                    <th scope="col">DOB</th>
                    <th scope="col">Club's name</th>
                    <th scope="col">Class's name</th>
                    <th scope="col">Coach's name</th>
                    <th scope="col">Level</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <?php $i = 1; ?>
            <tbody id="tb">
                @foreach($data as $row)
                <tr>
                    <th scope="row"><?php echo $i++; ?></th>
                    <td>{{$row->maName}}</td>
                    <td>{{$row->maDOB}}</td>
                    <td>{{$row->clubName}}</td>
                    <td>{{$row->className}}</td>
                    <td>{{$row->coachName}}</td>
                    <td>{{$row->level}}</td>
                    @if (Session::get('roleID')=="ad")
                    <td>&emsp;<i class="fas fa-pencil-alt" onclick="location.href='{{$row->maID}}/{{$examID}}'"></i></td>
                    @else
                    <td>&emsp;<i class="far fa-trash-alt" onclick="deleteMoe('{{$row->moeID}}')"></i></td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row" id="link">
            <div class="col-auto">{{ $data->links() }}</div>
        </div>
    </div>
</div>
<input type="hidden" id="coachID" value="{{Session::get('coachID')}}">
<input type="hidden" id="examID" value="{{$examID}}">
<script type="text/javascript">
    //Xoa
    function deleteMoe(moeID) {
        var coachID = $("#coachID").val();
        //alert(revID+'-'+maID);
        $.ajax({
            url: '{{action("examController@getMartialDeleteList")}}',
            type: 'GET',
            data: {
                moeID: moeID,
                coachID: coachID
            },
            success: function(data) {
                location.reload();
            }
        })
    }

    //Tim kiem
    $('#search').on('keyup', function() {
        var value = $("#search").val();
        var examID = $("#examID").val();
        if (value != '') {
            $.ajax({
                type: 'get',
                url: '{{action("examController@getSearchList")}}',
                data: {
                    value: value,
                    examID: examID
                },
                success: function(data) {
                    $('#tb').html(data);
                    $("#link").hide();
                }
            });
        } else {
            location.reload();
        }
    })
    $.ajaxSetup({
        headers: {
            'csrftoken': '{{ csrf_token() }}'
        }
    });

    //Filter
    $('#type').change(function() {
        var selected = $('#type option:selected').val();
        $.ajax({
            url: '{{action("examController@getfilter")}}',
            type: 'GET',
            dataType: 'JSON',
            data: {
                selected: selected
            },
            success: function(data) {
                var htm = '';
                if (selected == "club") {
                    $.each(data, function(key, item) {
                        htm += '<option>' + item.clubName + '</option>';
                    })
                } else if (selected == "coach") {
                    $.each(data, function(key, item) {
                        htm += '<option>' + item.coachName + '</option>';
                    })
                } else if (selected == "class") {
                    $.each(data, function(key, item) {
                        htm += '<option>' + item.className + '</option>';
                    })
                } else if (selected == "level") {
                    $.each(data, function(key, item) {
                        htm += '<option>' + item.keys + '</option>';
                    })
                } else if(selected == ""){
                    location.reload();
                }

                $("#datatype").html(htm);

            }
        })
    });
    
    //Loc
    $('#datatype').change(function() {
        var value = $("#datatype").val();
        if (value != '') {
            $.ajax({
                type: 'get',
                url: '{{action("examController@getFilterList")}}',
                data: {
                    value: value
                },
                success: function(data) {
                    $('#tb').html(data);
                    $("#link").hide();
                }
            });
        } else {
            location.reload();
        }
    })
    $.ajaxSetup({
        headers: {
            'csrftoken': '{{ csrf_token() }}'
        }
    });
</script>


@endsection
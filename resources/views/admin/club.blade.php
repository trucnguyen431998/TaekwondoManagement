@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fa fa-university fa-fw mr-3"></span>CLUB</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="club">Club</a></div>


<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-3">
            <!-- Filter -->
            <select name="type" id="type" class="form-control">
                <option></option>
                <option value="club">Club</option>
                @if (Session::get('roleID')=="ad")
                <option value="coach">Coach</option>
                @endif
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
            <button class="button" style="color: #0099ff; font-size: 18px;" id="add" onclick="location.href='club'"><i class="fas fa-filter"></i></button>
        </div>
        <div class="col-5 text-right">
            <!-- Nút ADD -->
            @if (Session::get('roleID')=="ad")
            <button class="button" style="color: #0099ff; font-size: 18px;" id="add" onclick="location.href='club_add'"><i class="fas fa-plus-square"></i>&ensp; Add</button>
            <!-- Nút export -->
            &emsp;<button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='exportclub'"><i class="fas fa-cloud-download-alt"></i>&ensp; Export</button>
            <!-- Nút history -->
            &emsp;<button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='club_history'"><i class="fas fa-history"></i>&ensp; History</button>
            @else
            <!-- Nút export -->
            &emsp;<button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='exportclub'"><i class="fas fa-cloud-download-alt"></i>&ensp; Export</button>
            @endif
        </div>
    </div>

    <div class="row mt-4" style="color: #fff;">
        <table class="table table-striped table-hover " style="font-size: 15px; background: #eee;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"></th>
                    <th scope="col">Club ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Manager</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <?php $i = 1; ?>
            <tbody id="tb">
                @if (Session::get('roleID')=="ad")
                @foreach($data as $row)
                <tr>
                    <th scope="row"><?php echo $i++; ?></th>
                    <td><img src="{{$row->clubImage}}" style="width: 60px; height: 40px;"></td>
                    <th>{{$row->clubID}}</th>
                    <td>{{$row->clubName}}</td>
                    <td>{{$row->clubAddress}}</td>
                    <td>{{$row->coachName}}</td>
                    <td>{{$row->phone}}</td>
                    <td>
                        <!-- Button chi tiet CLB <i class="fas fa-info-circle" data-toggle="modal" data-target="#truc" onclick="viewDetailClub('{{$row->clubID}}')"></i> -->
                        <!-- Button Danh sách lớp -->&emsp;<i class="fas fa-list" onclick="location.href='class/{{$row->clubID}}'"></i>
                        <!-- Button Danh sách HLV -->&emsp; <i class="fas fa-clipboard-list" data-toggle="modal" onclick="showvalue('{{$row->clubID}}','{{$row->clubName}}')" data-target=".bs-example-modal-lg"></i>
                        <!-- Button Sửa -->&emsp;<i class="far fa-edit" onclick="location.href='club_edit/{{$row->clubID}}'"></i>
                        <!-- Button Xóa &emsp;<i class="far fa-trash-alt" onclick="location.href='club/{{$row->clubID}}'"></i>-->
                        &emsp;<i class="far fa-trash-alt" onclick="deleteClub('{{$row->clubID}}','{{$row->clubName}}')"></i>
                    </td>
                </tr>
                @endforeach
                @else
                @foreach($data as $row)
                <tr>
                    <th scope="row"><?php echo $i++; ?></th>
                    <td><img src="{{$row->clubImage}}" style="width: 60px; height: 40px;"></td>
                    <th>{{$row->clubID}}</th>
                    <td>{{$row->clubName}}</td>
                    <td>{{$row->clubAddress}}</td>
                    <td>{{$row->coachName}}</td>
                    <td>{{$row->phone}}</td>
                    <td>
                        <!-- Button chi tiet CLB <i class="fas fa-info-circle" data-toggle="modal" data-target="#truc" ></i> -->
                        <!-- Button Danh sách lớp -->&emsp;<i class="fas fa-list" onclick="location.href='class/{{$row->clubID}}'"></i>
                        <!-- Button Danh sách HLV -->&emsp;<i class="fas fa-clipboard-list" data-toggle="modal" onclick="showvalue('{{$row->clubID}}','{{$row->clubName}}')" data-target=".bs-example-modal-lg"></i>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        <div class="row" id="link">
            <div class="col-auto">{{ $data->links() }}</div>
        </div>
    </div>

    <!-- Popup Danh sách HLV của mỗi CLB -->
    <form action="" method="POST" id="listclubcoach">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <div class="modal fade bs-example-modal-lg" id="listcoach" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <table class="table table-striped table-hover table-light">
                        <!-- Tên lớp trong CSDL -->
                        <div class="row mt-3">
                            <div class="col-auto">&emsp;<i class="fas fa-list"></i>&emsp;<b>List coachs of <span id='id'></span> </b></div>
                        </div>
                        <div class="row mt-3"></div>
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Coach ID</th>
                                <th scope="col">Coach's name</th>
                                <th scope="col">Phone</th>
                            </tr>
                        </thead>
                        <tbody id='views'></tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>


<!-- Popup chi tiet CLB -->
<div class="modal fade " id="truc" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                truc
            </div>
            <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
        </div>
    </div>
</div>
<!-- end popup chi tiet CLB -->


<script>
    function deleteClub(id,clubName) {
       
        Swal.fire({
            title: 'Are you sure delete "'+clubName+'" ?',
            // text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#00a550',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '{{action("clubController@getClubDelete")}}',
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        location.reload();

                    }
                })
                Swal.fire(
                    'Deleted!',
                    'success'
                )
            }
        })
    }


    function showvalue(clubID, clubName) {
        //$s = $($)
        $('#id').text(clubName);
        $.ajax({
            url: '{{action("clubController@getpopup")}}',
            type: 'GET',
            dataType: 'JSON',
            data: {
                clubID: clubID
            },
            success: function(data) {
                var noi = '';
                var count = 1;
                // if (data.length > 0) {
                $.each(data, function(key, item) {
                    noi += '<tr>';
                    noi += '<td>' + count + '</td>';
                    noi += '<td>' + item.coachID + '</td>';
                    noi += '<td>' + item.coachName + '</td>';
                    noi += '<td>' + item.phone + '</td>';
                    noi += '</tr>';
                    count++;
                })
                $('#views').html(noi);
                // $('#id').text(data[0].clubName);
                // } else {
                //     $('#id').text("");
                // }
            }

        });
    }

    $('#search').on('keyup', function() {
        var value = $("#search").val();
        if (value != '') {
            $.ajax({
                type: 'get',
                url: '{{action("clubController@getSearch")}}',
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

    $('#type').change(function() {
        var selected = $('#type option:selected').val();
        $.ajax({
            url: '{{action("clubController@getfiltercl")}}',
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
                }

                $("#datatype").html(htm);

            }
        })
    });

    $('#datatype').change(function() {
        var value = $("#datatype").val();
        if (value != '') {
            $.ajax({
                type: 'get',
                url: '{{action("clubController@getFilter")}}',
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


    function viewDetailClub(clubID) {
        $s = $($)
        $.ajax({
            url: '{{action("clubController@getDetailClub")}}',
            type: 'GET',
            dataType: 'JSON',
            data: {
                resID: resID
            },
            success: function(data) {
                if (data.length > 0) {
                    $('#maName').text(data[0].maName);
                    $('#maGender').text(data[0].maGender);
                    $('#maDOB').text(data[0].maDOB);
                    $('#phone').text(data[0].phone);
                    $('#school').text(data[0].school);
                    $('#examName').text(data[0].examName);
                    $('#organizers').text(data[0].organizers);
                    $('#scorePunch').text(data[0].scoreOfPunch);
                    $('#scoreKick').text(data[0].scoreOfKich);
                    $('#scoreMain').text(data[0].scoreOfMain);
                    $('#scorePractice').text(data[0].scoreOfPractice);
                    $('#scoreCountervailing').text(data[0].scoreOfCountervailing);
                    $('#scoreEndurance').text(data[0].scoreOfEndurance);
                    $('#scoreTotal').text(data[0].totalScore);
                    $('#resLevel').text(data[0].resLevel);
                    $('#rank').text(data[0].rank);
                }
            }

        });
    }
</script>
@endsection
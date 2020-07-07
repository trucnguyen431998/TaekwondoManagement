@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fa fa-university fa-fw mr-3"></span>CLASS</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="{{action('clubController@getClub')}}">Club</a> &emsp; / {{$clubID}} &emsp; Class</div>


<div class="container-fluid">
    <div class="row mt-4">
        <input type="hidden" class="form-control" name="clubID" value="{{$clubID}}" />
        <div class="col-12 text-right">
            @if(Session::get('roleID')=='us')
            <!-- Nút ADD -->
            <a href="{{action('classController@getClassAdd')}}"><button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='class_add'"><i class="fas fa-plus-square"></i>&ensp; Add</button></a>
            @endif
            <!-- Nút export -->
            &emsp;<button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='exportclass/export/{{$clubID}}'"><i class="fas fa-cloud-download-alt"></i>&ensp; Export</button>
            <!-- Nút history -->
            &emsp;<a href="{{action('classController@getClassHistory')}}"><button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle"><i class="fas fa-history"></i>&ensp; History</button></a>
        </div>
    </div>

    <div class="row mt-4">
        <table class="table table-striped table-hover" style="font-size: 15px; background: #eee;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"></th>
                    <th scope="col">Class ID</th>
                    <th scope="col">Class's Name</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Coach</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Assistant</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <?php $i = 1; ?>
            <tbody id='tb'>
                @foreach($data as $row)
                <tr>
                    <th scope="row"><?php echo $i++; ?> </th>
                    <td><img src="/projectTruc/public/{{$row->classImage}}" style="width: 40px; height: 40px;"></td>
                    <td>{{$row->classID}}</td>
                    <td>{{$row->className}}</td>
                    <td>{{$row->date}}</td>
                    <td>{{$row->startTime}} - {{$row->endTime}}</td>
                    <td>{{$row->coachName}}</td>
                    <td>{{$row->phone}}</td>
                    <td>{{$row->assistant}}</td>
                    <td>
                        <!-- Button chi tiet CLB --><i class="fas fa-info-circle" data-toggle="modal" data-target="#truc"></i>
                        <!-- Button Danh sách vo sinh -->&emsp;<i class="fas fa-list" onclick="showvalue('{{$row->classID}}','{{$row->className}}')" data-toggle="modal" data-target=".bs-example-modal-lg"></i>
                        @if(Session::get('roleID')=='us')
                        <!-- Button Sửa -->&emsp;<i class="far fa-edit" onclick="location.href='{{$row->clubID}}/{{$row->classID}}'"></i>
                        <!-- Button Xóa&emsp;<i class="far fa-trash-alt" onclick="location.href='delete/{{$row->clubID}}/{{$row->classID}}'"></i> -->
                        &emsp;<i class="far fa-trash-alt" onclick="deleteClass('{{$row->clubID}}','{{$row->classID}}','{{$row->className}}')"></i>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row" id="link">
            <div class="col-auto">{{ $data->links() }}</div>
        </div>
    </div>

    <!-- Popup Danh sách võ sinh của mỗi lớp -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <table class="table table-striped table-hover table-light_sky">
                    <!-- Tên lớp trong CSDL -->
                    <div class="row mt-3">
                        <div class="col-auto">&emsp;<i class="fas fa-list"></i>&emsp;<b>List martial artists of <span id='id'></span></b></div>
                    </div>
                    <div class="row mt-3"></div>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">MaID</th>
                            <th scope="col">Martial's Name</th>
                            <th scope="col">DOB</th>
                            <th scope="col">Gender</th>
                            <th scope="col">School</th>
                            <th scope="col">Level</th>
                            <th scope="col">Phone</th>
                        </tr>
                    </thead>
                    <tbody id='views'></tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end Popup danh scah1 vo sinh cua moi lop -->

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

</div>

<input type="hidden" class="form-control" name="clubID" id="clubID" value="{{$clubID}}" />
<script>
    function deleteClass(idclub, idclass, className) {

        Swal.fire({
            title: 'Are you sure delete "' + className + '" ?',
            // text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#00a550',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '{{action("classController@getClassDelete")}}',
                    type: 'GET',
                    data: {
                        idclub:idclub,
                        idclass:idclass
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

    function showvalue(classID, className) {
        // $s = $($)
        $('#id').text(className);
        $.ajax({
            url: '{{action("classController@getPopup")}}',
            type: 'GET',
            dataType: 'JSON',
            data: {
                classID: classID
            },
            success: function(data) {
                var noi = '';
                var count = 1;
                // if (data.length > 0) {
                    $.each(data, function(key, item) {
                        noi += '<tr>';
                        noi += '<td>' + count + '</td>';
                        noi += '<td>' + item.maID + '</td>';
                        noi += '<td>' + item.maName + '</td>';
                        noi += '<td>' + item.maDOB + '</td>';
                        noi += '<td>' + item.maGender + '</td>';
                        noi += '<td>' + item.school + '</td>';
                        noi += '<td>' + item.malevel + '</td>';
                        noi += '<td>' + item.maphone + '</td>';
                        noi += '</tr>';
                        count++;
                    })
                    $('#views').html(noi);
                //     $('#id').text(data[0].className);
                // } else {
                //     $('#id').text("");
                // }
            }

        });
    }

    $('#search').on('keyup', function() {
        var value = $("#search").val();
        var clubID = $("#clubID").val();
        if (value != '') {
            $.ajax({
                type: 'get',
                url: '{{action("classController@getSearch")}}',
                data: {
                    value: value,
                    clubID: clubID
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
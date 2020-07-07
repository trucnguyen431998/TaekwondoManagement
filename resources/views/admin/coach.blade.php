@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fab fa-joomla fa-fw mr-3"></span>COACH</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; Coach</div>


<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-12 text-right">
            @if (Session::get('roleID')=="ad")
            <!-- Nút ADD -->
            <button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='coach_add'"><i class="fas fa-plus-square"></i>&ensp; Add</button>
            <!-- Nút export -->
            &emsp;<button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='exportcoach'"><i class="fas fa-cloud-download-alt"></i>&ensp; Export</button>
            <!-- Nút history -->
            &emsp;<button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='coach_history'"><i class="fas fa-history"></i>&ensp; History</button>
            @endif
        </div>
    </div>
    <div class="row mt-4">
        <table class="table table-striped table-hover" style="font-size: 15px; background: #eee;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"></th>
                    <th scope="col">Coach ID</th>
                    <th scope="col">Coach's name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Email</th>
                    <th scope="col">Facebook</th>
                    <th scope="col">Zalo</th>
                    @if (Session::get('roleID')=="ad")
                    <th scope="col">Action</th>
                    @endif
                </tr>
            </thead>
            <?php $i = 1; ?>
            <tbody id='tb'>
                @if (Session::get('roleID')=="ad")
                @foreach($data as $row)
                <tr>
                    <th scope="row"> <?php echo $i++; ?> </th>
                    <td><img src="{{$row->coachImage}}" style="width: 30px; height: 30px;"></td>
                    <td>{{$row->coachID}}</td>
                    <td>{{$row->coachName}}</td>
                    <td>{{$row->phone}}</td>
                    <td>{{$row->email}}</td>
                    <td>{{$row->facebook}}</td>
                    <td>{{$row->zalo}}</td>
                    <td>
                        <!-- Button View --><i class="far fa-eye" onclick="location.href='coach_view/{{$row->coachID}}'"></i>
                        <!-- Button Danh sách lớp học của HLV này -->&emsp;<i class="fas fa-clipboard-list" onclick="showvalue('{{$row->coachID}}','{{$row->coachName}}')" data-toggle="modal" data-target=".bs-example-modal-lg"></i>
                        <!-- Button Sửa -->&emsp;<i class="far fa-edit" onclick="location.href='coach_edit/{{$row->coachID}}'"></i>
                        <!-- Button Xóa&emsp;<i class="far fa-trash-alt" onclick="location.href='coach/{{$row->coachID}}'"></i> -->
                        &emsp;<i class="far fa-trash-alt" onclick="deleteCoach('{{$row->coachID}}','{{$row->coachName}}')"></i>
                    </td>
                </tr>
                @endforeach
                @else
                @foreach($data as $row)
                <tr>
                    <th scope="row"> <?php echo $i++; ?> </th>
                    <td><img src="{{$row->coachImage}}" style="width: 30px; height: 30px;"></td>
                    <th>{{$row->coachID}}</th>
                    <td>{{$row->coachName}}</td>
                    <td>{{$row->phone}}</td>
                    <td>{{$row->email}}</td>
                    <td>{{$row->facebook}}</td>
                    <td>{{$row->zalo}}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
            <!-- <tbody id='viewSearch'></tbody> -->
        </table>
        <div class="row" id="link">
            <div class="col-auto">{{ $data->links() }}</div>
        </div>
    </div>
    <!-- Popup Danh sách lop của mỗi HLV giang day -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <table class="table table-striped table-hover table-light">
                    <!-- Tên lớp trong CSDL -->
                    <div class="row mt-3">
                        <div class="col-auto">&emsp;<i class="fas fa-list"></i>&emsp;<b>List class of <span id='id'></span></b></div>
                    </div>
                    <div class="row mt-3"></div>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Class's name</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody id='views'></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteCoach(coachID, coachName) {

        Swal.fire({
            title: 'Are you sure delete "' + coachName + '" ?',
            // text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#00a550',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '{{action("coachController@getCoachDelete")}}',
                    type: 'GET',
                    data: {
                        coachID:coachID,
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

    function showvalue(coachID, coachName) {
        $s = $($)
        $('#id').text(coachName);
        $.ajax({
            url: '{{action("coachController@getPopup")}}',
            type: 'GET',
            dataType: 'JSON',
            data: {
                coachID: coachID
            },
            success: function(data) {
                var noi = '';
                var count = 1;
                // if (data.length > 0) {
                $.each(data, function(key, item) {
                    noi += '<tr>';
                    noi += '<td>' + count + '</td>';
                    noi += '<td>' + item.className + '</td>';
                    noi += '<td>' + item.date + '</td>';
                    noi += '</tr>';
                    count++;
                })
                $('#views').html(noi);
                $('#id').text(data[0].coachName);
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
                url: '{{action("coachController@getSearch")}}',
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
@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fa fa-calendar fa-fw mr-3"></span>EXAM</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; Exam</div>


<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-12 text-right">
            @if (Session::get('roleID')=="ad")
            <!-- Nút ADD -->
            <button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='exam_add'"><i class="fas fa-plus-square"></i>&ensp; Add</button>
            <!-- Nút export -->
            &emsp;<button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='exportexam'"><i class="fas fa-cloud-download-alt"></i>&ensp; Export</button>
            <!-- Nút history -->
            &emsp;<button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='exam_history'"><i class="fas fa-history"></i>&ensp; History</button>
            @endif
        </div>
    </div>
    <div class="row mt-4">
        <table class="table table-striped table-hover" style="font-size: 14px; background: #eee;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Exam ID</th>
                    <th scope="col">Exam name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Date Start</th>
                    <th scope="col">Date End</th>
                    <th scope="col">Organizers</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <?php $i = 1; ?>
            <tbody id="tb">
                @if (Session::get('roleID')=="ad")
                @foreach($data as $row)
                <tr>
                    <th scope="row"><?php echo $i++; ?></th>
                    <td>{{$row->examID}}</td>
                    <td>{{$row->examName}}</td>
                    <td>{{$row->address}}</td>
                    <td>{{$row->dateStart}}</td>
                    <td>{{$row->dateEnd}}</td>
                    <td>{{$row->organizers}}</td>
                    <td>
                        <!-- Button Danh sách võ sinh của kỳ thi --><i class="fas fa-clipboard-list" onclick="location.href='exam_list/{{$row->examID}}'"></i>
                        <!-- Button Danh sách võ sinh chua co trong kỳ thi -->&ensp;<i class="fas fa-list" onclick="location.href='exam_listin/{{$row->examID}}'"></i>
                        <!-- Button Kết quả thi của võ sinh -->&ensp;<i class="fas fa-medal" onclick="location.href='exam_result/{{$row->examID}}'"></i>
                        <!-- Button Sửa -->&ensp;<i class="far fa-edit" onclick="location.href='exam_edit/{{$row->examID}}'"></i>
                        <!-- Button Xóa&ensp;<i class="far fa-trash-alt" onclick="location.href='exam/{{$row->examID}}'"></i> -->
                        &ensp;<i class="far fa-trash-alt" onclick="deleteExam('{{$row->examID}}','{{$row->examName}}')"></i>
                    </td>
                </tr>
                @endforeach
                @else
                @foreach($data as $row)
                <tr>
                    <th scope="row"><?php echo $i++; ?></th>
                    <td>{{$row->examID}}</td>
                    <td>{{$row->examName}}</td>
                    <td>{{$row->address}}</td>
                    <td>{{$row->dateStart}}</td>
                    <td>{{$row->dateEnd}}</td>
                    <td>{{$row->organizers}}</td>
                    <td>
                        <!-- Button Danh sách võ sinh của kỳ thi --> <i class="fas fa-clipboard-list" onclick="location.href='exam_list/{{$row->examID}}'"></i>
                        <!-- Button Danh sách võ sinh chua co trong kỳ thi -->&ensp;<i class="fas fa-list" onclick="location.href='exam_listin/{{$row->examID}}'"></i>
                        <!-- Button Kết quả thi của võ sinh -->&ensp;<i class="fas fa-medal" onclick="location.href='exam_result/{{$row->examID}}'"></i>
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
</div>

<script>
    $('#search').on('keyup', function() {
        var value = $("#search").val();
        if (value != '') {
            $.ajax({
                type: 'get',
                url: '{{action("examController@getSearch")}}',
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


    function deleteExam(examID, examName) {

        Swal.fire({
            title: 'Are you sure delete "' + examName + '" ?',
            // text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#00a550',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '{{action("examController@getExamDelete")}}',
                    type: 'GET',
                    data: {
                        examID: examID,
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
</script>
@endsection
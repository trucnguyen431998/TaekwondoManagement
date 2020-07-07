@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fa fa-university fa-fw mr-3"></span>CLUB</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="{{action('clubController@getClub')}}">Club</a> &emsp;/&emsp; History</div>


<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-12 text-right">
            <!-- Nút home -->
            &emsp;<button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='club'"><i class="fas fa-ellipsis-v"></i></button>
        </div>
    </div>

    <div class="row mt-4" style="color: #fff;">
        <table class="table table-striped table-hover" style="font-size: 15px; background: #eee;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Club ID</th>
                    <th scope="col">Club's name</th>
                    <th scope="col">Manager</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Updated at</th>
                </tr>
            </thead>
            <?php $i = 1; ?>
            <tbody>
                @foreach($data as $row)
                <tr>
                    <th scope="row"><?php echo $i++; ?></th>
                    <th scope="row">{{$row->clubID}}</th>
                    <td>{{$row->clubName}}</td>
                    <td>{{$row->coachName}}</td>
                    <td>{{ date('d-m-Y', strtotime($row->created_at)) }}</td>
                    <td>{{ date('d-m-Y', strtotime($row->updated_at)) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
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
                        <tbody id='views'>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    function showvalue(clubID) {
        $s = $($)
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
                if (data.length > 0) {
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
                    $('#id').text(data[0].clubName);
                } else {
                    $('#id').text("");
                }
            }

        });
    }
</script>
@endsection
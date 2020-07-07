@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fa fa-university fa-fw mr-3"></span>CLASS</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="{{action('clubController@getClub')}}">Club</a> &emsp; / &emsp; Class &emsp; / &emsp;History</div>


<div class="container-fluid">
    <div class="row mt-4">
    <div class="col-12 text-right">
            <!-- Nút home -->
            &emsp;<button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='club'"><i class="fas fa-ellipsis-v"></i></button>
        </div>
    </div>

    <div class="row mt-4">
        <table class="table table-striped table-hover" style="font-size: 15px; background: #eee;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Class ID</th>
                    <th scope="col">Class's name</th>
                    <th scope="col">User</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Updated at</th>
                </tr>
            </thead>
            <?php $i = 1; ?>
            <tbody>
                @foreach($data as $row)
                <tr>
                <th scope="row"><?php echo $i++; ?> </th>
                    <th scope="row">{{$row->classID}}</th>
                    <td>{{$row->className}}</td>
                    <td>{{$row->classaccount}}</td>
                    <td>{{ date('d-m-Y', strtotime($row->created_at)) }}</td>
                    <td>{{ date('d-m-Y', strtotime($row->updated_at)) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Popup Danh sách võ sinh của mỗi lớp -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <table class="table table-striped table-hover table-light_sky">
                    <!-- Tên lớp trong CSDL -->
                    <div class="row mt-3">
                        <div class="col-auto">&emsp;<i class="fas fa-list"></i>&emsp;<b>List martial artists of <span id='id'></span> class</b></div>
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
                    <tbody id='views'>
                        <!-- <tr>
                            <th scope="row">1</th>
                            <td>Nguyễn Thị Thanh Thảo</td>
                            <td>10 - 03 - 2003</td>
                            <td>Female</td>
                            <td>Di An Highschool</td>
                            <td>2</td>
                            <td>0123456789</td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<script>
    function showvalue(classID) {
        $s = $($)
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
                if (data.length > 0) {
                    $.each(data, function(key, item) {
                        noi += '<tr>';
                        noi += '<td>' + count + '</td>';
                        noi += '<td>' + item.maID + '</td>';
                        noi += '<td>' + item.maName + '</td>';
                        noi += '<td>' + item.maDOB + '</td>';
                        noi += '<td>' + item.maGender + '</td>';
                        noi += '<td>' + item.school + '</td>';
                        noi += '<td>' + item.level + '</td>';
                        noi += '<td>' + item.phone + '</td>';
                        noi += '</tr>';
                        count++;
                    })
                    $('#views').html(noi);
                    $('#id').text(data[0].className);
                } else {
                    $('#id').text("");
                }
            }

        });
    }
</script>
@endsection
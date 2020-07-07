@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fa fa-calendar fa-fw mr-3"></span>LIST MARTIAL ARTIST COMPLETE</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="{{action('revenuesController@getRevenues')}}">Revenues</a> &emsp;/&emsp; <a href="{{action('revenuesController@getRevenuesCol')}}">Collection content</a> &emsp;/&emsp; List martial artist complete</div>


<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-3">
            <!-- Filter -->
            <!-- <input type="text" class="form-control" /> -->
        </div>
        <div class="col-3">
            <!-- Filter -->
            <!-- <input type="text" class="form-control" /> -->
        </div>
        <div class="col-6 text-right">
            <!-- Nút Export -->
            &emsp;<button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='exportlistcom/export/{{$revID}}'"><i class="fas fa-cloud-download-alt"></i>&ensp; Export</button>
            <!-- Nút EXIT -->
            &emsp;<a href="{{action('revenuesController@getRevenuesCol')}}"><button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle"><i class="fas fa-ellipsis-v"></i></button></a>
        </div>
    </div>
    <div class="row mt-4">
        <table class="table table-striped table-hover" style="font-size: 15px; background: #eee;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Martial artist ID</th>
                    <th scope="col">Martial artist's name</th>
                    <th scope="col">DOB</th>
                    <th scope="col">Class's name</th>
                    @if (Session::get('roleID')=="ad")
                    @else
                    <th scope="col">Action</th>
                    @endif
                </tr>
            </thead>
            <?php $i = 1 ?>
            <tbody id="tb">
                @foreach($data as $row)
                <tr>
                    <th scope="row"><?php echo $i++; ?></th>
                    <td>{{$row->maID}}</td>
                    <td>{{$row->maName}}</td>
                    <td>{{$row->maDOB}}</td>
                    <td>{{$row->className}}</td>
                    @if (Session::get('roleID')=="ad")
                    @else
                    <td>
                        <!-- Button Xóa -->&emsp;<i class="far fa-trash-alt" onclick="deleteCom('{{$row->recID}}')"></i>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<input type="hidden" id="coachID" value="{{Session::get('coachID')}}">
<input type="hidden" id="revID" value="{{$revID}}">

<script type="text/javascript">
    function deleteCom(recID) {
        var coachID = $("#coachID").val();
        //alert(revID+'-'+maID);
        $.ajax({
            url: '{{action("revenuesController@getRevenuesColReciptDelete")}}',
            type: 'GET',
            data: {
                recID: recID,
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
        var revID = $("#revID").val();
        if (value != '') {
            $.ajax({
                type: 'get',
                url: '{{action("revenuesController@getSearchList")}}',
                data: {
                    value: value,
                    revID: revID
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

    //filter
</script>
@endsection
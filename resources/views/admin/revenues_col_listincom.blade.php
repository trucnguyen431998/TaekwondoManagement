@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fa fa-calendar fa-fw mr-3"></span>LIST MARTIAL ARTIST INCOMPLETE</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="{{action('revenuesController@getRevenues')}}">Revenues</a> &emsp;/&emsp; <a href="{{action('revenuesController@getRevenuesCol')}}">Collection content</a> &emsp;/&emsp; List martial artist incomplete</div>


<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-6"></div>
        <div class="col-6 text-right">
            <!-- Nút EXPORT -->
            &emsp;<button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='exportlistcomin/export/{{$revID}}'"><i class="fas fa-cloud-download-alt"></i>&ensp; Export</button>
            <!-- Nút EXIT -->
            &emsp;<a href="{{action('revenuesController@getRevenuesCol')}}"><button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle"><i class="fas fa-ellipsis-v"></i></button></a>
        </div>
    </div>
    @if(session('thongbao'))
    <div class="row mt-4"></div>
    <div class="alert alert-success">
        {{session('thongbao')}}
    </div>
    @endif
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
            <tbody>
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
                        <!-- Button add &emsp;<i class="fas fa-plus-square" onclick="location.href='{{$revID}}/{{$row->maID}}'"></i> -->
                        &emsp;<i class="fas fa-plus-square" onclick="insertCom('{{$revID}}','{{$row->maID}}')"></i>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<input type="hidden" id="coachID" value="{{Session::get('coachID')}}">
<input type="hidden" id="clubID" value="{{$clubID}}">

<script type="text/javascript">
    function insertCom(revID, maID) {
        var clubID = $("#clubID").val();
        var coachID = $("#coachID").val();
        //alert(revID+'-'+maID);
        $.ajax({
            url: '{{action("revenuesController@getRevenuesColRecipt")}}',
            type: 'GET',
            data: {
                revID: revID,
                maID: maID,
                coachID: coachID,
                clubID: clubID
            },
            success: function(data) {
                location.reload();
            }
        })
    }
</script>

@endsection
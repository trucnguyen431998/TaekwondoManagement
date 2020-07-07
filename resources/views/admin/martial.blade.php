@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fa fa-user fa-fw mr-3"></span>MARTIAL ARTIST</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; Martial Artist</div>


<div class="container-fluid">
    <div class="row mt-4">

        <div class="col-3">
            <!-- Filter -->
            <select name="type" id="type" class="form-control">
                <option value=""></option>
                @if (Session::get('roleID')=="ad")
                <option value="club">Club</option>
                <option value="coach">Coach</option>
                @endif
                <option value="class">Class</option>
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
            <button class="button" style="color: #0099ff; font-size: 18px;" id="add" onclick="location.href='martial'"><i class="fas fa-filter"></i></button>
        </div>
        <div class="col-5 text-right">
            @if (Session::get('roleID')=="us")
            <!-- Nút ADD -->
            <button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='martial_add'"><i class="fas fa-plus-square"></i>&ensp; Add</button>
            @endif
            <!-- Nút export -->
            &emsp;<button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='exportmartial'"><i class="fas fa-cloud-download-alt"></i>&ensp; Export</button>
            <!-- Nút history -->
            &emsp;<button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='martial_history'"><i class="fas fa-history"></i>&ensp; History</button>
        </div>
    </div>

    <div class="row mt-4" style="color: #fff; background: #eee;">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"></th>
                    <th scope="col">ID</th>
                    <th scope="col">Full Name</th>
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
                    <td><img src="{{$row->maImage}}" style="width: 30px; height: 30px;"></td>
                    <td>{{$row->maID}}</td>
                    <td>{{$row->maName}}</td>
                    <td>{{$row->clubName}}</td>
                    <td>{{$row->className}}</td>
                    <td>{{$row->coachName}}</td>
                    <td>{{$row->malevel}}</td>
                    <td>
                        @if (Session::get('roleID')=="ad")
                        <!-- Button View --><i class="far fa-eye" onclick="location.href='martial_view/{{$row->maID}}'"></i>
                        @else
                        <!-- Button View --><i class="far fa-eye" onclick="location.href='martial_view/{{$row->maID}}'"></i>
                        <!-- Button Sửa -->&emsp;<i class="far fa-edit" onclick="location.href='martial_edit/{{$row->maID}}'"></i>
                        <!-- Button Xóa&emsp;<i class="far fa-trash-alt" onclick="location.href='martial/{{$row->maID}}'"></i> -->
                        &emsp;<i class="far fa-trash-alt" onclick="deleteMa('{{$row->maID}}','{{$row->maName}}')"></i>
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
</div>

<script type="text/javascript">
    function deleteMa(maID, maName) {

        Swal.fire({
            title: 'Are you sure delete "' + maName + '" ?',
            // text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#00a550',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '{{action("martialController@getMartialDelete")}}',
                    type: 'GET',
                    data: {
                        maID: maID,
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

    $('#type').change(function() {
        var selected = $('#type option:selected').val();
        $.ajax({
            url: '{{action("martialController@getfilter")}}',
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
                } else if (selected == "") {
                    location.reload();
                }

                $("#datatype").html(htm);

            }
        })
    });

    $('#search').on('keyup', function() {
        var value = $("#search").val();
        if (value != '') {
            $.ajax({
                type: 'get',
                url: '{{action("martialController@getSearch")}}',
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

    $('#datatype').change(function() {
        var value = $("#datatype").val();
        if (value != '') {
            $.ajax({
                type: 'get',
                url: '{{action("martialController@getFilterMA")}}',
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
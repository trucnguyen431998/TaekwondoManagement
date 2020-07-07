@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fa fa-calendar fa-fw mr-3"></span>COLLECTION CONTENT</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="revenues">Revenues</a> &emsp;/&emsp; Collection content</div>


<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-3">
            <!-- Filter -->
            <select name="clubID" id="clubID" class="form-control" onchange="hideButton();">
                @foreach($dataclub as $row)
                <option value="{{$row->clubID}}">{{$row->clubName}}</option>
                @endforeach
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
            <button class="button" style="color: #0099ff; font-size: 18px;" id="add" onclick="location.href='revenues_col'"><i class="fas fa-filter"></i></button>
        </div>
        <div class="col-8 text-right">
            @if (Session::get('roleID')=="us")
            <!-- Nút ADD -->
            <button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='revenues_col_add'"><i class="fas fa-plus-square"></i>&ensp; Add</button>
            @endif
            <!-- Nút export -->
            &emsp;<button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='exportrev'"><i class="fas fa-cloud-download-alt"></i>&ensp; Export</button>
            <!-- Nút history -->
            &emsp;<button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='revenues_col_history'"><i class="fas fa-history"></i>&ensp; History</button>
        </div>
    </div>
    <div class="row mt-4">
        <table class="table table-striped table-hover" style="font-size: 15px; background: #eee;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Month</th>
                    <th scope="col">Club's name</th>
                    <th scope="col">Class's name</th>
                    <th scope="col">Into money</th>
                    <th scope="col">Complete</th>
                    <th scope="col">Incomplete</th>
                    @if (Session::get('roleID')=="us")
                    <th scope="col">Action</th>
                    @endif
                </tr>
            </thead>
            <?php $i = 1; ?>
            <tbody id="tb">
                @foreach($data as $row)
                <tr>
                    <th scope="row"><?php echo $i++; ?></th>
                    <td>{{$row->revID}}</td>
                    <td>{{$row->revName}}</td>
                    <td>{{$row->month}}</td>
                    <td>{{$row->clubName}}</td>
                    <td>{{$row->className}}</td>
                    <td>{{$row->intoMoney}}</td>
                    <td><i class="far fa-smile-beam" onclick="location.href='revenues_col_listcom/{{$row->revID}}'"></i></td>
                    <td><i class="far fa-sad-tear" onclick="location.href='revenues_col_listincom/{{$row->revID}}/{{$row->clubID}}'"></i></td>
                    @if (Session::get('roleID')=="us")
                    <td>
                        <!-- Button Sửa -->&emsp;<i class="far fa-edit" onclick="location.href='revenues_col_edit/{{$row->revID}}'"></i>
                        <!-- Button Xóa&emsp;<i class="far fa-trash-alt" onclick="location.href='revenues_col/{{$row->revID}}'"></i> -->
                        &emsp;<i class="far fa-trash-alt" onclick="deleteCol('{{$row->revID}}','{{$row->revName}}')"></i>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>
</div>
<script>
    function deleteCol(revID, revName) {

        Swal.fire({
            title: 'Are you sure delete "' + revName + '" ?',
            // text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#00a550',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '{{action("revenuesController@getRevenuesColDelete")}}',
                    type: 'GET',
                    data: {
                        revID: revID,
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

    $('#search').on('keyup', function() {
        var value = $("#search").val();
        if (value != '') {
            $.ajax({
                type: 'get',
                url: '{{action("revenuesController@getSearch")}}',
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

    $('#clubID').change(function() {
        var value = $("#clubID").val();
        if (value != '') {
            $.ajax({
                type: 'get',
                url: '{{action("revenuesController@getFilterRev")}}',
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
@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fa fa-calendar fa-fw mr-3"></span>PAY CONTENT</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="revenues">Revenues</a> &emsp;/&emsp; Pay content</div>


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
            <button class="button" style="color: #0099ff; font-size: 18px;" id="add" onclick="location.href='revenues_pay'"><i class="fas fa-filter"></i></button>
        </div>
        <div class="col-8 text-right">
            @if (Session::get('roleID')=="ad")
            <!-- Nút export -->
            &emsp;<button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='exportpay'"><i class="fas fa-cloud-download-alt"></i>&ensp; Export</button>
            @else
            <!-- Nút ADD -->
            <button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='revenues_pay_add'"><i class="fas fa-plus-square"></i>&ensp; Add</button>
            <!-- Nút export -->
            &emsp;<button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='exportpay'"><i class="fas fa-cloud-download-alt"></i>&ensp; Export</button>
            <!-- Nút history -->
            &emsp;<button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='revenues_pay_history'"><i class="fas fa-history"></i>&ensp; History</button>
            @endif
        </div>
    </div>
    <div class="row mt-4">
        <table class="table table-striped table-hover" style="font-size: 15px; background: #eee;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Pay ID</th>
                    <th scope="col">Club's name</th>
                    <th scope="col">Class's name</th>
                    <th scope="col">Date</th>
                    <th scope="col">Month</th>
                    <th scope="col">Into money</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <?php $i = 1; ?>
            <tbody id="tb">
                @foreach($data as $row)
                <tr>
                    <th scope="row"><?php echo $i++; ?></th>
                    <td>{{$row->payID}}</td>
                    <td>{{$row->clubName}}</td>
                    <td>{{$row->className}}</td>
                    <td>{{$row->datePay}}</td>
                    <td>{{$row->month}}</td>
                    <td>{{$row->intoMoney}}</td>
                    <td>
                        <!-- Button Chi tiết --><i class="fas fa-info-circle" onclick="showDes('{{$row->payID}}')" data-toggle="modal" data-target=".bs-example-modal-lg"></i>
                        @if (Session::get('roleID')=="us")
                        <!-- Button Sửa -->&emsp;<i class="far fa-edit" onclick="location.href='revenues_pay_edit/{{$row->payID}}'"></i>
                        <!-- Button Xóa&emsp;<i class="far fa-trash-alt" onclick="location.href='revenues_pay/{{$row->payID}}'"></i> -->
                        &emsp;<i class="far fa-trash-alt" onclick="deletePay('{{$row->payID}}')"></i>
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

    <!-- Popup mô tả chi tiết của ND chi -->
    <div class="modal fade bs-example-modal-lg" id="listcoach" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="row mt-3">
                    <div class="col-auto">&emsp;<i class="fas fa-info-circle"></i>&emsp;<b>Description of <span id='id'></span> </b></div>
                </div>
                <div class="row mt-4">
                    <div class="col-2"></div>
                    <div class="col-8" id='views'></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function deletePay(payID) {

        Swal.fire({
            title: 'Are you sure delete "' + payID + '" ?',
            // text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#00a550',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '{{action("payController@getRevenuesPayDelete")}}',
                    type: 'GET',
                    data: {
                        payID: payID,
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

    //popup
    function showDes(payID) {
        $s = $($)
        //alert(payID);
        $.ajax({
            url: '{{action("payController@getPopup")}}',
            type: 'GET',
            dataType: 'JSON',
            data: {
                payID: payID
            },
            success: function(data) {
                if (data.length > 0) {
                    $('#id').text(data[0].payID);
                    $('#views').text(data[0].description);
                }
            }

        });
    }

    //tim kiem
    $('#search').on('keyup', function() {
        var value = $("#search").val();
        if (value != '') {
            $.ajax({
                type: 'get',
                url: '{{action("payController@getSearch")}}',
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

    //loc
    $('#clubID').change(function() {
        var value = $("#clubID").val();
        if (value != '') {
            $.ajax({
                type: 'get',
                url: '{{action("payController@getFilterPay")}}',
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
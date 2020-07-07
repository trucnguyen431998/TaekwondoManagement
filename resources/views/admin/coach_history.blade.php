@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fab fa-joomla fa-fw mr-3"></span>COACH</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="coach">Coach</a> &emsp; / &emsp; History</div>


<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-12 text-right">
            <!-- Nút export -->
            &emsp;<button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='coach'"><i class="fas fa-ellipsis-v"></i></button>
        </div>
    </div>
    <div class="row mt-4">
        <table class="table table-striped table-hover" style="font-size: 15px; background: #eee;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Coach ID</th>
                    <th scope="col">Coach's name</th>
                    <th scope="col">User</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Updated at</th>
                </tr>
            </thead>
            <?php $i = 1; ?>
            <tbody>
                @foreach($data as $row)
                <tr>
                    <th scope="row"><?php echo $i++; ?></th>
                    <th scope="row">{{$row->coachID}}</th>
                    <td>{{$row->coachName}}</td>
                    <td>{{$row->accountName}}</td>
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
    <!-- Popup Danh sách CLB của mỗi HLV quản lý -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <table class="table table-striped table-hover table-light">
                    <!-- Tên lớp trong CSDL -->
                    <div class="row mt-3">
                        <div class="col-auto">&emsp;<i class="fas fa-list"></i>&emsp;<b>Danh sách CLB của HLV quản lý</b></div>
                    </div>
                    <div class="row mt-3"></div>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Club Name</th>
                            <th scope="col">Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>San Van Dong</td>
                            <td>DH - DA - BD</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
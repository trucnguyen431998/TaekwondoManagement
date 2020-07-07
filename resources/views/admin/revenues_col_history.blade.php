@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fa fa-calendar fa-fw mr-3"></span>COLLECTION CONTENT</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="revenues">Revenues</a> &emsp;/&emsp; <a href="revenues_col">Collection content</a> &emsp;/&emsp; History</div>

<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-12 text-right">
            <!-- Nút home -->
            &emsp;<button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='revenues_col'"><i class="fas fa-ellipsis-v"></i></button>
        </div>
    </div>
    <div class="row mt-4">
        <table class="table table-striped table-hover" style="font-size: 15px; background: #eee;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Collection ID</th>
                    <th scope="col">Collection name</th>
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
                    <th scope="row">{{$row->revID}}</th>
                    <td>{{$row->revName}}</td>
                    <td>{{$row->revaccount}}</td>
                    <td>{{ date('d-m-Y', strtotime($row->created_at)) }}</td>
                    <td>{{ date('d-m-Y', strtotime($row->updated_at)) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fa fa-user fa-fw mr-3"></span>MARTIAL ARTIST</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="{{action('martialController@getMartial')}}">Martial Artist</a> &emsp;/&emsp; History</div>


<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-12 text-right">
            <!-- Nút home -->
            &emsp;<button class="button" style="color: #0099ff; font-size: 18px;" id="menu-toggle" onclick="location.href='martial'"><i class="fas fa-ellipsis-v"></i></button>
        </div>
    </div>

    <div class="row mt-4" style="color: #fff;">
        <table class="table table-striped table-hover table-dark">
            <thead>
                <tr>
                <th scope="col">#</th>
                    <th scope="col">Martial artist's name</th>
                    <th scope="col">User</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Updated at</th>
                </tr>
            </thead>
            <tbody>
            @foreach($data as $row)
                <tr>
                    <th scope="row">{{$row->maID}}</th>
                    <td>{{$row->maName}}</td>
                    <td>{{$row->maaccount}}</td>
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
</div>
@endsection
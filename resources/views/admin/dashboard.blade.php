@extends('admin.master')
@section('detail')

<div class="row" style="color: #fff">
    <h2><span class="fa fa-dashboard fa-fw mr-3"></span>DASHBOARD</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; <a href="dashboard">Dashboard</a></div>
<div class="container-fluid">
    <!-- START Thông tin số lượng-->
    <div class="row mt-4">
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0" style="background-color: #0099ff; color: #fff;">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0"></h5>
                            <span class="fa fa-university" aria-hidden="true" style="font-size: 70px;"></span>
                        </div>
                        <div class="col-auto">
                            <div class="row">
                                <h5 class="card-title text-uppercase text-muted mb-0"></h5>
                                <!-- Số lượng CLB -->
                                <span class="h2 font-weight-bold mb-0">{{$queryclub}}</span>
                            </div>
                            <div class="row">
                                <h5 class="card-title text-uppercase text-muted mb-0"></h5>
                                <!-- Số lượng CLB -->
                                <span class="h2 font-weight-bold mb-0">Clubs</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0" style="background-color: #ff9966; color: #fff;">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0"></h5>
                            <span class="fab fa-joomla" aria-hidden="true" style="font-size: 70px;"></span>
                        </div>
                        <div class="col-auto">
                            <div class="row">
                                <h5 class="card-title text-uppercase text-muted mb-0"></h5>
                                <!-- Số lượng HLV -->
                                <span class="h2 font-weight-bold mb-0">{{$querycoach}}</span>
                            </div>
                            <div class="row">
                                <h5 class="card-title text-uppercase text-muted mb-0"></h5>
                                <!-- Số lượng HLV -->
                                <span class="h2 font-weight-bold mb-0">Coachs</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0" style="background-color: #0099ff; color: #fff;">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0"></h5>
                            <span class="fa fa-user" aria-hidden="true" style="font-size: 70px;"></span>
                        </div>
                        <div class="col-auto">
                            <div class="row">
                                <h5 class="card-title text-uppercase text-muted mb-0"></h5>
                                <!-- Số lượng Võ sinh -->
                                <span class="h2 font-weight-bold mb-0">{{$querymartial}}</span>
                            </div>
                            <div class="row">
                                <h5 class="card-title text-uppercase text-muted mb-0"></h5>
                                <!-- Số lượng Võ sinh -->
                                <span class="h2 font-weight-bold mb-0">Martials</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0" style="background-color: #ff9966; color: #fff;">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0"></h5>
                            <span class="fa fa-calendar" aria-hidden="true" style="font-size: 70px;"></span>
                        </div>
                        <div class="col-auto">
                            <div class="row">
                                <h5 class="card-title text-uppercase text-muted mb-0"></h5>
                                <!-- Số lượng Kỳ thi -->
                                <span class="h2 font-weight-bold mb-0">{{$queryexam}}</span>
                            </div>
                            <div class="row">
                                <h5 class="card-title text-uppercase text-muted mb-0"></h5>
                                <!-- Số lượng Kỳ thi -->
                                <span class="h2 font-weight-bold mb-0">Exams</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Thông tin số lượng-->

    <div class="row mt-4">
        <div class="col-12">
            <!-- Khung ngoài -->
            <div style="padding: 10px; border: 1px solid #0099ff; word-wrap: break-word;">
                <!-- Khung tên biểu đồ -->
                <div style="text-align: left; color: #FFFFFF; background-color: #0099ff; padding: 8px; border: 2px solid #0099ff; word-wrap: break-word;">
                    <i class="far fa-calendar-alt"></i>&emsp; Calendar
                </div>
                <div class="container-fluid" style="background-color: #fff;">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- START 2 biểu đồ đầu-->
    <div class="row mt-4">
        <!-- Biểu đồ 1 -->
        <div class="col-xl-6 col-lg-6">
            <!-- Khung ngoài -->
            <div style="padding: 10px; border: 1px solid #0099ff; word-wrap: break-word;">
                <!-- Khung tên biểu đồ -->
                <div style="text-align: left; color: #FFFFFF; background-color: #0099ff; padding: 8px; border: 2px solid #0099ff; word-wrap: break-word;">
                    <i class="fas fa-chart-bar"></i>&emsp; Biểu đồ cột thể hiện số lượng lớp học của mỗi CLB
                </div>

                <div id="chart-container" style="background-color: #ddd;">
                    <canvas id="graphCanvasPoint01"></canvas>
                </div>

            </div>
        </div>

        <!-- Biểu đồ 3 -->
        <div class="col-xl-6 col-lg-6">
            <!-- Khung ngoài -->
            <div style="padding: 10px; border: 1px solid #0099ff; word-wrap: break-word;">
                <!-- Khung tên biểu đồ -->
                <div style="text-align: left; color: #FFFFFF; background-color: #0099ff; padding: 8px; border: 2px solid #0099ff; word-wrap: break-word;">
                    <i class="fas fa-chart-bar"></i>&emsp; Biểu đồ cột thể hiện số lượng võ sinh của mỗi lớp
                </div>
                <div id="chart-container" style="background-color: #ddd;">
                    <canvas id="graphCanvasPoint02"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END 2 biểu đồ đầu-->



<script type="text/javascript">
    // $(document).ready(function(){
    //     showGraphPoint();
    // });
    $(document).ready(function() {
        showGraphPoint01();
        showGraphPoint02();
    });

    $(document).ready(function() {
        var calendar = $('#calendar').fullCalendar({
            //editable: true,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            events: "{{action('mainController@getCalendar')}}",
            selectable: true,
            selectHelper: true,
            height: 550,
        });
    });


    function showGraphPoint01() {
        {
            $.ajax({
                url: "{{action('mainController@getChart01')}}",
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {

                    // alert(data);
                    var name = [];
                    var dem = [];
                    for (var i in data) {
                        //alert(data[i].names);
                        //console.log(data[i].countClass);
                        name.push(data[i].clubID);
                        dem.push(data[i].countClass);
                    }
                    var chartdata = {
                        labels: name,
                        datasets: [{
                            label: 'Number class ',
                            //backgroundColor: '#ff0000',
                            borderColor: '#ff0000',
                            hoverBackgroundColor: '#660000',
                            hoverBorderColor: '#660000',
                            data: dem
                        }]
                    };

                    var graphTarget = $("#graphCanvasPoint01");
                    var barGraph = new Chart(graphTarget, {
                        type: 'line', //bar,pie,line,radar...
                        data: chartdata
                    });
                }
            });
        }
    }

    function showGraphPoint02() {
        {
            $.ajax({
                url: "{{action('mainController@getChart02')}}",
                type: 'GET',
                dataType: 'JSON', //Tra ve kieu json
                success: function(data) {
                    // alert(data);
                    var name = [];
                    var dem = [];
                    for (var i in data) {
                        //alert(data[i].names);
                        //console.log(data[i].countClass);
                        name.push(data[i].classID);
                        dem.push(data[i].countMartial);
                    }
                    var chartdata = {
                        labels: name,
                        datasets: [{
                            label: 'Number martial ',
                            backgroundColor: '#00ff00',
                            borderColor: '#00ff00',
                            hoverBackgroundColor: '#007700',
                            hoverBorderColor: '#007700',
                            data: dem
                        }]
                    };

                    var graphTarget = $("#graphCanvasPoint02");
                    var barGraph = new Chart(graphTarget, {
                        type: 'bar', //bar,pie,line,radar...
                        data: chartdata
                    });
                }
            });
        }
    }
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
@endsection
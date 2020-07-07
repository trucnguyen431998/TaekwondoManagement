@extends('admin.master')
@section('detail')
<div class="row" style="color: #fff">
    <h2><span class="fas fa-bell fa-fw mr-3"></span>REVENUES</h2>
</div>
<div class="row bg-white" style="color: #333">&emsp; Revenues</div>
<div class="container-fluid">
    <!-- START Button ND -->
    <div class="row mt-4">
        <div class="col-xl-6 col-lg-6" onclick="location.href='revenues_col'">
            <div class="card card-stats mb-4 mb-xl-0" style="background-color: #ff9966; color: #fff;">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0"></h5>
                            <span class="fas fa-battery-full" aria-hidden="true" style="font-size: 60px;"></span>
                        </div>
                        <div class="col-auto">
                            <h5 class="card-title text-uppercase text-muted mb-0"></h5>
                            <!-- Số lượng CLB -->
                            <span class="h2 font-weight-bold mb-0">Collection Content</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6" onclick="location.href='revenues_pay'">
            <div class="card card-stats mb-4 mb-xl-0" style="background-color: #ff9966; color: #fff;">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0"></h5>
                            <span class="fas fa-battery-empty" aria-hidden="true" style="font-size: 60px;"></span>
                        </div>
                        <div class="col-auto">
                            <h5 class="card-title text-uppercase text-muted mb-0"></h5>
                            <!-- Số lượng HLV -->
                            <span class="h2 font-weight-bold mb-0">Pay Content</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- END Button ND -->

    <!-- START 2 biểu đồ -->
    <div class="row mt-4">
        <!-- Biểu đồ 3 -->
        <div class="col-xl-6 col-lg-6">
            <!-- Khung ngoài -->
            <div style="padding: 10px; border: 1px solid #0099ff; word-wrap: break-word;">
                <!-- Khung tên biểu đồ -->
                <div style="text-align: left; color: #FFFFFF; background-color: #0099ff; padding: 8px; border: 2px solid #0099ff; word-wrap: break-word;">
                    <i class="fas fa-chart-area"></i>&emsp; Biểu đồ đường thể hiện mức thu của từng tháng
                </div>
                <div id="chart-container">
                    <canvas id="graphCanvasPoint01"></canvas>
                </div>
            </div>
        </div>

        <!-- Biểu đồ 4 -->
        <div class="col-xl-6 col-lg-6">
            <!-- Khung ngoài -->
            <div style="padding: 10px; border: 1px solid #0099ff; word-wrap: break-word;">
                <!-- Khung tên biểu đồ -->
                <div style="text-align: left; color: #FFFFFF; background-color: #0099ff; padding: 8px; border: 2px solid #0099ff; word-wrap: break-word;">
                    <i class="fas fa-chart-area"></i>&emsp; Biểu đồ đường thể hiện mức chi của từng tháng
                </div>
                <div id="chart-container">
                    <canvas id="graphCanvasPoint02"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- END 2 biểu đồ -->
</div>
<script type="text/javascript">
    $(document).ready(function() {
        showGraphPoint01();
        showGraphPoint02();
    });

    function showGraphPoint01() {
        {
            $.ajax({
                url: "{{action('revenuesController@getChart01')}}",
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {

                    // alert(data);
                    var name = [];
                    var dem1 = [];
                    var dem2 = [];
                    for (var i in data) {
                        name.push(data[i].month);
                        dem1.push(data[i].intoMoneys)*dem2.push(data[i].intoMoney);
                    }
                    console.log(name);
                    console.log(dem1);
                    
                    var chartdata = {
                        labels: name,
                        datasets: [{
                            label: 'Money',
                            backgroundColor: '#99ff99',
                            borderColor: '#00ff00',
                            hoverBackgroundColor: '#660000',
                            hoverBorderColor: '#660000',
                            data: dem1
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
                url: "{{action('revenuesController@getChart02')}}",
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {

                    // alert(data);
                    var name = [];
                    var dem1 = [];
                    for (var i in data) {
                        //alert(data[i].names);
                        //console.log(data[i].countClass);
                        name.push(data[i].month);
                        dem1.push(data[i].intoMoneys);
                    }
                    var chartdata = {
                        labels: name,
                        datasets: [{
                            label: 'Number class ',
                            backgroundColor: '#ff9999',
                            borderColor: '#ff0000',
                            hoverBackgroundColor: '#660000',
                            hoverBorderColor: '#660000',
                            data: dem1
                        }]
                    };

                    var graphTarget = $("#graphCanvasPoint02");
                    var barGraph = new Chart(graphTarget, {
                        type: 'line', //bar,pie,line,radar...
                        data: chartdata
                    });
                }
            });
        }
    }
</script>
@endsection
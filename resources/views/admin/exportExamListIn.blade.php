<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('js/jquery-3.3.1.js')}}"></script>

    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/animate.css')}}">

    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/6631cf4e8b.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/sidebar1.css')}}">
    <link rel="stylesheet" href="{{asset('css/button.css')}}">
    <script type="text/javascript" src="{{asset('js/sidebar.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/Chart.min.js')}}"></script>
   
    <script type="text/javascript" src="{{asset('js/sweetalert2.all.min.js')}}"></script>

    <script src="https://uicdn.toast.com/tui.code-snippet/latest/tui-code-snippet.js"></script>
    <script src="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.js"></script>
    <link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.css" />

    <!-- If you use the default popups, use this. -->
    <link rel="stylesheet" href="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.css" />
    <link rel="stylesheet" href="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.css" />

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/handsontable@latest/dist/handsontable.full.min.css">
    <script src="https://cdn.jsdelivr.net/npm/handsontable@latest/dist/handsontable.full.min.js"></script>
    <script src="{{asset('js/jquery-3.3.1.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">

    <title>Taekwondo TT</title>
    <script type="text/javascript">
        $(document).ready(function(e) {
            exportListIn();
        });

        function exportListIn() {
            var examID= $("#id").val();
            $.ajax({
                url: '{{action("examController@getexportExamListIn")}}',
                type: 'GET',
                data:{examID:examID},
                dataType:'JSON',
                success: function(data) {
                    var container = document.getElementById('example');
                    var hot = new Handsontable(container, {
                        data: data,
                        autoWrapRow: true,
                        rowHeaders: true,
                        colHeaders: true,
                        filters: true,
                        dropdownMenu: true,
                        manualRowMove: true,
                        manualColumnMove: true,
                        contextMenu: true,
                        maxRows: 100,
                        colHeaders: [
                            'Martial artist ID',
                            'Martial artist\'s name',
                            'Date of birth',
                            'Club\'s name',
                            'Class\'s name',
                            'Coach\'s name',
                            'Level'
                        ],
                        columns: [{
                                data: 'maID',
                                readOnly: true
                            },
                            {
                                data: 'maName'
                            },
                            {
                                data: 'maDOB',
                                dateFormat: 'MM/DD/YYYY'
                            },
                            {
                                data: 'clubName'
                            },
                            {
                                data: 'className',
                            },
                            {
                                data: 'coachName',
                            },
                            {
                                data: 'malevel',
                            }
                        ]

                    });
                    var exportFiles = document.getElementById('export');
                    var exportPlugin1 = hot.getPlugin('exportFile');

                    exportFiles.addEventListener('click', function() {
                        exportPlugin1.downloadFile('csv', {
                            bom: true,
                            columnDelimiter: ',',
                            columnHeaders: true,
                            exportHiddenColumns: true,
                            exportHiddenRows: true,
                            fileExtension: 'csv',
                            filename: 'DanhSachVSKhongThi',
                            mimeType: 'text/csv',
                            rowDelimiter: '\r\n',
                            rowHeaders: true
                        });
                    });
                }
            })
        }
    </script>
</head>

<body>
    <input type="hidden" id="id" value="{{$examID}}">
    <button type="button" class="btn btn-success mt-2 ml-3" onclick="location.href='/projectTruc/public/exam_listin/{{$examID}}'"><i class="fas fa-arrow-left"></i></button>
    <button type="button" class="btn btn-success mt-2 ml-3" onclick="location.href='/projectTruc/public/exam_listin/exportexamlistin/export/{{$examID}}'"><i class="fas fa-undo"></i></button>
    <button type="button" id="export" class="btn btn-success mt-2 ml-3"><i class="fas fa-cloud-download-alt"></i></button>
    <div id="example" class="mt-2 ml-3"></div>

</body>

</html>
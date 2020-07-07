<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/handsontable@latest/dist/handsontable.full.min.css">
    <link rel="stylesheet" type="text/css" href="https://handsontable.com/static/css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/handsontable@latest/dist/handsontable.full.min.js"></script>
    <script src="{{asset('js/jquery-3.3.1.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">

    <title>Taekwondo TT</title>
    <script type="text/javascript">
        $(document).ready(function(e) {
            exportRevListIn();
        });

        function exportRevListIn() {
            var idclub= $("#idclub").val();
            var idrev= $("#idrev").val();
            $.ajax({
                url: '{{action("revenuesController@getexportRevListIn")}}',
                type: 'GET',
                data:{
                    idrev:idrev,
                    idclub:idclub
                },
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
                            'Class\'s name'
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
                            },
                            {
                                data: 'className'
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
                            filename: 'report-CSV-file_[YYYY]-[MM]-[DD]',
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
    <input type="hidden" id="idrev" value="{{$idrev}}">
    <input type="hidden" id="idclub" value="{{$idclub}}">
    <button type="button" id="export" class="btn btn-warning mt-2 ml-3">export file</button>
    <div id="example" class="mt-2 ml-3"></div>

</body>

</html>
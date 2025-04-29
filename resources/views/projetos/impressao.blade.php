<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    {{-- <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('material/assets/images/logo-h.png') }}"> --}}
    <title>CRM - admin </title>
    <!-- Bootstrap Core CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('material/assets/plugins/jqueryui/jquery-ui.theme.min.css?1.1.1') }}"> --}}
    <link href="{{ asset('vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <style>
        .print-table {
            page-break-after: avoid;
            margin: 100px 0 0 40px;
        }

        .btn-print {
            position: absolute;
            left: 40px;
            top: 20px;
        }

        #footer {
            position: fixed;
            bottom: 0px;
            width: 100%;
        }

        table {
            width: 100%;
        }

        #reset-footer * {
            color: rgba(0, 0, 0, 0) !important;
        }

        #reset-footer img {
            display: none !important;
        }

        #reset-footer hr {
            border-top: 1px solid rgba(0, 0, 0, 0) !important;
        }

        #reset-footer hr {
            border-top: 1px solid rgba(0, 0, 0, 0) !important;
        }

        .table-bordered td {
            border: 1px solid #000000 !important;
        }

        @media print {

            .btn-print {
                display: none;
            }

            .print-table {
                margin: 0 0 0 0 !important;
            }

            #footer {
                position: fixed;
                bottom: 0px;
                width: 100%;
            }

            .container {
                page-break-after: avoid;
            }

            body {
                page-break-after: avoid;
            }

            .group {
                page-break-after: avoid;
            }

            tbody {
                position: relative;
                min-height: 85%;
            }

            .table-bordered th,
            .table-bordered td {
                border: 1px solid #000 !important;
            }
        }

         /* Aplica bordas apenas às tabelas com a classe .linha */
        table.linha {
            width: 100%;
            border-collapse: collapse;
        }
        table.linha th, 
        table.linha td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>

</head>

<body>
    <div class="print-table">
        <table>
            <thead>
                <tr>
                    <td style="width: 100%; text-align: center;">
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        {!! $texto !!}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- </div> --}}

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            setTimeout(() => {
                window.print();
            }, 0);
        })

        function imprimir() {
            window.print();
        }
    </script>
</body>

</html>

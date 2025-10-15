<!DOCTYPE html>
<html lang="en">

    <head>
        <title>MZU Hostels</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            .header{
                color: blue;
                display: block;
                font-size: 18pt;
            }
            .header a{
                text-decoration: none;
            }
        </style>
    </head>

    <body class='bg-info'>
        <div style="background-image: url('{{ asset('images/mzu_logo.png') }}'); height: 200px; width: 400px;">
            Hello world
        </div>
        <div class="container">
            <div class="row justify-content-start">
                <div class="col">
                    <div class="border bg-primary my-3 py-3 px-2 shadow rounded">
                        <p class="text-center text-light">Welcome to</p>
                        <div class="header text-center text-light">
                            Office of the Dean, Students' Welfare, Mizoram University
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-start">
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="border bg-light my-3 py-3 px-2 shadow rounded">
                        <div class="header">
                            <a href="/application">Hostel application</a>
                        </div>
                        <p>Students who wants to have accommodation in the different halls of residence may apply for hostel.</p>
                        Click <a href="/application">here</a> to apply
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="border bg-light my-3 py-3 px-2 shadow rounded">
                        <div class="header">
                            <a href="/notiMaster">Important Notifications</a>
                        </div>
                        <p>
                            Important notifications are readily accessible from here.
                        </p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="border bg-light my-3 py-3 px-2 shadow rounded">
                        <div class="header">Scholarship</div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="border bg-light my-3 py-3 px-2 shadow rounded">
                        <div class="header">Anti-ragging undertaking</div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="border bg-light my-3 py-3 px-2 shadow rounded">
                        <div class="header">
                            SoPs
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="border bg-light my-3 py-3 px-2 shadow rounded">
                        <div class="header">
                            FAQs
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="border bg-light my-3 py-3 px-2 shadow rounded">
                        sdfsd fdsf sdf
                    </div>
                </div>
            </div>
        </div>

    </body>

</html>

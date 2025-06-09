<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Clearance form for leaving the hostel
                <p>
                    <a href="/allotment/{{ $clearance->allotment_id }}" class="btn btn-secondary btn-sm">Back to Student
                        info</a>
                </p>
            </x-slot>

            <div class="controls">
                {{-- <button onclick="window.print()" class="print-btn">Print Certificate</button>
                    <button onclick="window.print()" class="print-btn">Print Certificate</button>
                    <input type="button" value="Print Div" onclick="printDiv()">                    
                    --}}
                <button onclick="printDiv()" class="print-btn">Print Certificate</button>

            </div>

            <div class="certificate" id="certificate">
                <html lang="en">

                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Hostel No Dues Certificate - Print Preview</title>
                    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
                    <style>
                        * {
                            margin: 0;
                            padding: 0;
                            box-sizing: border-box;
                        }

                        body {
                            font-family: system-ui, -apple-system, sans-serif;
                            background: #f0f0f0;
                            padding: 2rem;
                            color: #333;
                        }

                        .form-container {
                            max-width: 800px;
                            margin: 0 auto 2rem;
                            background: white;
                            padding: 2rem;
                            border-radius: 8px;
                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                        }

                        .form-container h2 {
                            margin-bottom: 1.5rem;
                            color: #333;
                        }

                        .form {
                            display: grid;
                            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                            gap: 1rem;
                        }

                        .form-group {
                            margin-bottom: 1rem;
                        }

                        .form-group label {
                            display: block;
                            margin-bottom: 0.5rem;
                            color: #555;
                        }

                        .form-group input {
                            width: 100%;
                            padding: 0.5rem;
                            border: 1px solid #ddd;
                            border-radius: 4px;
                            font-size: 1rem;
                        }

                        .form-group input:focus {
                            outline: none;
                            border-color: #1a73e8;
                            box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.2);
                        }

                        .controls {
                            margin-bottom: 2rem;
                            max-width: 800px;
                            margin: 0 auto 2rem;
                        }

                        .print-btn {
                            padding: 0.75rem 1.5rem;
                            background: #1a73e8;
                            color: white;
                            border: none;
                            border-radius: 4px;
                            cursor: pointer;
                            font-size: 1rem;
                        }

                        .print-btn:hover {
                            background: #1557b0;
                        }

                        .certificate {
                            max-width: 800px;
                            margin: 0 auto;
                            background: #202020;
                            color: #e0e0e0;
                            padding: 3rem;
                            border-radius: 8px;
                            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                        }

                        .header {
                            text-align: center;
                            margin-bottom: 2rem;
                        }

                        .university-logo {
                            height: 64px;
                            width: auto;
                            margin: 0 1rem;
                            vertical-align: middle;
                        }

                        .header h1 {
                            font-size: 1.5rem;
                            margin-bottom: 0.5rem;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            gap: 1rem;
                        }

                        .header h2 {
                            font-size: 1.25rem;
                            margin-bottom: 0.5rem;
                        }

                        .header h3 {
                            font-size: 1rem;
                        }

                        hr {
                            border: none;
                            border-top: 1px solid #404040;
                            margin: 2rem 0;
                        }

                        .letter-info {
                            display: flex;
                            justify-content: space-between;
                            margin-bottom: 2rem;
                        }

                        .title {
                            text-align: center;
                            margin-bottom: 2rem;
                        }

                        .title h2 {
                            display: inline-block;
                            border-bottom: 1px solid #e0e0e0;
                            padding-bottom: 0.25rem;
                        }

                        .content {
                            margin-bottom: 2rem;
                            line-height: 1.6;
                        }

                        .particulars {
                            margin-bottom: 2rem;
                        }

                        .section-title {
                            font-weight: bold;
                            margin-bottom: 1rem;
                        }

                        .details {
                            margin-left: 2rem;
                        }

                        .details p {
                            margin-bottom: 0.5rem;
                        }

                        .label {
                            display: inline-block;
                            width: 200px;
                        }

                        .verification {
                            margin-bottom: 2rem;
                            line-height: 1.6;
                        }

                        .verification p:not(:last-child) {
                            margin-bottom: 1rem;
                        }

                        .signature {
                            text-align: right;
                            margin-top: 3rem;
                        }

                        .signature p:first-child {
                            margin-bottom: 0.25rem;
                        }

                        @media print {
                            body {
                                background: white;
                                padding: 0;
                            }

                            .form-container,
                            .controls {
                                display: none;
                            }

                            .certificate {
                                background: white;
                                color: black;
                                box-shadow: none;
                                border-radius: 0;
                                padding: 2rem;
                            }

                            hr {
                                border-top: 1px solid #000;
                            }

                            .title h2 {
                                border-bottom: 1px solid #000;
                            }

                            .details,
                            .content,
                            .verification,
                            .signature {
                                color: black;
                            }
                        }

                        * {
                            margin: 0;
                            padding: 0;
                            box-sizing: border-box;
                        }

                        body {
                            font-family: system-ui, -apple-system, sans-serif;
                            background: #f0f0f0;
                            padding: 2rem;
                            color: #333;
                        }

                        .form-container {
                            max-width: 800px;
                            margin: 0 auto 2rem;
                            background: white;
                            padding: 2rem;
                            border-radius: 8px;
                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                        }

                        .form-container h2 {
                            margin-bottom: 1.5rem;
                            color: #333;
                        }

                        .form {
                            display: grid;
                            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                            gap: 1rem;
                        }

                        .form-group {
                            margin-bottom: 1rem;
                        }

                        .form-group label {
                            display: block;
                            margin-bottom: 0.5rem;
                            color: #555;
                        }

                        .form-group input {
                            width: 100%;
                            padding: 0.5rem;
                            border: 1px solid #ddd;
                            border-radius: 4px;
                            font-size: 1rem;
                        }

                        .form-group input:focus {
                            outline: none;
                            border-color: #1a73e8;
                            box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.2);
                        }

                        .controls {
                            margin-bottom: 2rem;
                            max-width: 800px;
                            margin: 0 auto 2rem;
                        }

                        .print-btn {
                            padding: 0.75rem 1.5rem;
                            background: #1a73e8;
                            color: white;
                            border: none;
                            border-radius: 4px;
                            cursor: pointer;
                            font-size: 1rem;
                        }

                        .print-btn:hover {
                            background: #1557b0;
                        }

                        .certificate {
                            max-width: 800px;
                            margin: 0 auto;
                            background: #202020;
                            color: #e0e0e0;
                            padding: 3rem;
                            border-radius: 8px;
                            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                        }

                        .header {
                            text-align: center;
                            margin-bottom: 2rem;
                        }

                        .university-logo {
                            height: 64px;
                            width: auto;
                            margin: 0 1rem;
                            vertical-align: middle;
                        }

                        .header h1 {
                            font-size: 1.5rem;
                            margin-bottom: 0.5rem;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            gap: 1rem;
                        }

                        .header h2 {
                            font-size: 1.25rem;
                            margin-bottom: 0.5rem;
                        }

                        .header h3 {
                            font-size: 1rem;
                        }

                        hr {
                            border: none;
                            border-top: 1px solid #404040;
                            margin: 2rem 0;
                        }

                        .letter-info {
                            display: flex;
                            justify-content: space-between;
                            margin-bottom: 2rem;
                        }

                        .title {
                            text-align: center;
                            margin-bottom: 2rem;
                        }

                        .title h2 {
                            display: inline-block;
                            border-bottom: 1px solid #e0e0e0;
                            padding-bottom: 0.25rem;
                        }

                        .content {
                            margin-bottom: 2rem;
                            line-height: 1.6;
                        }

                        .particulars {
                            margin-bottom: 2rem;
                        }

                        .section-title {
                            font-weight: bold;
                            margin-bottom: 1rem;
                        }

                        .details {
                            margin-left: 2rem;
                        }

                        .details p {
                            margin-bottom: 0.5rem;
                        }

                        .label {
                            display: inline-block;
                            width: 200px;
                        }

                        .verification {
                            margin-bottom: 2rem;
                            line-height: 1.6;
                        }

                        .verification p:not(:last-child) {
                            margin-bottom: 1rem;
                        }

                        .signature {
                            text-align: right;
                            margin-top: 3rem;
                        }

                        .signature p:first-child {
                            margin-bottom: 0.25rem;
                        }

                        @media print {
                            body {
                                background: white;
                                padding: 0;
                            }

                            .form-container,
                            .controls {
                                display: none;
                            }

                            .certificate {
                                background: white;
                                color: black;
                                box-shadow: none;
                                border-radius: 0;
                                padding: 2rem;
                            }

                            hr {
                                border-top: 1px solid #000;
                            }

                            .title h2 {
                                border-bottom: 1px solid #000;
                            }

                            .details,
                            .content,
                            .verification,
                            .signature {
                                color: black;
                            }
                        }
                    </style>
                </head>

                <body>
                    <div class="header">
                        <h1>
                            MIZORAM UNIVERSITY
                        </h1>
                        <h2>{{ strtoupper($clearance->hostel) }} HALL OF RESIDENCE</h2>
                        <h3>AIZAWL - 796004, MIZORAM</h3>
                    </div>

                    <hr>

                    <div class="letter-info">
                        <p>Letter No. <span
                                id="letterNo">Clearance/{{ $clearance->allotment_id }}/{{ $clearance->id }}</span>
                        </p>
                        <p>Aizawl, <span
                                id="date">{{ date_format(date_create($clearance->issue_dt), 'jS M Y') }}</span>
                        </p>
                    </div>

                    <div class="title">
                        <h2>Hostel Clearance Certificate</h2>
                    </div>

                    <div class="content">
                        <p>
                            This is to certify that <span id="name">{{ $clearance->name }}</span>,
                            studying <span id="position">{{ $clearance->course }}</span> in the Department
                            of <span id="department">{{ $clearance->department }}</span>, bearing roll number
                            {{ $clearance->rollno }} Mizoram University, has successfully cleared all his dues
                            with the
                            {{ ucfirst($clearance->hostel) }} Hall of Residence as per the clearance given by the
                            prefect.
                        </p>
                    </div>

                    <div class="particulars">
                        <p class="section-title">Particulars:</p>
                        <div class="details">
                            <p><span class="label">Name:</span> <span id="nameDetail">{{ $clearance->name }}</span>
                            </p>
                            <p><span class="label">Course:</span> <span id="course">{{ $clearance->course }}</span>
                            </p>
                            <p><span class="label">Department:</span> <span
                                    id="departmentDetail">{{ $clearance->department }}</span></p>
                            <p><span class="label">Hostel Room:</span> <span
                                    id="room">{{ $clearance->roomno }}</span></p>
                            <p><span class="label">Date of Departure/No Dues:</span> <span
                                    id="departure">{{ $clearance->leave_dt }}</span></p>
                            <p><span class="label">Dues Status:</span> <span id="status">Clear</span></p>
                        </div>
                    </div>

                    <div class="verification">
                        <p>
                            After due verification, it is confirmed that <span
                                id="nameVerification">{{ $clearance->name }}</span> has no
                            outstanding dues with the hostel, and his clearance process is complete, subject to
                            the mess dues occur till his shifting to the new hostel he will be pay as per the hostel
                            rules.
                        </p>
                        <p>
                            This certificate is being issued for the purpose of formal clearance from the
                            hostel.
                        </p>
                    </div>

                    <div class="signature">
                        <p>(<span id="warden">{{ $clearance->warden }}</span>)</p>
                        <p>Warden</p>
                    </div>

            </div>








            <script>
                function printDiv() {
                    // alert("asdasd");
                    let divContents = document.getElementById("certificate").innerHTML;
                    let printWindow = window.open('', '', 'height=1000, width=1000');
                    printWindow.document.write(divContents);
                    printWindow.document.close();
                    printWindow.print();
                }
            </script>



            </body>

            </html>

        </x-block>
    </x-container>
</x-layout>

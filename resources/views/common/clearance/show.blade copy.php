<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel No Dues Certificate - Print Preview</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="form-container">
        <h2>Certificate Details</h2>
        <form id="certificateForm" class="form">
            <div class="form-group">
                <label for="letterNo">Letter No.</label>
                <input type="text" id="letterNoInput" name="letterNo" value="File-Dues/2025/02">
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="text" id="dateInput" name="date" value="{{ $clearance->issue_dt }}">
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="nameInput" name="name" value="{{ $clearance->name }}">
            </div>

            <div class="form-group">
                <label for="department">Department</label>
                <input type="text" id="departmentInput" name="department" value="{{ $clearance->department }}">
            </div>
            <div class="form-group">
                <label for="course">Course</label>
                <input type="text" id="courseInput" name="course" value="{{ $clearance->course }}">
            </div>
            <div class="form-group">
                <label for="room">Room</label>
                <input type="text" id="roomInput" name="room" value="{{ $clearance->roomno }}">
            </div>

            <div class="form-group">
                <label for="departure">Departure Date</label>
                <input type="text" id="departureInput" name="departure" value="{{ $clearance->leave_dt }}">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <input type="text" id="statusInput" name="status"
                    value="{{ $clearance->clear ? 'Cleared' : 'Not Cleared' }}">
            </div>
            <div class="form-group">
                <label for="warden">Warden Name</label>
                <input type="text" id="wardenInput" name="warden" value="{{ $clearance->warden }}">
            </div>
        </form>
    </div>

    <div class="controls">
        <button onclick="window.print()" class="print-btn">Print Certificate</button>
    </div>

    <div class="certificate">
        <div class="header">
            <h1>
                MIZORAM UNIVERSITY
            </h1>
            <h2>{{ strtoupper($clearance->hostel) }} HALL OF RESIDENCE</h2>
            <h3>AIZAWL - 796004, MIZORAM</h3>
        </div>

        <hr>

        <div class="letter-info">
            <p>Letter No. <span id="letterNo">Clearance/{{ $clearance->allotment_id }}/{{ $clearance->id }}</span>
            </p>
            <p>Aizawl, <span id="date">{{ date_format(date_create($clearance->issue_dt), 'jS M Y') }}</span></p>
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
                {{ ucfirst($clearance->hostel) }} Hall of Residence as per the clearance given by the prefect.
            </p>
        </div>

        <div class="particulars">
            <p class="section-title">Particulars:</p>
            <div class="details">
                <p><span class="label">Name:</span> <span id="nameDetail">{{ $clearance->name }}</span></p>
                <p><span class="label">Course:</span> <span id="course">{{ $clearance->course }}</span></p>
                <p><span class="label">Department:</span> <span
                        id="departmentDetail">{{ $clearance->department }}</span></p>
                <p><span class="label">Hostel Room:</span> <span id="room">{{ $clearance->roomno }}</span></p>
                <p><span class="label">Date of Departure/No Dues:</span> <span
                        id="departure">{{ $clearance->leave_dt }}</span></p>
                <p><span class="label">Dues Status:</span> <span id="status">Clear</span></p>
            </div>
        </div>

        <div class="verification">
            <p>
                After due verification, it is confirmed that <span id="nameVerification">Denyoung Umbon</span> has no
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
        // Function to update certificate data
        function updateCertificate(data) {
            const fields = {
                letterNo: data.letterNo,
                date: data.date,
                name: data.name,
                position: data.position,
                department: data.department,
                nameDetail: data.name,
                course: data.course,
                departmentDetail: data.department,
                room: data.room,
                duration: data.duration,
                departure: data.departure,
                status: data.status,
                nameVerification: data.name,
                warden: data.warden
            };

            for (const [id, value] of Object.entries(fields)) {
                const element = document.getElementById(id);
                if (element && value) {
                    element.textContent = value;
                }
            }
        }

        // Add input event listeners to all form inputs
        document.querySelectorAll('#certificateForm input').forEach(input => {
            input.addEventListener('input', () => {
                const formData = {
                    letterNo: document.getElementById('letterNoInput').value,
                    date: document.getElementById('dateInput').value,
                    name: document.getElementById('nameInput').value,
                    position: document.getElementById('positionInput').value,
                    department: document.getElementById('departmentInput').value,
                    course: document.getElementById('courseInput').value,
                    room: document.getElementById('roomInput').value,
                    duration: document.getElementById('durationInput').value,
                    departure: document.getElementById('departureInput').value,
                    status: document.getElementById('statusInput').value,
                    warden: document.getElementById('wardenInput').value
                };

                updateCertificate(formData);
            });
        }); // Function to update certificate data
        function updateCertificate(data) {
            const fields = {
                letterNo: data.letterNo,
                date: data.date,
                name: data.name,
                position: data.position,
                department: data.department,
                nameDetail: data.name,
                course: data.course,
                departmentDetail: data.department,
                room: data.room,
                duration: data.duration,
                departure: data.departure,
                status: data.status,
                nameVerification: data.name,
                warden: data.warden
            };

            for (const [id, value] of Object.entries(fields)) {
                const element = document.getElementById(id);
                if (element && value) {
                    element.textContent = value;
                }
            }
        }

        // Add input event listeners to all form inputs
        document.querySelectorAll('#certificateForm input').forEach(input => {
            input.addEventListener('input', () => {
                const formData = {
                    letterNo: document.getElementById('letterNoInput').value,
                    date: document.getElementById('dateInput').value,
                    name: document.getElementById('nameInput').value,
                    position: document.getElementById('positionInput').value,
                    department: document.getElementById('departmentInput').value,
                    course: document.getElementById('courseInput').value,
                    room: document.getElementById('roomInput').value,
                    duration: document.getElementById('durationInput').value,
                    departure: document.getElementById('departureInput').value,
                    status: document.getElementById('statusInput').value,
                    warden: document.getElementById('wardenInput').value
                };

                updateCertificate(formData);
            });
        });
    </script>
</body>

</html>

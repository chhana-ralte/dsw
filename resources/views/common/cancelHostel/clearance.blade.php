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
        <input type="text" id="dateInput" name="date" value="March 19, 2025">
      </div>
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="nameInput" name="name" value="Denyoung Umbon">
      </div>
      <div class="form-group">
        <label for="position">Position</label>
        <input type="text" id="positionInput" name="position" value="Research Scholar">
      </div>
      <div class="form-group">
        <label for="department">Department</label>
        <input type="text" id="departmentInput" name="department" value="Biotechnology">
      </div>
      <div class="form-group">
        <label for="course">Course</label>
        <input type="text" id="courseInput" name="course" value="Research Scholar">
      </div>
      <div class="form-group">
        <label for="room">Room</label>
        <input type="text" id="roomInput" name="room" value="FFD/17/2">
      </div>
      <div class="form-group">
        <label for="duration">Duration</label>
        <input type="text" id="durationInput" name="duration" value="Nov. 2024-May 2025">
      </div>
      <div class="form-group">
        <label for="departure">Departure Date</label>
        <input type="text" id="departureInput" name="departure" value="16/05/2025">
      </div>
      <div class="form-group">
        <label for="status">Status</label>
        <input type="text" id="statusInput" name="status" value="Clear">
      </div>
      <div class="form-group">
        <label for="warden">Warden Name</label>
        <input type="text" id="wardenInput" name="warden" value="DR. KRISHNA KANT TRIPATHI">
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
      <h2>THORANG HALL OF RESIDENCE</h2>
      <h3>AIZAWL - 796004, MIZORAM</h3>
    </div>

    <hr>

    <div class="letter-info">
      <p>Letter No. <span id="letterNo">File-Dues/2025/02</span></p>
      <p>Aizawl, <span id="date">March 19, 2025</span></p>
    </div>

    <div class="title">
      <h2>Hostel No Dues Certificate</h2>
    </div>

    <div class="content">
      <p>
        This is to certify that <span id="name">Denyoung Umbon</span>,
        a <span id="position">Research Scholar</span> in the Department
        of <span id="department">Biotechnology</span>, Mizoram University, has successfully cleared all his dues with the
        Thorang Hall of Residence as per the clearance given by the prefect.
      </p>
    </div>

    <div class="particulars">
      <p class="section-title">Particulars:</p>
      <div class="details">
        <p><span class="label">Name:</span> <span id="nameDetail">Denyoung Umbon</span></p>
        <p><span class="label">Course:</span> <span id="course">Research Scholar</span></p>
        <p><span class="label">Department:</span> <span id="departmentDetail">Biotechnology</span></p>
        <p><span class="label">Hostel Room:</span> <span id="room">FFD/17/2</span></p>
        <p><span class="label">Duration of Stay/ Allotment:</span> From: <span id="duration">Nov. 2024-May 2025</span></p>
        <p><span class="label">Date of Departure/No Dues:</span> <span id="departure">16/05/2025</span></p>
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
      <p>(<span id="warden">DR. KRISHNA KANT TRIPATHI</span>)</p>
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
  });// Function to update certificate data
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

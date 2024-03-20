<?php
include ('../admin/admin_header.php');
include ('../dbconn.php');

// Check if user is not logged in
if (!isset ($_SESSION['user_id']) || !isset ($_SESSION['user_role'])) {
    // Redirect users who are not logged in to the login page
    header("Location: ../login.php");
    exit();
}

// Check if user is not admin
if ($_SESSION['user_role'] !== 'admin') {
    // Redirect non-admin users to index.php
    header("Location: ../index.php");
    exit();
}

//For displaying interview schedules
$query = "
    SELECT job_applicants.*, jobs.job_name, jobs.job_type, jobs.shift_and_schedule, jobs.location, user.first_name, user.last_name, user.resume
    FROM ((job_applicants
    INNER JOIN jobs ON job_applicants.job_id = jobs.id)
    INNER JOIN user ON job_applicants.user_id = user.id)
    ORDER BY job_applicants.interview_date ASC
";
$result = mysqli_query($conn, $query);
$events = [];

while ($row = mysqli_fetch_assoc($result)) {
    if (!empty ($row['interview_date'])) {
        $datetime = new DateTime($row['interview_date']);
        $formattedDate = $datetime->format('Y-m-d');
        $formatTime = $datetime->format('H:i:s');

        $user_name = $row['first_name'] . ' ' . $row['last_name'];
        $position = $row['job_name'];

        $time = $datetime->format('h:m A');
        $title = 'Interview with ' . $user_name . ' for ' . $position . ' position at ' . $time;

        // Create start and end times using ISO 8601 format
        $startDateTime = $formattedDate . 'T' . $formatTime;
        // Assuming the interview lasts for 1 hour
        $endDateTime = $datetime->modify('+1 hour')->format('Y-m-d\TH:i:s');

        $events[] = [
            'title' => $title,
            'start' => $startDateTime,
            'end' => $endDateTime,
        ];
    }
}

$events_json = json_encode($events);
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Calendar</title>

    <style>
        .fc-daygrid-day:hover {
            cursor: pointer;
            background-color: #f0f0f0;
        }

        .fc-event {
            cursor: default;
        }

        .fc-main-container {
            background-color: #f8d7da;
            /* Change background color */
        }
    </style>

</head>

<body style="background-color: #F4F4F4; ">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 col-lg-3 col-xl-2 bg-white  p-0 m-0 d-lg-block shadow" style="min-height: 91vh;">
                <?php include ("../admin/admin_sidebar.php"); ?>
            </div>
            <div class="col-md-10 col-lg-9 col-xl-10  mt-3">
                <h4 class=" mt-1 mb-5 ">Interview Schedules</h4>
                <div class="container bg-white">

                    <div id="calendar" class=""></div>
                </div>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-danger">
                                    Scheduled Interviews
                                </h5>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div id="interviewList">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Displaying Interviews of the day when clicked -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: <?php echo $events_json; ?>,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                dateClick: function (info) {
                    var clickedDate = info.dateStr;
                    var events = calendar.getEvents();
                    var interviews = events.filter(event => event.startStr.includes(clickedDate));
                    var interviewList = document.getElementById('interviewList');
                    interviewList.innerHTML = '';

                    if (interviews.length > 0) {
                        interviews.forEach(function (interview, index) {
                            var div = document.createElement('div');
                            div.classList.add('p-3', 'mb-2', 'bg-danger', 'text-white', 'border', 'border-secondary', 'rounded', 'me-2', 'mb-2');

                            var statement = document.createElement('span');
                            statement.textContent = interview.title;
                            div.appendChild(statement);
                            interviewList.appendChild(div);

                            // Add a divider if it's not the last interview
                            if (index < interviews.length - 1) {
                                interviewList.appendChild(document.createElement('hr'));
                            }
                        });
                    } else {
                        interviewList.textContent = 'No interviews scheduled for this day/time.';
                    }

                    $('#myModal').modal('show');
                }
            });
            calendar.render();
        });
    </script>


</body>

</html>

<?php include ('../footer.php'); ?>
<?php
include ('../admin/home_process.php');

// Check if user is not logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
    // Redirect users who are not logged in to the login page
    header("Location: ../login.php");
    exit();
}

// Check if user is not admin
if ($_SESSION['user_role'] == 'user') {
    // Redirect non-admin users to index.php
    header("Location: ../index.php");
    exit();
}

//Puts here to prevent ERROR: Cannot modify header information - headers already sent by..
include ('../admin/admin_header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

</head>

<body style="background-color: #F4F4F4; ">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 col-lg-3 col-xl-2 bg-white  p-0 m-0 d-lg-block shadow " style="min-height: 91vh;">
                <?php include ("../admin/admin_sidebar.php"); ?>
            </div>
            <div class="col-md-10 col-lg-9 col-xl-10  mt-3">
                <h4 class=" mt-1 mb-5 ">Dashboard</h4>

                <div class="container ">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card bg-success bg-opacity-50 border border-2  border-success shadow">
                                <div class="card-body">

                                    <div class="container">
                                        <div class="d-flex fw-bold justify-content-between align-items-center">
                                            <div>
                                                Registered Users
                                            </div>
                                            <div>
                                                <i class="bi bi-people h3"></i>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <h2>
                                                    <?php echo '+' . $countReg; ?>
                                                </h2>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card bg-warning  bg-opacity-50 border border-2  border-warning shadow">
                                <div class="card-body">

                                    <div class="container">
                                        <div class="d-flex fw-bold justify-content-between align-items-center">
                                            <div>
                                                Total Applicants
                                            </div>
                                            <div>
                                                <i class="bi bi-file-earmark-person h3"></i>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <h2>
                                                    <?php echo '+' . $countApp; ?>
                                                </h2>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card bg-primary  bg-opacity-50 border border-2  border-primary shadow">
                                <div class="card-body">

                                    <div class="container">
                                        <div class="d-flex fw-bold justify-content-between align-items-center">
                                            <div>
                                                Registered Users
                                            </div>
                                            <div>
                                                <i class="bi bi-people h3"></i>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <h2>+293</h2>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card bg-danger  bg-opacity-50 border border-2  border-danger shadow">
                                <div class="card-body">

                                    <div class="container">
                                        <div class="d-flex fw-bold justify-content-between align-items-center">
                                            <div>
                                                Registered Users
                                            </div>
                                            <div>
                                                <i class="bi bi-people h3"></i>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <h2>+293</h2>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-8 mb-3">
                            <div class="card">
                                <div class="card-body" id="chart">
                                    <!-- CHART HERE -->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">

                                    <div class="container">
                                        <div class="d-flex fw-bold justify-content-between align-items-center">
                                            <div class="mb-2">
                                                Today Interviews
                                            </div>
                                        </div>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $interviewDateTime = $row['interview_date'];
                                                $interviewDateTimeObj = new DateTime($interviewDateTime);
                                                $interviewTime = $interviewDateTimeObj->format('h:i A');
                                                ?>
                                                <div class="row-12">
                                                    <div class="col mb-2">
                                                        <div
                                                            class="card bg-danger  bg-opacity-50 border border-2  border-danger">
                                                            <div class="card-body">

                                                                <div class="container">
                                                                    <div class="d-flex fw-bold justify-content-between align-items-center"
                                                                        style="height: 1px;">
                                                                        <div>
                                                                            <?php echo $row['first_name'] . ' ' . $row['last_name']; ?>
                                                                        </div>
                                                                        <div>
                                                                            <small>
                                                                                <?php echo $interviewTime; ?>
                                                                            </small>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                            }
                                        } else {
                                            ?>
                                                <div class="row">
                                                    <div class="col text-secondary">
                                                        No interviews scheduled today.
                                                    </div>
                                                </div>
                                                <?php
                                        }
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var dates = [
                [1587640800000, 30], // Sample data: [timestamp, value]
                [1587727200000, 40],
                [1587813600000, 35],
                // Add more data points as needed
            ];

            var options = {
                series: [{
                    name: 'XYZ MOTORS',
                    data: dates,
                    color: '#dc3545'
                }],
                chart: {
                    type: 'area',
                    stacked: false,
                    height: 350,
                    zoom: {
                        type: 'x',
                        enabled: true,
                        autoScaleYaxis: true
                    },
                    toolbar: {
                        autoSelected: 'zoom'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                markers: {
                    size: 0,
                },
                title: {
                    text: 'Chart Here',
                    align: 'left'
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        inverseColors: false,
                        opacityFrom: 0.5,
                        opacityTo: 0.4,
                        stops: [0, 90, 100]
                    },
                    colors: ['#dc3545']
                },
                stroke: {
                    curve: 'smooth',
                    width: 2, // Line width
                    colors: ['#dc3545'] // Line color
                },
                yaxis: {
                    labels: {
                        formatter: function (val) {
                            return (val / 1000000).toFixed(0);
                        },
                    },
                    title: {
                        text: 'Price'
                    },
                },
                xaxis: {
                    type: 'datetime',
                },
                tooltip: {
                    shared: false,
                    y: {
                        formatter: function (val) {
                            return (val / 1000000).toFixed(0)
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();

        </script>
</body>

</html>

<?php include ('../footer.php'); ?>
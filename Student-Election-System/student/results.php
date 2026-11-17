<?php

session_start();

include "../includes/db.php";


// ==========================================
// CHECK STUDENT LOGIN
// ==========================================

if (!isset($_SESSION['student_db_id'])) {

    header("Location: login.php");
    exit();

}


// ==========================================
// LIVE RESULTS API
// ==========================================

if (isset($_GET['live_results'])) {

    header('Content-Type: application/json');

    $data = [];

    // ======================================
    // GET CANDIDATES + REAL VOTE COUNTS
    // ======================================

    $sql = "
        SELECT
            c.id,
            c.name,
            c.position,
            COUNT(v.id) AS total_votes
        FROM candidates c
        LEFT JOIN votes v
            ON c.id = v.candidate_id
        GROUP BY
            c.id,
            c.name,
            c.position
        ORDER BY
            c.position,
            total_votes DESC
    ";

    $result = $conn->query($sql);


    if ($result) {

        while ($row = $result->fetch_assoc()) {

            $data[] = [

                "id" => (int)$row["id"],

                "name" => $row["name"],

                "position" => $row["position"],

                "votes" => (int)$row["total_votes"]

            ];

        }

    }


    // ======================================
    // TOTAL STUDENTS
    // ======================================

    $studentQuery = "
        SELECT COUNT(*) AS total_students
        FROM students
    ";

    $studentResult = $conn->query($studentQuery);

    $studentRow = $studentResult->fetch_assoc();

    $totalStudents = (int)$studentRow["total_students"];


    // ======================================
    // TOTAL VOTES
    // ======================================

    $voteQuery = "
        SELECT COUNT(*) AS total_votes
        FROM votes
    ";

    $voteResult = $conn->query($voteQuery);

    $voteRow = $voteResult->fetch_assoc();

    $totalVotes = (int)$voteRow["total_votes"];


    // ======================================
    // STUDENTS WHO HAVE VOTED
    // ======================================

    $votedQuery = "
        SELECT COUNT(DISTINCT student_id) AS voted_students
        FROM votes
    ";

    $votedResult = $conn->query($votedQuery);

    $votedRow = $votedResult->fetch_assoc();

    $votedStudents = (int)$votedRow["voted_students"];


    // ======================================
    // VOTING PERCENTAGE
    // ======================================

    $votingPercentage = 0;

    if ($totalStudents > 0) {

        $votingPercentage = round(
            ($votedStudents / $totalStudents) * 100
        );

    }


    // ======================================
    // RETURN JSON
    // ======================================

    echo json_encode([

        "candidates" => $data,

        "total_students" => $totalStudents,

        "total_votes" => $totalVotes,

        "voted_students" => $votedStudents,

        "voting_percentage" => $votingPercentage,

        "status" => "ACTIVE"

    ]);

    exit();

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Election Results</title>


<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">


<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


<style>

body{
    background:#f4f6f9;
    font-family:Arial, Helvetica, sans-serif;
}

.sidebar{
    width:250px;
    height:100vh;
    position:fixed;
    background:#0F4C81;
    color:white;
}

.sidebar h3{
    text-align:center;
    padding:20px;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:15px 25px;
}

.sidebar a:hover{
    background:#145b94;
}

.main{
    margin-left:250px;
    padding:30px;
}

.card{
    border:none;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
}

.progress{
    height:25px;
}

.result-name{
    font-size:18px;
}

.vote-count{
    font-weight:bold;
}

.position-title{
    margin-top:25px;
    margin-bottom:15px;
    color:#0F4C81;
}

.last-update{
    font-size:13px;
    color:#777;
}

</style>

</head>


<body>


<!-- SIDEBAR -->

<div class="sidebar">

    <h3>FAC Election</h3>


    <a href="dashboard.php">

        <i class="fa-solid fa-house"></i>
        Dashboard

    </a>


    <a href="candidates.php">

        <i class="fa-solid fa-users"></i>
        Candidates

    </a>


    <a href="vote.php">

        <i class="fa-solid fa-check"></i>
        Vote

    </a>


    <a href="results.php">

        <i class="fa-solid fa-chart-column"></i>
        Results

    </a>


    <a href="profile.php">

        <i class="fa-solid fa-user"></i>
        Profile

    </a>


    <a href="../logout.php"
       onclick="return confirm('Are you sure you want to logout?');">

        <i class="fa-solid fa-right-from-bracket"></i>
        Logout

    </a>

</div>


<!-- MAIN -->

<div class="main">


    <div class="card p-4">

        <h2>

            <i class="fa-solid fa-chart-column"></i>

            Election Results

        </h2>


        <hr>


        <div id="resultsContainer">

            <div class="text-center p-4">

                <div class="spinner-border text-primary"></div>

                <p class="mt-2">
                    Loading election results...
                </p>

            </div>

        </div>


        <div class="text-center mt-3">

            <span class="last-update">

                <i class="fa-solid fa-rotate"></i>

                Results automatically update every 3 seconds

            </span>

        </div>

    </div>


    <br>


    <!-- STATISTICS -->

    <div class="row">


        <div class="col-md-4">

            <div class="card text-center p-4">

                <h3 id="totalStudents">
                    0
                </h3>

                <p>
                    Total Students
                </p>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card text-center p-4">

                <h3 id="totalVotes">
                    0
                </h3>

                <p>
                    Total Votes
                </p>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card text-center p-4">

                <h3 id="votingPercentage">
                    0%
                </h3>

                <p>
                    Voting Percentage
                </p>

            </div>

        </div>


    </div>


    <br>


    <!-- STATUS -->

    <div class="card p-4">

        <h4>
            Election Status
        </h4>

        <hr>


        <div class="alert alert-success">

            <i class="fa-solid fa-circle-check"></i>

            Voting is currently ACTIVE.

        </div>


        <p>

            The final results will be published after the election closes.

        </p>

    </div>


</div>


<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


<script>

// ==========================================
// LOAD RESULTS
// ==========================================

function loadResults() {


    fetch("results.php?live_results=1")


    .then(response => response.json())


    .then(data => {


        // ==================================
        // STATISTICS
        // ==================================

        document.getElementById("totalStudents")
            .textContent = data.total_students;


        document.getElementById("totalVotes")
            .textContent = data.total_votes;


        document.getElementById("votingPercentage")
            .textContent =
            data.voting_percentage + "%";


        // ==================================
        // RESULTS CONTAINER
        // ==================================

        const container =
            document.getElementById(
                "resultsContainer"
            );


        container.innerHTML = "";


        // ==================================
        // GROUP BY POSITION
        // ==================================

        const positions = {};


        data.candidates.forEach(candidate => {


            if (!positions[candidate.position]) {

                positions[candidate.position] = [];

            }


            positions[candidate.position]
                .push(candidate);

        });


        // ==================================
        // DISPLAY POSITIONS
        // ==================================

        Object.keys(positions).forEach(position => {


            const candidates =
                positions[position];


            // Position title

            const title =
                document.createElement("h5");


            title.className =
                "position-title";


            title.textContent =
                position;


            container.appendChild(title);


            // ==================================
            // DISPLAY CANDIDATES
            // ==================================

            candidates.forEach(
                (candidate, index) => {


                // ==================================
                // VOTE BASED PERCENTAGE
                // 1 vote = 1%
                // 2 votes = 2%
                // ...
                // 100 votes = 100%
                // ==================================

                let percentage =
                    Math.min(candidate.votes, 100);


                const colors = [

                    "bg-success",

                    "bg-primary",

                    "bg-warning",

                    "bg-danger",

                    "bg-info",

                    "bg-secondary"

                ];


                const color =
                    colors[index % colors.length];


                const resultDiv =
                    document.createElement("div");


                resultDiv.className =
                    "mb-4";


                resultDiv.innerHTML = `

                    <div class="d-flex justify-content-between">

                        <span class="result-name">

                            ${candidate.name}

                        </span>


                        <span class="vote-count">

                            ${candidate.votes} Votes

                        </span>

                    </div>


                    <div class="progress mt-2">

                        <div

                            class="progress-bar ${color}"

                            role="progressbar"

                            style="width:${percentage}%"

                            aria-valuenow="${percentage}"

                            aria-valuemin="0"

                            aria-valuemax="100"

                        >

                            ${percentage}%

                        </div>

                    </div>

                `;


                container.appendChild(resultDiv);


            });


        });


    })


    .catch(error => {

        console.error(
            "Error loading results:",
            error
        );

    });

}


// ==========================================
// LOAD IMMEDIATELY
// ==========================================

loadResults();


// ==========================================
// REFRESH EVERY 3 SECONDS
// ==========================================

setInterval(loadResults, 3000);

</script>


</body>

</html>
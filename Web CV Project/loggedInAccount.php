<?php

session_start();

include 'dbconfig.php';

$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : 0;
if (!$userId) {
    die("User ID is not set in the session.");
}

$hasCV = false;
$cvCheckSql = "SELECT CVId FROM CV WHERE UserID = '$userId'";
$cvCheckResult = $conn->query($cvCheckSql);
if ($cvCheckResult->num_rows > 0) {
    $hasCV = true;
}


$search = "";
$searchResults = "";
if (isset($_POST['search'])) {
    $searchText = $conn->real_escape_string($_POST['searchText']);

    $query = "SELECT DISTINCT CV.FirstName, CV.LastName FROM CV
              LEFT JOIN Languages ON CV.CVId = Languages.CVId
              LEFT JOIN WorkExperiences ON CV.CVId = WorkExperiences.CVId
              LEFT JOIN Educations ON CV.CVId = Educations.CVId
              LEFT JOIN Skills ON CV.CVId = Skills.CVId
              LEFT JOIN Interests ON CV.CVId = Interests.CVId
              LEFT JOIN Hobbies ON CV.CVId = Hobbies.CVId
              LEFT JOIN `References` ON CV.CVId = `References`.CVId
              WHERE CV.Profile LIKE '%$searchText%'
              OR CV.FirstName LIKE '%$searchText%'
              OR CV.LastName LIKE '%$searchText%'
              OR CV.Email LIKE '%$searchText%'
              OR CV.PhoneNumber LIKE '%$searchText%'
              OR CV.Address LIKE '%$searchText%'
              OR CV.PostCode LIKE '%$searchText%'
              OR CV.City LIKE '%$searchText%'
              OR CV.LinkedInURL LIKE '%$searchText%'
              OR Languages.LanguageName LIKE '%$searchText%'
              OR Languages.ProficiencyLevel LIKE '%$searchText%'
              OR WorkExperiences.CompanyName LIKE '%$searchText%'
              OR WorkExperiences.Role LIKE '%$searchText%'
              OR Educations.InstitutionName LIKE '%$searchText%'
              OR Educations.Degree LIKE '%$searchText%'
              OR Educations.FieldOfStudy LIKE '%$searchText%'
              OR Skills.SkillName LIKE '%$searchText%'
              OR Skills.ProficiencyLevel LIKE '%$searchText%'
              OR Interests.Interest LIKE '%$searchText%'
              OR Hobbies.Hobby LIKE '%$searchText%'
              OR `References`.ReferenceName LIKE '%$searchText%'
              OR `References`.Position LIKE '%$searchText%'
              OR `References`.ContactInformation LIKE '%$searchText%'";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $search .= "People who have the qualifications you are looking for <br>";

        while ($row = $result->fetch_assoc()) {
            $searchResults .= "Name: " . htmlspecialchars($row["FirstName"]) . " " . htmlspecialchars($row["LastName"]) . "<br>";
        }
    } else {
        $searchResults = "No matching CVs found.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Profiles</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family:'Times New Roman';
            background-image: url('resim.jpg');
            background-size: cover;
            background-position: center;
            text-align: center;
            overflow-x: hidden;
        }

        header {
            font-size: 24px;
            font-weight: bold;
            color: black;
        }

        .profile-card {
            width: 150px;
            margin: 20px;
            border-radius: 10px;
            display: inline-block;
            background-color: #ffffff;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.4);
            cursor: pointer;
        }

        .button {
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            background: rgb(0, 255, 115, 0.6);
            color: #fff;
            font-weight: bold;
            font-size: large;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }

        #myCV a {
            font-weight: bold;
            color: white;
            text-decoration: none;
        }

        #addCV a {
            font-weight: bold;
            color: white;
            text-decoration: none;
        }

        #updateCV a {
            font-weight: bold;
            color: white;
            text-decoration: none;
        }

        .profile-image {
            width: 150px;
            height: 180px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .top {
            background-color: rgba(0, 0, 0, 0.7);
            margin: 2%;
            padding: 30px;
            border-radius: 8px;
            box-shadow: rgba(0, 0, 0, 0.8);
        }

        .top p {
            font-weight: bold;
            color: white;
        }
        
        @media (max-width: 768px) {
            input {
                width: 120px;
            }
        }
    </style>
</head>

<body>
    <div class="row top">

        <div class="col-lg-4 col-md-4">
            <form action="" method="post">
                <input type="text" name="searchText" placeholder="Search CVs...">
                <button type="submit" name="search" class="button">Search</button>
            </form>
            <p><strong><?php echo $search; ?></strong></p>
            <p><strong><?php echo $searchResults; ?></strong></p>
        </div>


        <div class="col-lg-2 col-md-2">
            <?php if ($hasCV) : ?>
                <h2 id="myCV"><a href="myCv.php">My CV</a></h2>
            <?php else : ?>

            <?php endif; ?>

        </div>
        
        <div class="col-lg-2 col-md-2">
            <?php if ($hasCV) : ?>
                <h2 id="updateCV"><a href="updateCv.php">Update My CV</a></h2>
            <?php else : ?>

            <?php endif; ?>
        </div>

        <div class="col-lg-2 col-md-2">
            <?php if ($hasCV) : ?>

            <?php else : ?>
                <h2 id="addCV"><a href="addCv.html">Add CV</a></h2>
            <?php endif; ?>
        </div>


        <div class="col-lg-2 col-md-2">
            <form action="logout.php" method="post">
                <button type="submit" class="button">Log Out</button>
            </form>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4"></div>
        <div class="col-lg-4 col-md-4">
            <br>
            <header>Professional Profiles</header>
            <br>
        </div>
        <div class="col-lg-4 col-md-4"></div>

    </div>

    <div class="row">

        <div class="col-lg-1 col-md-1"></div>

        <div class="col-lg-10 col-md-10">
            <?php

            $sql = "SELECT * FROM CV";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="profile-card" onclick="location.href=\'cv.php?cvid=' . $row["CVId"] . '\'">';
                    echo '<img class="profile-image" src="data:image/jpeg;base64,' . base64_encode($row['Picture']) . '"/>';
                    echo '<p>' . $row["FirstName"] . ' ' . $row["LastName"] . '</p>';
                    echo '</div>';
                }
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>
        </div>

        <div class="col-lg-1 col-md-1"></div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User's CV</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body, html {
            font-family:'Times New Roman';
            background-image: url('resim.jpg');
        }

        .profile-card {
            background-color: #ececec;
            margin: 20px;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.8);
        }

        .cv-details {
            padding: 40px;
        }

        @media (max-width: 768px) {
            body {
                font-size: 0.7em;
            }

            .profile-card {
                margin-left: 10px;
                margin-right: 10px;
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <?php

        include 'dbconfig.php';


        $cvId = isset($_GET['cvid']) ? intval($_GET['cvid']) : 0;

        
        $sql = "SELECT * FROM CV WHERE CVId = $cvId";
        $cvResult = $conn->query($sql);



        if ($cvResult->num_rows > 0) {
            
            while ($cv = $cvResult->fetch_assoc()) {
                echo '<div class="row">';
                echo "<div class='col-lg-3 col-md-4 col-sm-12'>";
                echo "<div class='profile-card'>";
                echo "<h3><strong>Personal Information</strong></h3>";
                echo "<hr>";
                if (!empty($cv['Picture'])) {
                    echo "<p><strong>Profile Picture</strong><p>";
                    echo "<p><img src='data:image/jpeg;base64," . base64_encode($cv['Picture']) . "' style='border-radius: 10px;'/></p>";
                }
                echo "<p><strong>Name</strong> " . "<br>" . $cv['FirstName'] . " " . $cv['LastName'] . "</p>";
                echo "<p><strong>Email</strong> " . "<br>" . $cv['Email'] . "</p>";
                echo "<p><strong>Phone Number</strong> " . "<br>" . $cv['PhoneNumber'] . "</p>";
                echo "<p><strong>Address</strong> " . "<br>" . $cv['Address'] . "</p>";
                echo "<p><strong>PostCode</strong> " . "<br>" . $cv['PostCode'] . "</p>";
                echo "<p><strong>City</strong> " . "<br>" . $cv['City'] . "</p>";
                echo "<p><strong>LinkedIn URL</strong> " . "<br>" . $cv['LinkedInURL'] . "</p>";
    
                echo "<br>";
    
                $languageSql = "SELECT * FROM Languages WHERE CVId = " . $cv['CVId'];
                $languageResult = $conn->query($languageSql);
                if ($languageResult->num_rows > 0) {
                    echo "<div>";
                    echo "<h2>Languages</h2>";
                    echo "<hr>";
                    while ($language = $languageResult->fetch_assoc()) {
                        echo "<p><strong>Language : </strong>" . $language['LanguageName'] . "</p>";
                        echo "<p><strong>Level : </strong>" . $language['ProficiencyLevel'] . "</p>";
                        echo "<br>";
                    }
                    echo "</div>";
                }
    
                echo "<br>";
    
                
                $skillsSql = "SELECT * FROM Skills WHERE CVId = " . $cv['CVId'];
                $skillsResult = $conn->query($skillsSql);
                if ($skillsResult->num_rows > 0) {
                    echo "<div>";
                    echo "<h2>Skills</h2>";
                    echo "<hr>";
                    while ($skill = $skillsResult->fetch_assoc()) {
                        echo "<p><strong>Skill : </strong>" . $skill['SkillName'] .  "</p>";
                        echo "<p><strong>Level : </strong>" . $skill['ProficiencyLevel'] . "</p>";
                        echo "<br>";
                    }
                    echo "</div>";
                }
    
                echo "<br>";
    
                
                $interestsSql = "SELECT * FROM Interests WHERE CVId = " . $cv['CVId'];
                $interestsResult = $conn->query($interestsSql);
                if ($interestsResult->num_rows > 0) {
                    echo "<div>";
                    echo "<h2>Interests</h2>";
                    echo "<hr>";
                    while ($interest = $interestsResult->fetch_assoc()) {
                        echo "<p><strong>Interest : </strong> " . htmlspecialchars($interest['Interest']) . "</p>";
                        echo "<br>";
                    }
                    echo "</div>";
                }
    
                echo "<br>";
    
                
                $hobbiesSql = "SELECT * FROM Hobbies WHERE CVId = " . $cv['CVId'];
                $hobbiesResult = $conn->query($hobbiesSql);
                if ($hobbiesResult->num_rows > 0) {
                    echo "<div>";
                    echo "<h2>Hobbies</h2>";
                    echo "<hr>";
                    while ($hobby = $hobbiesResult->fetch_assoc()) {
                        echo "<p><strong>Hobby : </strong>" . $hobby['Hobby'] . "</p>";
                        echo "<br>";
                    }
                    echo "</div>";
                }
                echo "</div>";
                echo "</div>";
    
    
                echo '<div class="col-lg-9 col-md-8 col-sm-12 cv-details">';
    
                echo "<h1>" . $cv['FirstName'] . " " . $cv['LastName'] . "</h1>";
    
                echo "<hr>";
    
                echo "<p>" . $cv['Profile'] . "</p>";
    
                echo "<br>";
    
                $workSql = "SELECT * FROM WorkExperiences WHERE CVId = " . $cv['CVId'];
                $workResult = $conn->query($workSql);
                if ($workResult->num_rows > 0) {
                    echo "<div>";
                    echo "<h2>Work Experiences</h2>";
                    echo "<hr>";
                    while ($work = $workResult->fetch_assoc()) {
                        echo "<p><strong>Company : </strong>" . $work['CompanyName'] . "</p>";
                        echo "<p><strong>Role : </strong>" . $work['Role'] . "</p>";
                        echo "<p><strong>Duration : </strong>" . $work['StartDate'] . " to " . ($work['EndDate'] ? $work['EndDate'] : 'Present') . "</p>";
                        echo "<br>";
                    }
                    echo "</div>";
                }
    
                
                
                $educationSql = "SELECT * FROM Educations WHERE CVId = " . $cv['CVId'];
                $educationResult = $conn->query($educationSql);
                if ($educationResult->num_rows > 0) {
                    echo "<div>";
                    echo "<h2>Education</h2>";
                    echo "<hr>";
                    while ($education = $educationResult->fetch_assoc()) {
                        echo "<p><strong>Institution : </strong>" . $education['InstitutionName'] . "</p>";
                        echo "<p><strong>Degree : </strong>" . $education['Degree'] . "</p>";
                        echo "<p><strong>Years : </strong>" . $education['StartYear'] . " - " . $education['EndYear'] . "</p>";
                        echo "<br>";
                    }
                    echo "</div>";
                }
    
                
                $referencesSql = "SELECT * FROM `References` WHERE CVId = " . $cv['CVId'];
                $referencesResult = $conn->query($referencesSql);
                if ($referencesResult->num_rows > 0) {
                    echo "<div>";
                    echo "<h2>References</h2>";
                    echo "<hr>";
                    while ($reference = $referencesResult->fetch_assoc()) {
                        echo "<p><strong>Name : </strong>" . $reference['ReferenceName'] . "</p>";
                        echo "<p><strong>Position : </strong>" . $reference['Position'] . "</p>";
                        echo "<p><strong>Contact Information : </strong>" . $reference['ContactInformation'] . "</p>";
                        echo "<br>";
                    }
                    echo "</div>";
                }
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "No results found.";
        }
        
        $conn->close();
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

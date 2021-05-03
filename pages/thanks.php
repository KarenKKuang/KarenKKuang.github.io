<?php
include("includes/init.php");
$title = "Thanks and Recognition";
$nav_thanks_class = "current_page";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title><?php echo $title; ?></title>

  <link rel="stylesheet" type="text/css" href="/public/styles/site.css" media="all" />
</head>

<body>
  <?php include("includes/header.php"); ?>

  <main>
    <section class='heading'>
      <h1><?php echo $title ?></h1>
    </section>

    <p>Shenzhen Senior High School is grateful to the hundreds of alumni who generously offer help and provide much-needed support for our current students each year. Our alumni had supported a great variety of campus opportunities including student talks, webinars, and one-on-one mentorship.

    <p>These offerings have had a profound impact on the current students, inspiring them to make contribution with equal generosity in the future.</p>

    <p>To our loyal alumni, we thank you for the difference you made in the future of Shenzhen Senior High School.</p>

  </main>

  <?php include("includes/footer.php"); ?>

</body>

</html>

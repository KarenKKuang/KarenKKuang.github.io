<?php
include("includes/init.php");
$title = "Home";
$nav_home_class = "current_page";

$sql_select_query = 'SELECT * FROM informations;';
$sql_select_params = array();
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

    <h2>Don't hesitate to hear insightful experiences from our alumni!</h2>

    <section class='home_gallery'>
      <?php
      $records = exec_sql_query($db, $sql_select_query, $sql_select_params)->fetchAll();

      if (count($records) > 0) {
        $records = array($records[0], $records[1], $records[2], $records[3])?>
        <ul>
          <?php
          foreach ($records as $record) {
            $name = $record['first_name'].' '.$record['last_name'];?>
            <li>
              <?php
              if (is_user_logged_in()) { ?>
              <a href="/connecting-alumni/person?<?php echo http_build_query(array('id' => $record['id'])); ?>">
              <?php
              } ?>
                <!-- Shenzhen Senior High School 2020 Year Book (with the permission of the owner of the picture) -->
                <img src="/public/uploads/persons/<?php echo $record['user_id'] . '.jpeg'; ?>" alt="<?php echo htmlspecialchars($name); ?>" />
                <p id='name'><?php echo htmlspecialchars($name);?> '<?php echo substr($record['graduation_year'], 2, 4); ?></p>
                <p id='school'><?php echo htmlspecialchars($record['university']); ?>, <?php echo htmlspecialchars($record['major']); ?></p>
              <?php
              if (is_user_logged_in()) { ?>
              </a>
              <?php
              } ?>
            </li>
          <?php
          } ?>
        </ul>
      <?php }?>
    </section>

    <div>
      <p>Visit the <a href="/connecting-alumni">Alumni Connection Page</a> for more alumni</p>
    </div>

    <div>
      <h3>Cindy Huang, 2019</h3>
      <p>I got admitted to Berkeley all because of the help I got from my mentor. She didn't only offered me insights into the application process, but also supported me through hard times during the preparation. I've definitely made a lasting friendship from this amazing experience.</p>
    </div>

    <div>
      <h3>Tianshen Sun, 2018</h3>
      <p>I've found it extremely rewarding being a mentor. The heartwarming feeling that you have helped someone build a foundation towards their future and seeing the mentee's happiness and excitement are what make this work enriching. My favorite moment of all time if to hear my mentees getting admitted to their dream colleges.</p>
    </div>

  </main>

  <?php include("includes/footer.php"); ?>

</body>

</html>

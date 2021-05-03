<?php
include("includes/init.php");
$title = "Joining the Network";
$nav_join_class = "current_page";

$graduation_years = array("2021", "2020", "2019", "2018", "2017", "2016", "2015");

$sql_select_query = 'SELECT * FROM informations;';
$sql_select_params = array();

if ($is_alumnus) {
  // ----- INSERT -----
  // feedback message
  $first_name_feedback_class = 'hidden';
  $last_name_feedback_class = 'hidden';
  $graduation_year_feedback_class = 'hidden';
  $university_feedback_class = 'hidden';
  $major_feedback_class = 'hidden';
  $contact_feedback_class = 'hidden';

  // additional validation constraints
  $record_inserted = False;
  $record_insert_failed = False;

  // form values
  $first_name = NULL;
  $last_name = NULL;
  $graduation_year = NULL;
  $university = NULL;
  $major = NULL;
  $contact = NULL;

  // sticky values
  $sticky_first_name = '';
  $sticky_last_name = '';

  $sticky_empty_year = '';
  $sticky_2021 = '';
  $sticky_2020 = '';
  $sticky_2019 = '';
  $sticky_2018 = '';
  $sticky_2017 = '';
  $sticky_2016 = '';
  $sticky_2015 = '';

  $sticky_university = '';
  $sticky_major = '';
  $sticky_contact = '';

  if (isset($_POST['add_alumnus'])) {
    $first_name = trim($_POST['first_name']); // untrusted
    $last_name = trim($_POST['last_name']); // untrusted
    $graduation_year = trim($_POST['graduation_year']); // untrusted
    $university = trim($_POST['university']); // untrusted
    $major = trim($_['major']); // untrusted
    $contact = trim($_['contact']); // untrusted

    $form_valid = True;

    if (empty($first_name)) {
      $form_valid = False;
      $first_name_feedback_class = '';
    }

    if (empty($last_name)) {
      $form_valid = False;
      $last_name_feedback_class = '';
    }

    if (!in_array($graduation_year, $graduation_years)) {
      $form_valid = False;
      $graduation_year_feedback_class = '';
    }

    if (empty($university)) {
      $form_valid = False;
      $university_feedback_class = '';
    }

    if (empty($major)) {
      $form_valid = False;
      $major_feedback_class = '';
    }

    if (empty($contact)) {
      $form_valid = False;
      $contact_feedback_class = '';
    }

    if ($form_valid) {
      // insert new record into database
      $result = exec_sql_query(
        $db,
        "INSERT INTO informations (first_name, last_name, graduation_year, university, major, contact) VALUES (:first_name, :last_name, :graduation_year, :university, :major, :contact);",
        array(
          ':first_name' => $first_name, // tainted
          ':last_name' => $last_name, // tainted
          ':graduation_year' => $graduation_year, // tainted
          ':university' => $university, // tainted
          ':major' => $major, // tainted
          ':contact' => $contact, // tainted
        )
      );

      if ($result) {
        $record_inserted = True;
      } else {
        $record_insert_failed = True;
      }
    } else {
      // form is invalid, set sticky values
      $sticky_first_name = $first_name;
      $sticky_last_name = $last_name;

      $sticky_empty_year = ($graduation_year == '-' ? 'selected' : '');
      $sticky_2021 = ($graduation_year == '2021' ? 'selected' : '');
      $sticky_2020 = ($graduation_year == '2020' ? 'selected' : '');
      $sticky_2019 = ($graduation_year == '2019' ? 'selected' : '');
      $sticky_2018 = ($graduation_year == '2018' ? 'selected' : '');
      $sticky_2017 = ($graduation_year == '2017' ? 'selected' : '');
      $sticky_2016 = ($graduation_year == '2016' ? 'selected' : '');
      $sticky_2015 = ($graduation_year == '2015' ? 'selected' : '');

      $sticky_university = $university;
      $sticky_major = $major;
      $sticky_contact = $contact;
    }
  }
}
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

    <?php if (is_user_logged_in() && !$is_alumnus) {
      // user is logged in, but is not an admin
    ?>
      <p>This page is intended for alumni.</p>

    <?php
    } else if (!is_user_logged_in()) {
    ?>
      <p>You must sign in to join the network.</p>

    <?php
      echo_login_form("/joining-the-network", $session_messages);
    } ?>

    <?php if ($is_alumnus) { ?>
      <section id='add_alumnus'>
        <?php if ($record_inserted) { ?>
                <p id='insert_successful'><?php echo htmlspecialchars($first_name) . ' ' . htmlspecialchars($last_name); ?>, welcome to the platform!</p>
              <?php } ?>

        <?php if ($record_insert_failed) { ?>
          <p cid='insert_failed' lass="feedback">Failed to add <?php echo htmlspecialchars($first_name) . ' ' . htmlspecialchars($last_name); ?> to the platform.</p>
        <?php } ?>

        <h2>Join the Platform</h2>

        <form id="add" action="/joining-the-network" method="post" novalidate>
          <p id="first_name_feedback_class" class="feedback <?php echo $first_name_feedback_class; ?>">Please provide a first name.</p>
          <div class="group_label_input">
            <label for="add_first_name">First Name:</label>
            <input id="add_first_name" type="text" name="first_name" value="<?php echo htmlspecialchars($sticky_first_name); ?>" required />
          </div>

          <p id="last_name_feedback_class" class="feedback <?php echo $last_name_feedback_class; ?>">Please provide a last name.</p>
          <div class="group_label_input">
            <label for="add_last_name">Last Name:</label>
            <input id="add_last_name" type="text" name="last_name" value="<?php echo htmlspecialchars($sticky_last_name); ?>" required />
          </div>

          <div class="group_label_input">
            <label for="add_year">Year:</label>
            <select id="add_year" name="year">
              <option value='-' <?php echo htmlspecialchars($sticky_empty_concentration); ?>>-</option>
              <option value='2021' <?php echo htmlspecialchars($sticky_2021); ?>>2021</option>
              <option value='2020' <?php echo htmlspecialchars($sticky_2020); ?>>2020</option>
              <option value='2019' <?php echo htmlspecialchars($sticky_2019); ?>>2019</option>
              <option value='2018' <?php echo htmlspecialchars($sticky_2018); ?>>2018</option>
              <option value='2017' <?php echo htmlspecialchars($sticky_2017); ?>>2017</option>
              <option value='2016' <?php echo htmlspecialchars($sticky_2016); ?>>2016</option>
              <option value='2015' <?php echo htmlspecialchars($sticky_2015); ?>>2015</option>
            </select>
          </div>

          <p id="university_feedback_class" class="feedback <?php echo $university_feedback_class; ?>">Please provide a university.</p>
          <div class="group_label_input">
            <label for="add_university">University:</label>
            <input id="add_university" type="text" name="university" value="<?php echo htmlspecialchars($sticky_university); ?>" required />
          </div>

          <p id="major_feedback_class" class="feedback <?php echo $major_feedback_class; ?>">Please provide a major.</p>
          <div class="group_label_input">
            <label for="add_major">Major:</label>
            <input id="add_major" type="text" name="major" value="<?php echo htmlspecialchars($sticky_major); ?>" required />
          </div>

          <p id="contact_feedback_class" class="feedback <?php echo $contact_feedback_class; ?>">Please provide a contact.</p>
          <div class="group_label_input">
            <label for="add_contact">Contact:</label>
            <input id="add_contact" type="text" name="contact" value="<?php echo htmlspecialchars($sticky_contact); ?>" required />
          </div>

          <div class="align-right">
            <button type="submit" name="add_alumnus" id='add_alumnus_button'>Join</button>
          </div>
        </form>
      </section>
    <?php
    } ?>

  </main>

  <?php include("includes/footer.php"); ?>

</body>

</html>

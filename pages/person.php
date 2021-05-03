<?php
include("includes/init.php");
$nav_connect_class = "current_page";

$person_id = (int)trim($_GET['id']);
$url = "/connecting-alumni/person?" . http_build_query(array('id' => $person_id));

$edit_mode = False;
$edit_authorization = False;

$graduation_years = array("2021", "2020", "2019", "2018", "2017", "2016", "2015");

if (isset($_GET['edit'])) {
  $edit_mode = True;
  $person_id = (int)trim($_GET['edit']);
}

if ($person_id) {
  $records = exec_sql_query(
    $db,
    "SELECT * FROM informations WHERE id = :id;",
    array(':id' => $person_id)
  )->fetchAll();
  if (count($records) > 0) {
    $person = $records[0];
  } else {
    $person = NULL;
  }
}

if ($person) {

  if (current_user()['id'] == $person['user_id']){
    $edit_authorization = True;
  }

  if ($edit_authorization) {
    $first_name_feedback_class = 'hidden';
    $last_name_feedback_class = 'hidden';
    $graduation_year_feedback_class = 'hidden';
    $university_feedback_class = 'hidden';
    $major_feedback_class = 'hidden';
    $contact_feedback_class = 'hidden';

    if (isset($_POST['save'])) {
      $fist_name = trim($_POST['first_name']); // untrusted
      $last_name = trim($_POST['last_name']); // untrusted
      $graduation_year = trim($_POST['graduation_year']); // untrusted
      $university = trim($_POST['university']); // untrusted
      $major = trim($_POST['major']); // untrusted
      $country = trim($_POST['country']); // untrusted

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
        exec_sql_query(
          $db,
          "UPDATE informations SET fist_name = :fist_name, last_name = :last_name, graduation_year = :graduation_year, university = :university, major = :major, country = :country WHERE (id = :id);",
          array(
            'fist_name' => $fist_name,
            'last_name' => $last_name,
            'graduation_year' => $graduation_year,
            'university' => $university,
            'major' => $major,
            'country' => $country
          )
        );

        $records = exec_sql_query(
          $db,
          "SELECT * FROM informations WHERE id = :id;",
          array(':id' => $person_id)
        )->fetchAll();
        $person = $records[0];
      }
    }
  }

  $name = htmlspecialchars($person['first_name'].' '.$person['last_name']);
  $url = "/connecting-alumni/person?" . http_build_query(array('id' => $person['id']));
  $edit_url = "/connecting-alumni/person?" . http_build_query(array('edit' => $person['id']));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title><?php echo $name; ?></title>

  <link rel="stylesheet" type="text/css" href="/public/styles/site.css" media="all" />
</head>

<body>
  <?php include("includes/header.php"); ?>

  <main class="person">
    <section class='heading'>
      <h1><?php echo $name; ?></h1>
    </section>

    <section>
      <?php if ($person) { ?>

        <?php if ($edit_authorization && $edit_mode) { ?>
          <div class='flex_box'>
            <!-- Shenzhen Senior High School 2020 Year Book (with the permission of the owner of the picture) -->
            <img class='left' src="/public/uploads/persons/<?php echo $person['id'] . '.jpeg'; ?>" alt="<?php echo $name; ?>" />

            <div class='right'>
              <h2>Personal Information</h2>

              <form class="edit" action="<?php echo $url; ?>" method="post" novalidate>
                <p id="first_name_feedback_class" class="feedback <?php echo $first_name_feedback_class; ?>">Please provide a first name.</p>
                <div class="group_label_input">
                  <label for="first_name">First Name:</label>
                  <input id="first_name" type="text" name="first_name" value="<?php echo htmlspecialchars($person['first_name']); ?>" required />
                </div>

                <p id="last_name_feedback_class" class="feedback <?php echo $last_name_feedback_class; ?>">Please provide a last name.</p>
                <div class="group_label_input">
                  <label for="last_name">Last Name:</label>
                  <input id="last_name" type="text" name="last_name" value="<?php echo htmlspecialchars($person['last_name']); ?>" required />
                </div>

                <p id="graduation_year_feedback_class" class="feedback <?php echo $last_name_feedback_class; ?>">Please provide a graduation year.</p>
                <div class="group_label_input">
                  <label for="graduation_year">Year:</label>
                  <input id="graduation_year" type="text" name="graduation_year" value="<?php echo htmlspecialchars($person['graduation_year']); ?>" required />
                </div>

                <p id="university_feedback_class" class="feedback <?php echo $university_feedback_class; ?>">Please provide a university.</p>
                <div class="group_label_input">
                  <label for="university">University:</label>
                  <input id="university" type="text" name="university" value="<?php echo htmlspecialchars($person['university']); ?>" required />
                </div>

                <p id="major_feedback_class" class="feedback <?php echo $major_feedback_class; ?>">Please provide a major.</p>
                <div class="group_label_input">
                  <label for="major">Major:</label>
                  <input id="major" type="text" name="major" value="<?php echo htmlspecialchars($person['major']); ?>" required />
                </div>

                <p id="contact_feedback_class" class="feedback <?php echo $major_feedback_class; ?>">Please provide a contact.</p>
                <div class="group_label_input">
                  <label for="major">Contact:</label>
                  <input id="major" type="text" name="contact" value="<?php echo htmlspecialchars($person['contact']); ?>" required />
                </div>

                <div class="align-right">
                  <button type="submit" name="save" id='save_button'>Save</button>
                </div>
              </form>
            <div>
          </div>

        <?php
        } else { ?>
          <div class='flex_box'>
            <!-- Shenzhen Senior High School 2020 Year Book (with the permission of the owner of the picture) -->
            <img class='left' src="/public/uploads/persons/<?php echo $person['id'] . '.jpeg'; ?>" alt="<?php echo $name; ?>" />

            <div class='right'>
              <h2>Personal Information</h2>
              <table>
                <tr>
                  <td>Name:</td>
                  <td>
                    <?php echo htmlspecialchars($person['first_name']); ?>
                    <?php echo htmlspecialchars($person['last_name']); ?>
                    <?php if ($edit_authorization) { ?>
                      (<a href="<?php echo $edit_url; ?>">Edit</a>)
                      <?php
                    } ?>
                  </td>
                </tr>

                <tr>
                  <td>Graduation Year:</td>
                  <td>
                    <?php echo htmlspecialchars($person['graduation_year']); ?>
                    <?php if ($edit_authorization) { ?>
                      (<a href="<?php echo $edit_url; ?>">Edit</a>)
                      <?php
                    } ?>
                  </td>
                </tr>

                <tr>
                  <td>University:</td>
                  <td>
                    <?php echo htmlspecialchars($person['university']); ?>
                    <?php if ($edit_authorization) { ?>
                      (<a href="<?php echo $edit_url; ?>">Edit</a>)
                      <?php
                    } ?>
                  </td>
                </tr>

                <tr>
                  <td>Major:</td>
                  <td>
                    <?php echo htmlspecialchars($person['major']); ?>
                    <?php if ($edit_authorization) { ?>
                      (<a href="<?php echo $edit_url; ?>">Edit</a>)
                      <?php
                    } ?>
                  </td>
                </tr>

                <tr>
                  <td>Contact:</td>
                  <td>
                    <?php echo htmlspecialchars($person['contact']); ?>
                    <?php if ($edit_authorization) { ?>
                      (<a href="<?php echo $edit_url; ?>">Edit</a>)
                      <?php
                    } ?>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <?php
        } ?>
        <?php
      } else { ?>
          <p><strong>The person has not joined the networks.</strong> Try finding an alumnus from the <a href="/connecting-alumni">Alumni Connection Page</a>.</strong></p>
        <?php
      } ?>
    </section>
  </main>

  <?php include("includes/footer.php"); ?>
</body>

</html>

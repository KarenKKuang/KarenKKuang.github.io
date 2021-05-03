<?php
include("includes/init.php");
$title = "Connecting Alumni";
$nav_connect_class = "current_page";

if ($is_alumnus || $is_student) {
  $graduation_years = array("2020", "2019", "2018", "2017", "2016", "2015");
  $countries = array('US', 'UK', 'Canada', 'Hong Kong, China');

  $sql_select_query = 'SELECT * FROM informations';
  $sql_select_params = array();


  // ----- SEARCH -----
  // form values
  $search_terms = trim($_GET['q']); // untrusted
  if (empty($search_terms)) {
    $search_terms = NULL;
  }

  // sticky values
  $sticky_search = $search_terms; // tainted

  if ($search_terms) {
    $sql_select_query = "SELECT * FROM informations WHERE (first_name LIKE '%' || :search || '%') OR (last_name LIKE '%' || :search || '%')";
    $sql_select_params = array(':search' => $search_terms);
  }


  // ----- FILTER -----
  // sticky values
  $sticky_filters = array();

  $graduation_year_filter_exprs = '';
  $country_filter_exprs = '';
  $has_filtering = False;

  foreach ($graduation_years as $graduation_year) {
    $should_filter = (bool)$_GET[$graduation_year]; // untrusted

    // sticky values
    $sticky_filters[$graduation_year] = ($should_filter ? 'checked' : '');

    // TODO: assemble the filter query
    if ($should_filter) {
      $has_filtering = True;
      $graduation_year_filter_exprs = $graduation_year_filter_exprs . "(graduation_year = '".$graduation_year."') OR ";
    }
  }

  foreach ($countries as $country) {
    $country_param = str_replace(' ', '-', strtolower($country));
    $should_filter = (bool)$_GET[$country_param]; // untrusted

    // sticky values
    $sticky_filters[$country_param] = ($should_filter ? 'checked' : '');

    // TODO: assemble the filter query
    if ($should_filter) {
      $has_filtering = True;
      $country_filter_exprs = $country_filter_exprs . "(country = '". $country . "') OR ";
    }
  }

  $graduation_year_filter_exprs = empty($graduation_year_filter_exprs) ? '' : ("(" . substr($graduation_year_filter_exprs, 0, -4) . ")" . " AND ");
  $country_filter_exprs = empty($country_filter_exprs) ? '' : ("(" . substr($country_filter_exprs, 0, -4) . ")" . " AND ");

  $filter_exprs_collection = $graduation_year_filter_exprs .$country_filter_exprs;

  if ($has_filtering) {
    // TODO: Assign $sql_select_query an SQL for filtering
    $sql_select_query = "SELECT * FROM informations WHERE " . substr($filter_exprs_collection, 0, -5) . ";";
  }


  // ----- SORT -----
  $sort_newest = '';
  $sort_earliest = '';
  $sort = $_GET['sort']; // untrusted

  $sort_css_classes = array(
    'newest' => '',
    'earliest' => '',
  );

  // do we have a valid value to sort?
  if (in_array($sort, array('newest', 'earliest'))) {

    $sql_select_query = "SELECT * FROM informations";

    if ($sort == 'newest') {
      $sql_select_query = $sql_select_query . ' ORDER BY graduation_year DESC;';
      $sort_css_classes['newest'] = 'active';
      $sort_course_number = 'current_sorting';
    } else if ($sort == 'earliest') {
      $sql_select_query = $sql_select_query . ' ORDER BY graduation_year ASC;';
      $sort_css_classes['earliest'] = 'active';
      $sort_credit = 'current_sorting';
    }
  } else {
    $sort = NULL;
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

    <?php if (is_user_logged_in()) { ?>
      <div class='flex_box'>
        <div id='main_table'>
          <section class="sort">
            <p>Sort by:
              <a class="<?php echo $sort_css_classes['newest'];?> <?php echo $sort_course_number;?>" href="/connecting-alumni?sort=newest">Newest</a> |
              <a class="<?php echo $sort_css_classes['earliest'];?> <?php echo $sort_credit;?>" href="/connecting-alumni?sort=earliest">Earliest</a>
            </p>
          </section>

          <section class='gallery'>
            <?php
            $records = exec_sql_query($db, $sql_select_query, $sql_select_params)->fetchAll();

            if (count($records) > 0) { ?>
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

            <?php } else {?>
              <div class='not_found'>
                <p>No person found.</p>
              </div>
            <?php } ?>
          </section>
        </div>

        <div id='side_bar'>
          <form action="/connecting-alumni" method="get" id='search_group' novalidate>
            <input id="search" type="text" name="q" required value="<?php echo htmlspecialchars($sticky_search); ?>" />
            <button type="submit" id="search_button">Search</button>
          </form>

          <form action="/connecting-alumni" method="get" class="filter" novalidate>
            <div>
              <h4>Filter by Graduation Year</h4>
              <?php
              foreach ($graduation_years as $graduation_year) {?>
                <label>
                  <input type="checkbox" name="<?php echo htmlspecialchars($graduation_year); ?>" value="1" <?php echo $sticky_filters[$graduation_year]; ?> />
                  <?php echo htmlspecialchars($graduation_year); ?>
                </label>
              <?php } ?>
            </div>

            <div>
              <h4>Filter by Country</h4>
              <?php
              foreach ($countries as $country) {
                $country_param = str_replace(' ', '-', strtolower($country));?>
                <label>
                  <input type="checkbox" name="<?php echo htmlspecialchars($country_param); ?>" value="1" <?php echo $sticky_filters[$country_param]; ?> />
                  <?php echo htmlspecialchars($country); ?>
                </label>
              <?php } ?>
            </div>

            <button type="submit" id="filter_button">Filter</button>
          </form>
        </div>
      </div>
    <?php
    } else if (!is_user_logged_in()) {
    ?>
      <p>You must sign in to view the alumni network.</p>

    <?php
      echo_login_form("/connecting-alumni", $session_messages);
    } ?>

  </main>

  <?php include("includes/footer.php"); ?>

</body>

</html>

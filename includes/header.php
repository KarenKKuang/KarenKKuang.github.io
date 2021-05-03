<header>
  <!-- source: Shenzhen Senior High School Official Wechat Account -->
  <img src="../public/images/logo2.png" alt="The CIS Logo">

  <div class='title-nav'>
    <h1>Shenzhen Senior High School Alumni Connection</h1>
    <nav>
      <ul>
        <li class="<?php echo $nav_home_class; ?>"><a href="/">Home</a></li> ·
        <li class="<?php echo $nav_connect_class; ?>"><a href="/connecting-alumni">Connecting Alumni</a></li> ·
        <li class="<?php echo $nav_thanks_class; ?>"><a href="/thanks-and-recognition">Thanks & Recognition</a></li> ·
        <li class="<?php echo $nav_join_class; ?>"><a href="/joining-the-network">Joining the Network</a></li>

        <?php if (is_user_logged_in()) { ?>
          <li id="logout"><a href="<?php echo logout_url(); ?>">Sign Out</a></li>
        <?php } ?>
      </ul>
    </nav>
  </div>
</header>

<div id="zen_content" class="row">


        <div class="col-xl-8 col-lg-7">
            <div class="zen_float_right">
                <a href="%pp_url%/news.php">More &raquo;</a>
            </div>
            <h2>News</h2>
            {-news_homepage-}
        </div>
        <div class="col-xl-4 col-lg-5">
            <?php
            $session = new session;
            $ses = $session->check_session();
            if ($ses['error'] != '1') {
                $user = new user;
                $username = $user->get_username($ses['member_id']);
            ?>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Welcome back <?php echo $username; ?>!</h5>

                        <p class="card-text"><a href="%pp_url%/manage">Visit the member's area &raquo;</a></p>
                    </div>
                </div>

            <?php
            } else {
            ?>
                {-login_box-}
                <p></p>
                {-not_a_member_box-}
            <?php
            }
            ?>
        </div>



</div>
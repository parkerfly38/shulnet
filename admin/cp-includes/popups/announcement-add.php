<?php 

$news = new news();
$feeds = $news->getRegions();

$allFeeds = array();
foreach ($feeds as $anItem) {
    $allFeeds[$anItem['tag']] = $anItem['name'];
}

if (! empty($_POST['id'])) {

    $newsData = $news->getArticle($_POST['id'], true);

    $editing  = '1';

    $final_id = $_POST['id'];

    $active   = $newsData['active'];
    $title    = $newsData['title'];
    $starts   = $newsData['starts'];
    $ends     = $newsData['ends'];
    $public  = $newsData['public'];
    $content  = $newsData['content'];
    $type     = $newsData['type'];
    $cid      = $newsData['media_token'];

    $media = $news->buildMediaLink($newsData['media']);

    $media_location = $newsData['media_location'];

    $selectedFeeds = $news->postRegions($_POST['id']);
} else {
    $cid = rand();
    $editing  = '0';
    $final_id = '';
    $active   = '1';
    $title    = '';
    $starts   = '';
    $ends     = '';
    $public  = '1';
    $content  = '';
    $media = '';
    $type     = 'post';
    $media_location = 'left';

    $selectedFeeds = array(
        // 'homepage',
        'posts_home',
    );
}


?>



<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('announcement-add', '<?php echo $final_id; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>

<script type="text/javascript">

    $(document).ready(function() {
        $("input[type=radio][name='type']").change(function() {
            switch(this.value) {
                case 'video':
                    return swap_multi_div('show_video', 'media');
                case 'post':
                    return swap_multi_div('media', 'show_video');
            }
        });
    });

</script>

<form action="" method="post" id="popupform"
      onsubmit="return json_add('announcement-add','<?php echo $final_id; ?>','<?php echo $editing; ?>','popupform');">


    <div id="popupsave">

        <input type="submit" value="Save" class="save"/>
        <input type="hidden" name="media_token" value="<?php echo $cid; ?>" />

    </div>

    <h1>News Post</h1>

    <div class="popupbody">

        <ul id="step_tabs" class="popup_tabs">
            <li class="on">
                Post Details
            </li><li>
                Schedule &amp; Options
            </li><li>
                Feeds
            </li>
        </ul>

        <div id="step_1" class="step_form fullForm">

            <p class="highlight">Posts are news items which appear on a news feed. These are not e-mail or SMS broadcasts. Please use the "Marketing" tab for that functionality.</p>

            <div class="col30" id="adminMediaLeft">
                <fieldset>
                    <div class="pad">

                        <?php
                        if ($editing != '1') {
                        ?>

                        <label>Type</label>
                        <?php
                        echo $af->radio('type', $type, array(
                            'post' => 'Post',
                            'video' => 'Video',
                        ));

                        } else {
                        ?>

                            <input type="hidden" name="type" value="<?php echo $type; ?>" />

                        <?php
                        }
                        ?>


                        <div id="media" style="display:<?php
                        if ($type == 'post') {
                            echo 'block';
                        } else {
                            echo 'none';
                        }
                        ?>;">

                            <?php
                            if (! empty($media)) {
                                echo '<img src="' . $media . '" class="post_news_media" alt="' . $title . '" />';
                            }
                            ?>

                            <label>Post Image</label>
                            <?php
                            /*
                            echo $af
                                ->setDescription('Each post can have an image associated with it.')
                                ->upload('media_file');
                            */
                            ?>

                            <script type="text/javascript" src="js/jquery.fileuploader.js"></script>
                            <script type="text/javascript">
                                $(document).ready(function () {
                                    var uploader = new qq.FileUploader({
                                        element: document.getElementById('fileuploader'),
                                        action: 'cp-functions/post_media.php',
                                        debug: true,
                                        params: {
                                            id: '<?php echo $cid; ?>',
                                            label: 'news_post'
                                        }
                                    });
                                });
                            </script>
                            <div id="fileuploader" style="margin-bottom: 24px;">
                                <noscript><p>Please enable JavaScript to use file uploader.</p></noscript>
                            </div>

                            <label>Media Location</label>
                            <?php
                            echo $af
                                ->setDescription('Where would you like the media to appear relative to the post\'s content?')
                                ->radio('media_location', $media_location, array(
                                'left' => 'Left of Content',
                                'top' => 'Above Content',
                                'right' => 'Right of Content',
                            ));
                            ?>
                        </div>

                        <?php
                        if ($type == 'video') {
                        echo $newsData['player'];
                        }
                        ?>


                    </div>
                </fieldset>
            </div>
            <div class="col70">

                <fieldset>
                    <div class="pad">

                        <label>Post Title</label>
                        <?php
                        echo $af->string('title', $title, 'req');
                        ?>

                        <div id="show_video" style="display:<?php
                        if ($type == 'video') {
                            echo 'block';
                        } else {
                            echo 'none';
                        }
                        ?>;">
                            <label>Video URL</label>
                            <?php
                            echo $af
                                ->setPlaceholder('https://www.youtube.com/watch?v=aOvZkEg3foE or https://vimeo.com/1234567890')
                                ->setDescription('The program currently supports <b>Youtube</b> and <b>Vimeo</b>. Simply copy and paste the URL to the video (not the URL in the "embed"/"share" dialogue).')
                                ->string('media', $content, '');
                            ?>
                        </div>

                        <div id="show_post">
                            <label>Post Content</label>
                            <?php
                            echo $af->richtext('content', $content, '300');
                            ?>
                        </div>


                    </div>
                </fieldset>

            </div>


        </div>

        <div id="step_2" class="step_form fullForm">

            <p class="highlight">Use these options to customize the specifics of when and how this post will be visible.</p>

            <fieldset>
                <div class="pad">

                    <div class="col50l">
                        <label>Status</label>
                        <?php
                        echo $af->radio('active', $active, array(
                            '1' => 'Live',
                            '0' => 'Hidden',
                        ));
                        ?>

                        <label>Who can view this post?</label>
                        <?php
                        echo $af->radio('public', $public, array(
                            '1' => 'Public',
                            '0' => 'Members Only',
                        ));
                        ?>
                    </div>

                    <div class="col50r">
                        <label>Scheduled For</label>
                        <?php
                        echo $af
                            ->setDescription('What date should this post appear in the news feed?')
                            ->setSpecialType('date')
                            ->string('starts', $starts, '');
                        ?>

                        <label>Run Until</label>
                        <?php
                        echo $af
                            ->setDescription('Leave blank to permanately.')
                            ->setSpecialType('date')
                            ->string('ends', $ends, '');
                        ?>
                    </div>
                    <div class="clear"></div>

                </div>
            </fieldset>

        </div>

        <div id="step_3" class="step_form fullForm">

            <p class="highlight">Which feeds would you like this post to appear in?</p>

            <fieldset>
                <div class="pad">
                    <label>Display In Feeds</label>

                    <?php
                    echo $af->checkGroup('feeds', $allFeeds, $selectedFeeds);
                    ?>

                </div>
            </fieldset>

        </div>


    </div>


</form>
<script src="<?php echo PP_ADMIN; ?>/js/form_steps.js" type="text/javascript"></script>
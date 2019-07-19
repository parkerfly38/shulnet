<!DOCTYPE html>
<html lang="%lang%">
<head>
    <meta charset="UTF-8" />
    <title>%meta_title%</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="author" content="%pp_company%" />
    <meta name="description" content="%meta_desc%" />
    <meta name="generator" content="Zenbership Membership Software (www.zenbership.com)"/>
    <link href="%theme_url%/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="%theme_url%/css/fullcalendar.css" rel="stylesheet" type="text/css" />
    <style>
        body { padding-top: 5rem; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="%home_link%"><?php echo $this->get_option('company_name'); ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
  <?php
        $session = new session;
        $ses = $session->check_session();
        if ($ses['error'] != '1') {
            ?>
            {-site_topbar_logged_in-}
            <?php
        } else {
            ?>
            {-site_topbar-}
            <?php
        }
        ?>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>

<main role="main" class="container">
        <div class="row">
        %error_code%
        %success_code%
        <nav aria-label="breadcrumb">
  <ol class="breadcrumb">        
    <!--<li class="breadcrumb-item active" aria-current="page">%page_title%</li>-->
    %pp_breadcrumbs%
  </ol>
</nav>
</div>
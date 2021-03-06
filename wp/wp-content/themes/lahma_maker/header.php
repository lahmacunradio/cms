<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Maker
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>

<link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-149605744-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-149605744-1');
</script>

</head>

<?php if ( is_home() ) : ?>
    <body <?php body_class("home"); ?>>
<?php else : ?>
    <body <?php body_class(); ?>>
<?php endif; ?>

<body>

<div id="page" class="hfeed site">

	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'maker' ); ?></a>

<header id="masthead" class="site-header" role="banner">

  <?php // donatebanner show
  $contDonate = get_option("contDonate");
  $contShower = get_option("shower");

  $showDonateButton = get_option("showDonateButton");
  $contButton = get_option("contButton");
  $linkButton = get_option("linkButton"); 

  $contCampaignText = get_option("contCampaignText");  
  $contCampaign = get_option("contCampaign");
  $contCampaignID = get_page_by_path($contCampaign, number, "campaign")->ID;
  $contCampaignButton = get_option("contCampaignButton");
  $contShowCampaign = get_option("showCampaign");
  $contCampaignStartAmount = get_option("CampaignStart");
  $contCampaignEndAmount = get_option("CampaignEnd");

  $campaign = $view_args['campaign'];

  if ( $contShower == "show" ) :

  ?>

  <div id="donatebanner">
    <a id="closedonate" class="avoidAjax"><i class="fa fa-times" aria-hidden="true"></i>
</a>
    <div id="donateholder">

	<?php if ($contShowCampaign == "show") { 
	?>
		<div class="campaignTextBar">
			<div class="campaigntext">
				<?php echo $contCampaignText; ?>
			</div>
				
			<div class="progressinfos">
				<div class="startgoal"><?php echo $contCampaignStartAmount; ?></div>
<div class="infotext">
				<div class="goalprogress"></div>
				<?php echo do_shortcode( "[charitable_stat campaigns=" . $contCampaignID . " display=progress goal=650]" );	?>
</div>
				<div class="endgoal"><?php echo $contCampaignEndAmount; ?></div>
			</div>
		
		</div>

		<a id="campaignbutton" class="donate-button" href="/campaigns/<?php echo $contCampaign; ?>"><?php echo $contCampaignButton; ?></a>

	<?php

	 } else { ?>	

	  <p><?php echo $contDonate; ?></p>
	  
	  <?php if ($showDonateButton == "show" ) { ?>
		  <a id="donatebutton" class="donate-button" target="_blank" href="<?php 
			echo $linkButton ? $linkButton : get_home_url().'/donate'; ?>">
		  <?php echo $contButton ? $contButton : 'Donate Us'; ?>
		  </a>
		<?php } ?>  


	<?php } ?>  

    </div>
  </div>

<?php endif; ?>


	<div id="playerwrap">
	<?php
		get_template_part( 'playercode' );
	?>
	</div>

	<div class="wrap">
		<div class="site-branding">
			<?php maker_site_logo(); ?>
			<?php maker_site_title(); ?>
			<?php maker_site_description(); ?>
		</div><!-- .site-branding -->

		<button id="site-navigation-toggle" class="menu-toggle" >
			<span class="menu-toggle-icon"></span>
			<?php esc_html_e( 'Primary Menu', 'maker' ); ?>
		</button><!-- #site-navigation-menu-toggle -->

	</div><!-- .column -->

		<nav id="site-navigation" class="main-navigation" role="navigation">
			
			<?php 
			wp_nav_menu( array( 
				'theme_location' => 'primary', 
				'menu_id' => 'primary-menu' ) ); 
			
			?>

			<?php 
			wp_nav_menu( array( 
				'theme_location' => 'social', 
				'menu_id' => 'social-menu' ) ); 
			
			?>

		</nav><!-- #site-navigation -->
	

</header><!-- #masthead -->

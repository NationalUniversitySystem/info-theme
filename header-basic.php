<?php
/**
 * The header for our theme
 *
 * This is the most basic version of our header.
 * i.e. It does not contain the header section.
 *
 * @package nusa
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<?php do_action( 'head_begin_hook' ); ?>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php do_action( 'body_begin_hook' ); ?>

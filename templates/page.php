<?php
/**
 * Page view template.
 *
 * 🚫🚫🚫
 * DO NOT EDIT THIS FILE WHILE INSIDE THE PLUGIN! Changes You make will be lost when a new version
 * of the AMP plugin is released. You need to copy this file out of the plugin and put it into your
 * custom theme, for example. To learn about how to customize these Reader-mode AMP templates, please
 * see: https://amp-wp.org/documentation/how-the-plugin-works/classic-templates/
 * 🚫🚫🚫
 *
 * @package AMP
 */

/**
 * Context.
 *
 * @var AMP_Post_Template $this
 */

$this->load_parts( [ 'html-start' ] );
?>

<?php $this->load_parts( [ 'header' ] ); ?>

<article class="amp-wp-article">
	<header class="amp-wp-article-header">
		<h1 class="amp-wp-title"><?php the_title(); ?></h1>
	</header>

	<?php $this->load_parts( [ 'featured-image' ] ); ?>

	<div class="amp-wp-article-content">
		<?php the_content(); ?>
	</div>
</article>

<?php $this->load_parts( [ 'footer' ] ); ?>

<?php
$this->load_parts( [ 'html-end' ] );

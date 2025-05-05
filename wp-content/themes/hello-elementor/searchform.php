<?php
/**
 * The Template Part for displaying search form.
 *
 * @license For the full license information, please view the Licensing folder
 * that was distributed with this source code.
 *
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
?>

<div role="search" class="search-form-wrapper">
	<form method="get"
	      class="search-form"
	      action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label>
            <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label' ); ?></span>
            <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
		</label>
		<!-- <button class="search-submit"><?php echo esc_html( $bimber_searchform['submit_label'] ); ?></button> -->
        <input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button' ); ?>" />
	</form>
</div>

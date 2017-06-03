<?php
/**
 * @version    $Id$
 * @package    IG_Library
 * @author     InnoGears Team <support@innogears.com>
 * @copyright  Copyright (C) 2012 InnoGears.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.innogears.com
 */

/**
 * Fix error warning when of Woocommerce, when call Woocommerce in IG preview iframe
 */
if ( ! function_exists( 'woocommerce_reset_loop' ) ) {

	/**
	 * Reset the loop's index and columns when we're done outputting a product loop.
	 *
	 * @access public
	 * @subpackage	Loop
	 * @return void
	 */
	function woocommerce_reset_loop() {
		global $woocommerce_loop;
		// Reset loop/columns globals when starting a new loop
		$woocommerce_loop['loop'] = $woocommerce_loop['columns'] = '';
	}
}
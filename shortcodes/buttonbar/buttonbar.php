<?php
/**
 * @version    $Id$
 * @package    IG PageBuilder
 * @author     InnoGears Team <support@innogears.com>
 * @copyright  Copyright (C) 2012 innogears.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.innogears.com
 * Technical Support:  Feedback - http://www.innogears.com
 */

if ( ! class_exists( 'IG_Buttonbar' ) ) :

/**
 * Create a bar of buttons
 *
 * @package  IG PageBuilder Shortcodes
 * @since    1.0.0
 */
class IG_Buttonbar extends IG_Pb_Shortcode_Parent {
	/**
	 * Constructor
	 *
	 * @return  void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Configure shortcode.
	 *
	 * @return  void
	 */
	public function element_config() {
		$this->config['shortcode']        = strtolower( __CLASS__ );
		$this->config['name']             = __( 'Button Bar', IGPBL );
		$this->config['cat']              = __( 'Typography', IGPBL );
		$this->config['icon']             = 'icon-paragraph-text';
		$this->config['has_subshortcode'] = 'IG_Item_' . str_replace( 'IG_', '', __CLASS__ );

		// Define exception for this shortcode
		$this->config['exception'] = array(
			'default_content'  => __( 'Button Bar', IGPBL ),
			'data-modal-title' => __( 'Button Bar', IGPBL ),

			'frontend_assets' => array(
				// Bootstrap 3
				'ig-pb-bootstrap-css',
				'ig-pb-bootstrap-js',

				// Font IcoMoon
				'ig-pb-font-icomoon-css',

				// Fancy Box
				'ig-pb-jquery-fancybox-css',
				'ig-pb-jquery-fancybox-js',

				// Shortcode style
				'buttonbar_frontend.css',
			),
		);

		// Do not use Ajax to load element settings modal because this element has sub-item
		$this->config['edit_using_ajax'] = false;
	}

	/**
	 * Define shortcode settings.
	 *
	 * @return  void
	 */
	public function element_items() {
		$this->items = array(
			'content' => array(
				array(
					'name'    => __( 'Element Title', IGPBL ),
					'id'      => 'el_title',
					'type'    => 'text_field',
					'class'   => 'input-sm',
					'std'     => __( '', IGPBL ),
					'role'    => 'title',
					'tooltip' => __( 'Set title for current element for identifying easily', IGPBL )
				),
				array(
					'id' => 'buttonbar_items',
					'type' => 'group',
					'shortcode' => ucfirst( __CLASS__ ),
					'sub_item_type' => $this->config['has_subshortcode'],
					'sub_items' => array(
						array( 'std' => '' ),
						array( 'std' => '' ),
						array( 'std' => '' ),
					)
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'    => __( 'Alignment', IGPBL ),
					'id'      => 'buttonbar_alignment',
					'type'    => 'select',
					'class'   => 'input-sm',
					'std'     => IG_Pb_Helper_Type::get_first_option( IG_Pb_Helper_Type::get_text_align() ),
					'options' => IG_Pb_Helper_Type::get_text_align(),
					'tooltip' => __( 'Setting position: right, left, center, inherit parent style', IGPBL )
				),
				array(
					'name'    => __( 'Show Title', IGPBL ),
					'id'      => 'buttonbar_show_title',
					'type'    => 'radio',
					'std'     => 'yes',
					'options' => array( 'yes' => __( 'Yes', IGPBL ), 'no' => __( 'No', IGPBL ) ),
					'tooltip' => __( 'Show/ hide the title of buttons', IGPBL )
				),
				array(
					'name'    => __( 'Show Icon', IGPBL ),
					'id'      => 'buttonbar_show_icon',
					'type'    => 'radio',
					'std'     => 'yes',
					'options' => array( 'yes' => __( 'Yes', IGPBL ), 'no' => __( 'No', IGPBL ) ),
					'tooltip' => __( 'Show/ hide the icon of buttons', IGPBL )
				),
				array(
					'name'    => __( 'Group Buttons', IGPBL ),
					'id'      => 'buttonbar_group',
					'type'    => 'radio',
					'std'     => 'no',
					'options' => array( 'yes' => __( 'Yes', IGPBL ), 'no' => __( 'No', IGPBL ) ),
					'tooltip' => __( 'Arrange button bars into a group in a single row', IGPBL )
				),
			)
		);
	}

	/**
	 * Generate HTML code from shortcode content.
	 *
	 * @param   array   $atts     Shortcode attributes.
	 * @param   string  $content  Current content.
	 *
	 * @return  string
	 */
	public function element_shortcode_full( $atts = null, $content = null ) {
		$arr_params    = shortcode_atts( $this->config['params'], $atts );
		$html_element  = '';
		$sub_shortcode = IG_Pb_Helper_Shortcode::remove_autop( $content );
		$items = explode( '<!--seperate-->', $sub_shortcode );
		// remove empty element
		$items         = array_filter( $items );
		$initial_open  = ( ! isset($initial_open ) || $initial_open > count( $items ) ) ? 1 : $initial_open;
		foreach ( $items as $idx => $item ) {
			$open        = ( $idx + 1 == $initial_open ) ? 'in' : '';
			$items[$idx] = $item;
		}
		$sub_shortcode = implode( '', $items );
		$sub_htmls     = do_shortcode( $sub_shortcode );
		if ( $arr_params['buttonbar_show_title'] == 'no' ) {
			$pattern   = '\\[(\\[?)(title)(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
			$sub_htmls = preg_replace( '/' . $pattern . '/s', '', $sub_htmls );
		} else {
			$sub_htmls = str_replace( '[title]', '', $sub_htmls );
			$sub_htmls = str_replace( '[/title]', '', $sub_htmls );
		}
		if ( $arr_params['buttonbar_show_icon'] == 'no' ) {
			$pattern   = '\\[(\\[?)(icon)(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
			$sub_htmls = preg_replace( '/' . $pattern . '/s', '', $sub_htmls );
		} else {
			$sub_htmls = str_replace( '[icon]', '', $sub_htmls );
			$sub_htmls = str_replace( '[/icon]', '', $sub_htmls );
		}
		if ( $arr_params['buttonbar_group'] == 'no' ) {
			$html_element = $sub_htmls;
		} else {
			$html_element = "<div class='btn-group'>" . $sub_htmls . '</div>';
		}

		$cls_alignment = '';
		if ( strtolower( $arr_params['buttonbar_alignment'] ) != 'inherit' ) {
			if ( strtolower( $arr_params['buttonbar_alignment'] ) == 'left' )
				$cls_alignment = 'pull-left';
			if ( strtolower( $arr_params['buttonbar_alignment'] ) == 'right' )
				$cls_alignment = 'pull-right';
			if ( strtolower( $arr_params['buttonbar_alignment'] ) == 'center' )
				$cls_alignment = 'text-center';
		}
		$html_element = "<div class='btn-toolbar {$cls_alignment}'>{$html_element}</div>";

		return $this->element_wrapper( $html_element, $arr_params );
	}
}

endif;

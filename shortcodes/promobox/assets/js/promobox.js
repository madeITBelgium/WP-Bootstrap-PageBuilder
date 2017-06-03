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

/**
 * Custom script for PromoBox element
 */
( function ($) {
	"use strict";

	$.IGSelectFonts	= $.IGSelectFonts || {};

    $.IGColorPicker = $.IGColorPicker || {};

    $.IG_PromoBox = $.IG_PromoBox || {};

	$.IG_PromoBox = function () {
		new $.IGSelectFonts();
        new $.IGColorPicker();

		$('#param-title_font').on('change', function () {
			if ($(this).val() == 'inherit') {
				$('#control-action-title').css('top', '421px');
			} else {
				$('#control-action-title').css('top', '390.5px');
			}
		});
		$('#param-title_font').trigger('change');
	}

	$(document).ready(function () {
		$('body').bind('ig_after_popover', function (e) {
			$.IG_PromoBox();
		});
	});

})(jQuery);
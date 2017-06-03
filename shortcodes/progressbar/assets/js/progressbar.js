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
 * Custom script for ProgressBar element
 */
(function ($) {
	
	"use strict";
	
	$.IG_Progressbar = $.IG_Progressbar || {};
	
	$.IG_Progressbar = function () {
		$('#param-progress_bar_style').on('change', function () {
            var selectValue = $(this).val();
            
            if ( selectValue ) {
                var shortcodes = $('.jsn-item textarea');
                var total = 0;
                shortcodes.each(function () {
                    var shortcode_str = $(this).html();
                    var result 	= shortcode_str.replace(/pbar_group="[a-z\-]+"/g, 'pbar_group="' + selectValue + '"');
                    var match 	= shortcode_str.match(/\b([0-9]+)\b/g);
                    total += parseInt(match);
                    $(this).html(result);
                });
                
                // Progress total percentage
                if ( total > 100 ) {
                    shortcodes.each(function () {
                        var shortcode_str = $(this).html();
                        var match 	= shortcode_str.match(/\b([0-9]+)\b/g);
                        var percent = parseInt(match) / (total / 100);
                        var result 	= shortcode_str.replace(/pbar_percentage="[0-9]+"/g, 'pbar_percentage="' + percent + '"');
                        $(this).html(result);
                    });
                }
            }
            
        });
		
		$('#param-progress_bar_style').trigger('change');
	}
	
	$(document).ready(function () {
		$.IG_Progressbar();
	});
	
})(jQuery)
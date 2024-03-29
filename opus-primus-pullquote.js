/**
 * Opus Primus Pull Quote JavaScript
 *
 * @package     OpusPrimusPullQuotes
 * @since       1.0
 *
 * @author      Edward Caissie <edward.caissie@gmail.com>
 * @copyright   Copyright (c) 2012-2014, Edward Caissie
 *
 * This file is part of Opus Primus PullQuotes.
 *
 * Opus Primus PullQuotes is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License version 2, as
 * published by the Free Software Foundation.
 *
 * You may NOT assume that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to:
 *
 *      Free Software Foundation, Inc.
 *      51 Franklin St, Fifth Floor
 *      Boston, MA  02110-1301  USA
 *
 * The license for this software can also likely be found here:
 * http://www.gnu.org/licenses/gpl-2.0.html
 */

jQuery( document ).ready( function ( $ ) {
	/** Note: $() will work as an alias for jQuery() inside of this function */

	/** Pull Quotes on (default) right side */
	$( 'span.pq' ).each( function () {
		var $parentParagraph = $( this ).parent( 'p' );
		$parentParagraph.css( 'position', 'relative' );
		$( this ).clone()
			.addClass( 'pullquote' )
			.prependTo( $parentParagraph );
	} );

	/** Pull Quotes on left side */
	$( 'span.pql' ).each( function () {
		var $parentParagraph = $( this ).parent( 'p' );
		$parentParagraph.css( 'position', 'relative' );
		$( this ).clone()
			.addClass( 'pullquote-left' )
			.prependTo( $parentParagraph );
	} );

} );
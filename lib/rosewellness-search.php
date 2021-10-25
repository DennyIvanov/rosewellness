<?php
/**
 * Over-riding WordPress default search mechanism
 *
 * Support for Google Custom Search ( Bonus !!! )
 * 
 * @package rosewellness
 *
 */

/**
 * Rosewellness Custom Search Form
 *
 * @param string $form
 * @return string
 *
 */
function rosewellness_custom_search_form( $form ) {
    global $rosewellness_general, $is_chrome;
    $search_class = 'search-text';
    if ( preg_match( '/customSearchControl.draw\(\'cse\'(.*)\)\;/i', @$rosewellness_general["search_code"] ) ) {
        $search_class .= ' rosewellness-google-search';
        $placeholder = NULL;
    } else {
        $placeholder = 'placeholder="' . apply_filters( 'rosewellness_search_placeholder', __( 'Search Here...', 'rosewellness' ) ) . '" ';
    }
    $chrome_voice_search = ( $is_chrome ) ? ' x-webkit-speech="x-webkit-speech" speech="speech" onwebkitspeechchange="this.form.submit();"' : '';
    $form = '<form role="search" class="searchform" action="' . home_url( '/' ) . '">
                <div><label class="hidden">' . __( 'Search for:', 'rosewellness' ) . '</label>
                    <input type="search" required="required" ' . $placeholder . 'value="' . esc_attr( apply_filters( 'the_search_query', get_search_query() ) ).'" name="s" class="' . $search_class . '" title="' . apply_filters( 'rosewellness_search_placeholder', __( 'Search Here...', 'rosewellness' ) ). '"' . $chrome_voice_search . ' />
                    <input type="submit" class="searchsubmit" value="' . esc_attr( __( 'Search', 'rosewellness' ) ) . '" title="Search" />
                </div>
             </form>';
    return $form;
}
add_filter( 'get_search_form', 'rosewellness_custom_search_form' );


/* Customizing URLs, when using Google Custom Search */
if( is_search() ) {
    $result_url = get_site_url( '', '?s=' );
        header( 'Location:' . $result_url . $s );
    exit;
}
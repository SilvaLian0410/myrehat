<?php
/**
 * Change the Focus Keyword Limit
 */
add_filter( 'rank_math/focus_keyword/maxtags', function() {
    return 20; // Number of Focus Keywords. 
});
?>
<?php

use Ladmin\Engine\Helpers\Ladmin;

if( ! function_exists('ladmin') ) {
    function ladmin () {
        return new Ladmin();
    }
}
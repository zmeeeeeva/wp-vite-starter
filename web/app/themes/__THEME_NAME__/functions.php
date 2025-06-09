<?php

use WpApp\Setup;

if (WP_ENV !== 'development') {

}

foreach (glob(__DIR__ . '/lib/*.php') as $filename) {
    include $filename;
}

foreach (glob(__DIR__ . '/inc/*.php') as $filename) {
    include $filename;
}

$app = new Setup();

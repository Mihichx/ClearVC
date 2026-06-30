<?php
return [
    ['/', 'HomeController@index'],
    ['/about', 'AboutController@about'],
    ['*', 'DYNAMIC_MODULES_FALLBACK'],
    ['*', 'DYNAMIC_MODULES_FALLBACK', 'POST'],
];
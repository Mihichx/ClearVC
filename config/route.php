<?php

return [
    ['/', 'PageController@index'],
    ['/docs', 'PageController@docs'],
    ['/routes', 'PageController@routes'],
    ['*', 'DYNAMIC_MODULES_FALLBACK'],
    ['*', 'DYNAMIC_MODULES_FALLBACK', 'POST'],
];

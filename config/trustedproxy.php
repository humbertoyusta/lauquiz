<?php

return [
    'proxies' => ( config('app.env') === 'local' ) ? '*' : '',
];

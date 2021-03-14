<?php

return [
    'enabled' => (bool) env('CHECK_ENABLED', true),
    'interval' => (int) env('CHECK_INTERVAL', 30),
    'timeout' => (int) env('CHECK_TIMEOUT', 5),
];

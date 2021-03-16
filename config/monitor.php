<?php

return [

    /** App version */
    'version' => '1.0.0',

    /** Enable/disable automatic service checks */
    'enabled' => (bool) env('CHECK_ENABLED', true),

    /** How often to check services are online in seconds */
    'interval' => (int) env('CHECK_INTERVAL', 30),

    /** HTTP timeout in seconds before marking job as failed */
    'timeout' => (int) env('CHECK_TIMEOUT', 5),

];

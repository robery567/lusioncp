<?php

/**
 * LusionCP Database variables
 */

$database = [
  'cache' => [
    'driver' => 'sqlite',
    'database' => LCP_XAPP.'/safelocker/lcp_cache.db',
  ],
  'appdb' => [
    'driver' => 'mysql',
    'hostname' => 'localhost',
    'username' => 'lcp_cdevel',
    'password' => 'Hg7RvOqZdH',
    'database' => 'lcp_client',
    'xcharset' => 'utf8',
  ],
];

<?php

/**
 * LusionCP Definitions file
 * @author Petru
 */

// FIXME: make PHP get the real hostname from $_SERVER
$hostname = isset($_SERVER) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');

$lcpdeflist = [
  'lcp_root' => __DIR__,
  'lcp_conf' => __DIR__.'/conf',
  'lcp_mail' => __DIR__.'/mail',
  'lcp_temp' => __DIR__.'/tmp',
  'lcp_xweb' => __DIR__."/web/{$hostname}",
  'lcp_libs' => __DIR__."/web/{$hostname}/private/vendor",
  'lcp_xapp' => __DIR__."/web/{$hostname}/private/lusioncp",
  'lcp_core' => __DIR__."/web/{$hostname}/private/lcpcore",
];

if (is_array($lcpdeflist)) {
  foreach ($lcpdeflist as $key => $value) {
    define(strtoupper($key), $value);
  }
}

require_once LCP_CONF.'/web/lusioncp.php';
require_once LCP_CONF.'/lcp/database.php';
require_once LCP_CONF.'/lcp/license.php';

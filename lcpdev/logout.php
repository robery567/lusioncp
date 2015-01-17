<?php

require __DIR__ . '/../../private/app/boot/start.php';

session_unset();
session_destroy();

header("Location: index.php");
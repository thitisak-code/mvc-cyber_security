<?php
require __DIR__ . '/includes/db.php';

session_unset();
session_destroy();
redirect('index.php');

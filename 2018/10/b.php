<?php
require 'common.php';
list($time, $lights) = move_to_minimal_area($lights);
echo "Time $time\n";
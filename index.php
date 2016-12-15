<?php
echo "hello heroku";
file_put_contents('log.txt', date('H:i:s'));

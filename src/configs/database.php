<?php

ORM::configure('sqlite:' . 'db/app.db',  null, 'app');
ORM::configure('return_result_sets', true);
ORM::configure('error_mode', PDO::ERRMODE_WARNING);
ORM::configure('logging', true);

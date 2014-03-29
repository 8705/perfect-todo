<?php

        $database     = 'perfect_todo';
        $user         = 'perfect_user';
        $password     = 'perfect_pswd';

        $this->db_manager->connect('master', array(
            'dsn'      => 'mysql:dbname='.$database.';host=localhost',
            'user'     => $user,
            'password' => $password,
        ));

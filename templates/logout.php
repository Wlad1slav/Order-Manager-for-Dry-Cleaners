<?php
unset($_SESSION['user']['id']);
Router::redirect('/login');
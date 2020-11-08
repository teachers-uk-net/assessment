<?php
//$session_lifetime = 3600 * 24 * 2; // 2 days
$session_lifetime = 3600; // 1 hour
session_set_cookie_params ($session_lifetime);
session_start();
class Sesh
{

}
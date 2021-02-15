<?php


function logged_in()
{
    $ci = get_instance();
    if ($ci->session->userdata('email')) {
        return true;
    } else {
        return false;
    }
}

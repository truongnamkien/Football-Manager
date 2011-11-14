<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config['admin_roles'] = array(
    Admin_Model::ADMIN_ROLE_ADMIN => 'Admin',
    Admin_Model::ADMIN_ROLE_MODERATOR => 'Moderator',
);
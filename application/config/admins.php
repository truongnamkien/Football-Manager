<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config['admin_roles'] = array(
    Admin_Model::ADMIN_ROLE_ADMIN => 'Admin',
    Admin_Model::ADMIN_ROLE_MODERATOR => 'Moderator',
);
$config['user_status'] = array(
    User_Model::USER_STATUS_INACTIVE => 'Inactive',
    User_Model::USER_STATUS_ACTIVE => 'Active',
    User_Model::USER_STATUS_RECOVERY_PASSWORD => 'Recovery password',
);
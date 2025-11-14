<?php
$user_role=$this->session->get('user_role'); 
$admin_id=$this->session->get('admin_id');
$user_id=$this->session->get('id');
// $user_id=$this->session->get('user_id');
$username=$this->session->get('username');
$useremail=$this->session->get('useremail');
$employee_name=$this->session->get('employee_name');
$profile_image=$this->session->get('profile_image');
?>
<body class="fix-header">
    <!-- ============================================================== -->
    <!-- Preloader -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    
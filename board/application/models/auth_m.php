<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
Class Auth_m extends CI_Model {
    function __construct() {
        parent::__construct();
    }
 
    /**
     * 아이디 비밀번호 체크
     */
    function login($auth) {
        $sql = "SELECT user_id, email FROM users WHERE user_id = '" . $auth['user_id'] . "' AND password = '" . $auth['password'] . "' ";
 
        $query = $this->db->query($sql);
 
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }
 
}


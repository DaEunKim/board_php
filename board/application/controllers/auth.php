<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
/**
 * 사용자 인증 컨트롤러
 */
 
class Auth extends CI_Controller {
 
    function __construct() {
        parent::__construct();
        $this->load->model('auth_m');
        $this->load->helper('form');
    }
 
    public function index() {
        $this->login();
    }
 
    public function _remap($method) {
        $this->load->view('header_v');
 
        if (method_exists($this, $method)) {
            $this->{"{$method}"}();
        }
 
        $this->load->view('footer_v');
    }
 
    /**
     * 로그인 처리
     */
    public function login() {
        $this->load->library('form_validation');
 
        $this->load->helper('alert');
 
        $this->form_validation->set_rules('user_id', '아이디', 'required|alpha_numeric');
        $this->form_validation->set_rules('password', '비밀번호', 'required');
 
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
 
        if ($this ->form_validation -> run() == TRUE) {
            $auth_data = array(
                'user_id' => $this->input->post('user_id', TRUE),
                'password' => $this->input->post('password', TRUE)
            );
            
            $result = $this ->auth_m->login($auth_data);
            
            if ($result) {
                $newdata = array(
                    'user_id' => $result->user_id,
                    'email' => $result->email,
                    'logged_in' => TRUE
                );
                
                $this->session->set_userdata($newdata);
                
                alert('로그인 되었습니다.', '/board/index.php/board/lists/board/page/1');
                exit;
            } else {
                alert('아이디나 비밀번호를 확인해 주세요.', '/board/index.php/board/lists/board/page/1');
                exit;
            }
        } else {
            $this -> load -> view('auth/login_v');
        }
    }
 
    public function logout() {
        $this->load->helper('alert');
        
        $this->session->sess_destroy();
        
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        alert('로그아웃 되었습니다.', '/board/index.php/board/lists/board/page/1');
        exit;
        
    }
 
}

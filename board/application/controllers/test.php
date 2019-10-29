<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 *  기타 테스트용 컨트롤러
 */
 
class Test extends CI_Controller {
 
    function __construct() {
        parent::__construct();
    }
 
    public function index() {
        $this -> forms();
    }
 
    public function _remap($method) {
        $this -> load -> view('header_v');
 
        if (method_exists($this, $method)) {
            $this -> {"{$method}"}();
        }
 
        $this -> load -> view('footer_v');
    }
    
    /**
     * 폼 검증 테스트
     */
    public function forms() {
        // $this->output->enable_profiler(TRUE);
        
        // Form validation 라이브러리 로드
        $this->load->library('form_validation');
        
        // 폼 검증 필드와 규칙 사전 정의
        $this->form_validation->set_rules('user_id', '아이디', 'callback_user_id_check');        
        $this->form_validation->set_rules('password', '비밀번호', 'required|matches[passconf]');        
        $this->form_validation->set_rules('passconf', '비밀번호 확인', 'required');        
        $this->form_validation->set_rules('email', '이메일', 'required|valid_email');        
        $this->form_validation->set_rules('count', '기본 값', 'numeric');
        $this->form_validation->set_rules('myselect', 'select 값', '');
        $this->form_validation->set_rules('mycheck[]', '체크 박스 값', '');
        $this->form_validation->set_rules('myradio', '라디오 버튼 값', '');
        
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('test/forms_v');
        } else {
            $this->load->view('test/form_success_v');
        }
    }
    
    public function user_id_check($id) {
        $this->load->database();
        
        if ($id) {
            $result = array();
            $sql = "SELECT * FROM users WHERE user_id = '".$id."'";
            $query = $this->db->query($sql);
            $result = @$query->row();
            
            if ($result) {
                $this->form_validation->set_message('user_id_check', $id.'은(는) 중복된 아이디 입니다.');
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }
 
}

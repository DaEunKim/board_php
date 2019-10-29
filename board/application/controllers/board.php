<?php
$rootURL = "/board/index.php/board";
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 *  게시판 메인 컨트롤러
 */
 // 플랫폼에 대한 이해 좀더
// 세션 동작 원리 

class Board extends CI_Controller {
 
    
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('board_m');
        $this->load->helper(array('url', 'date'));
        $this->load->helper('form');

    }
 
    /**
     * 주소에서 메서드가 생략되었을 때 실행되는 기본 메서드
     */
    public function index() {
        $this->lists();
    }
 
    /**
     * 사이트 헤더, 푸터가 자동으로 추가된다.
     */
    public function _remap($method) {
        // 헤더 include
        $this->load->view('header_v');
 
        if (method_exists($this, $method)) {
            $this -> {"{$method}"}();
        }
 
        // 푸터 include
        $this->load->view('footer_v');
    }

    // 디비 수정날찌, 시간은 디비가 알아서 해주는거로, 보안,  XSS 필터링ss
    /**
     * 목록 불러오기
     */
    public function lists() {
        // 페이지네이션 라이브러리 로딩
        $uri_segment = 5;
        // 페이지 네이션 설정
        $this->load->library('pagination');
        // 페이징 주소
        $config['base_url'] = $GLOBALS['rootURL'].'/lists/board/page';
        // 게시물 전체 개수
        $config['total_rows'] = $this->board_m->get_list($this->uri->segment(3), 'count');
        // 한 페이지에 표시할 게시물 수
        $config['per_page'] = 5; 
        // 페이지 번호가 위치한 세그먼트
        $config['uri_segment'] = $uri_segment; 
        // 페이지네이션 초기화
        $this->pagination->initialize($config);
        // 페이지 링크를 생성하여 view에서 사용하 변수에 할당
        $data['pagination'] = $this->pagination->create_links();
        // 게시물 목록을 불러오기 위한 offset, limit 값 가져오기
        $page = $this->uri->segment($uri_segment, 1);
 
        if ($page > 1) {
            $start = (($page / $config['per_page'])) * $config['per_page'];
        } else {
            $start = ($page - 1) * $config['per_page'];
        }
 
        $limit = $config['per_page'];
 
        $data['list'] = $this->board_m->get_list($this->uri->segment(3), '', $start, $limit);
        $data['list_count'] = $this->board_m->get_list($this->uri->segment(3), 'count'); // 총 row 갯수
        $data['page_count'] = $config['per_page']; // page당 표시할 게시물 수 
        $data['cur_page'] = $start/$config['per_page']; // 현재 page num
        
        $this->load->view('board/list_v', $data); // 변수명 더 클린하게
    }

    /**
     * url 중 키 값을 구분하여 값을 가져오도록
     */
    function url_explode($url, $key) {
        $cnt = count($url);
        for ($i = 0; $i < $cnt-1; $i++) {
            if ($url[$i] == $key) {
                $k = $i + 1;
                return $url[$k];
            }
        }
    }
 
    /**
     * HTTP의 URL을 "/"를 Delimiter로 사용하여 배열로 바꿔 리턴
     */
    function segment_explode($seg) {
        // 세그먼트 앞 뒤 "/" 제거 후 uri를 배열로 반환
        $len = strlen($seg);
        if (substr($seg, 0, 1) == '/') {
            $seg = substr($seg, 1, $len);
        }
        $len = strlen($seg);
        if (substr($seg, -1) == '/') {
            $seg = substr($seg, 0, $len - 1);
        }
        $seg_exp = explode("/", $seg);
        return $seg_exp;
    }
    
    /** 게시물 상세보기 */
    function view() {
        // 게시판 이름과 게시물 번호에 해당하는 게시물 가져오기
        $table = $this->uri->segment(3);
        $board_id = $this->uri->segment(4);

        /** 게시판 */
        $data['views'] = $this->board_m->get_view($table, $this->uri->segment(4));

        /** 댓글 */        
        $data['comment_list'] = $this->board_m->get_comment("comment", $board_id);

        // view 호출
        $this->load->view('board/view_v', $data);
    }


    /** 글쓰기 */
    function write() {
        $this->load->helper('alert');
        echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />';

        if (@$this->session->userdata('logged_in') == TRUE) {
            $this->load->library('form_validation');
            // 폼 검증할 필드와 규칙 사전 정의
            $this->form_validation->set_rules('title', '제목', 'required');
            $this->form_validation->set_rules('contents', '내용', 'required');

            if ( $this->form_validation->run() == TRUE) {
                // 주소 중에서 page 세그먼트가 있는지 검사하기 위해 주소를 배열로 반환
                $uri_array = $this->segment_explode($this->uri->uri_string());
     
                if (in_array('page', $uri_array)) {
                    $pages = urldecode($this->url_explode($uri_array, 'page'));
                } else {
                    $pages = 1;
                }
     
                if (!$this->input->post('title', TRUE) AND !$this->input->post('contents', TRUE)) {
                    // 글 내용이 없을 경우, 프로그램 단에서 한 번 더 체크
                    alert('비정상적인 접근입니다.', $GLOBALS['rootURL'].'/lists/'.$this->uri->segment(3).'/page/'.$pages);
                    exit ;
                }
    
                $write_data = array(
                    'title' => $this->input->post('title', TRUE), 
                    'contents' => $this->input->post('contents', TRUE), 
                    'table' => $this->uri-> segment(3)
                );
     
                $result = $this->board_m->insert_board($write_data);
                
                if ($result) {
                    alert("입력되었습니다.", $GLOBALS['rootURL'].'/lists/'.$this->uri->segment(3).'/page/'.$pages);
                    exit;
                } else {
                    alert("다시 입력해주세요." , $GLOBALS['rootURL'].'/lists/'.$this->uri->segment(3).'/page/'.$pages);
                    exit;
                }
            } else {
                // 쓰기 폼 view 호출
                $this->load->view('board/write_v');
            }
        } else {
            alert('로그인 후 작성하세요', '/board/index.php/auth/login/');
            exit;
        }

    }

    /** 게시물 수정하기 */
    function modify() {
        $this->load->helper('alert');
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        
        $uri_array = $this->segment_explode($this->uri->uri_string());
        if ( in_array('page', $uri_array)) {
            $pages = urldecode($this->url_explode($uri_array, 'page'));
        } else {
            $pages = 1;
        }

        if ( @$this->session->userdata['logged_in'] == TRUE) {
            $write_id = $this->board_m->writer_check();
            
            if ( $write_id->user_id != $this->session->userdata('user_id')) {
                alert('본인이 작성한 글이 아닙니다.', $GLOBALS['rootURL'].'/view/'.$this->uri->segment(3).'/'.$this->uri->segment(5).'/page/'.$pages);
                exit;
                
            }
            
            $this->load->library('form_validation');
            
            // 폼 검증할 필드와 규칙 사전 정의
            $this->form_validation->set_rules('title', '제목', 'required');
            $this->form_validation->set_rules('contents', '내용', 'required');
            
            if ( $this->form_validation->run() == TRUE) {
                if ( !$this->input->post('title', TRUE) AND !$this->input->post('contents', TRUE)) {
                    alert('비정상적인 접근입니다.', $GLOBALS['rootURL'].'/lists/'.$this->uri->segment(3).'/page/'.$pages);
                    exit;
                }
                $modify_data = array(
                    'table' => $this->uri->segment(3), 
                    'board_id' => $this->uri->segment(5), 
                    'title' => $this->input->post('title', TRUE), 
                    'contents' => $this->input->post('contents', TRUE)
                );
                
                $result = $this->board_m->modify_board($modify_data);
                
                if ( $result ) {
                    alert('수정되었습니다.', $GLOBALS['rootURL'].'/lists/'.$this->uri->segment(3).'/page/'.$pages);
                    exit;
                } else {
                    alert('다시 수정해 주세요.', $GLOBALS['rootURL'].'/view/'.$this->uri->segment(3).'/board_id/'.$this->uri->segment(5).'/page/'.$pages);
                    exit;
                }
            } else {
                $data['views'] = $this->board_m->get_view($this->uri->segment(3), $this->uri->segment(5));
                $this->load->view('board/modify_v', $data);
            } 
        }else {
            alert('로그인 후 수정하세요', '/board/index.php/auth/login/');
            exit;
        }

    }

    /** 게시물 삭제 */
    function delete() {

        $this->load->helper('alert');
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
 
        if ( @$this->session->userdata('logged_in') == TRUE) {
            $writer_id = $this->board_m->writer_check();
            
            if ( $writer_id->user_id != $this->session->userdata('user_id')) {
                alert('본인이 작성한 글이 아닙니다.', $GLOBALS['rootURL'].'/view/'.$this->uri->segment(3).'/'.$this->uri->segment(5).'/page/'.$pages);
                exit;
            }
            
            $return = $this->board_m->delete_content($this->uri->segment(3), $this->uri->segment(5));
            
            if ($return) {
                alert('삭제되었습니다.', $GLOBALS['rootURL'].'/lists/'.$this->uri->segment(3).'/page/'.$this->uri->segment(7));
                exit ;
            } else {
                alert('삭제 실패하였습니다.', $GLOBALS['rootURL'].'/view/'.$this->uri->segment(3).'/board_id/'.$this->uri->segment(5).'/page/'.$this->uri->segment(7));
                exit ;
            }
            
        } else {
            alert('로그인 후 삭제하세요.', '/board/index.php/auth/login/');
            exit;
        }
    }

}
?>
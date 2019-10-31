<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
/**
 * AJAX 처리 컨트롤러
 * POST 전송된 댓글 내용, 테이블 명, 테이블 번호를 이용해 데이터베이스에 입력하고, 
 * 입력된 결과를 HTML 형태로 만들어서 화면에 출력합니다.
 */
 
class Ajax_board extends CI_Controller {
 
    function __construct() {
        parent::__construct();
    }
 
    /**
     * AJAX 테스트
     */
    public function test() {
        $this->load->view('ajax/test_v');
    }
 
    public function ajax_action() {
        echo '<meta http-equiv="Content-Type" content="test/html; charset=utf-8" />';
 
        $name = $this->input->post("name");
 
        echo $name . "님 반갑습니다 !";
    }
 
    public function ajax_comment_add() {
        if (@$this->session->userdata('logged_in') == TRUE) {
            $this->load->model('board_m');
            
            $table = $this->input->post('table', TRUE);
            $board_pid = $this->input->post('board_pid', TRUE);
            $comment_contents = $this->input->post('comment_contents', TRUE);
            
            if ($comment_contents != '' ){
                $write_data = array(
                    "table" => $table,
                    "board_pid" => $board_pid,
                    "contents" => $comment_contents,
                    "user_id" => $this->session->userdata('user_id')
                );
                
                $result = $this->board_m->insert_comment($write_data);
                
                if ($result) {
                    $sql = "SELECT * FROM ". $table ." WHERE board_pid = '". $board_pid . "' ORDER BY comment_id DESC";
                    $query = $this->db->query($sql);
                    
?>
<table cellspacing="0" cellpadding="0" class="table table-striped">
    <tbody>
<?php
                    foreach ($query->result() as $lt) {
?>
        <tr>
            <th scope="row">
                <?php echo $lt->user_id;?>
            </th>
            <td><?php echo $lt->contents;?></td>
            <td><?php echo $lt->reg_date;?></td>
            <td>
                <a href="#" class="comment_delete" vals="<?php echo $lt->comment_id; ?>">
                    삭제
                </a>
            </td>
            
        </tr>
<?php
                    }
?>
    </tbody>
</table>
<?php
                } else {
                    // 글 실패시
                    echo "2000";
                }
            } else {
                // 글 내용이 없을 경우
                echo "1000";
            }
        } else {
            // 로그인 필요 에러
            echo "9000";
        }
    }
 
    public function ajax_comment_delete() {
        if ( @$this->session->userdata('logged_in') == TRUE) {
            $this->load->model('board_m');
            
            $table = "comment";
            $comment_id = $this->input->post('comment_id', TRUE);
            
            $writer_id = $this->board_m->writer_check2($table, $comment_id);
            
            if ( $writer_id->user_id != $this->session->userdata('user_id')) {
                echo "8000"; 
            } else {
                $result = $this->board_m->delete_comment($table, $comment_id);
                
                if ($result) {
                    echo $comment_id;
                } else {
                    echo "2000"; // 글 실패
                }
            }
        } else {
            echo "9000"; // 로그인 에러
        }
    }


    public function ajax_recomment_add() {
        if (@$this->session->userdata('logged_in') == TRUE) {
            $this->load->model('board_m');
            
            $table = $this->input->post('table', TRUE);
            $board_pid = $this->input->post('board_pid', TRUE);
            $recomment_contents = $this->input->post('recomment_contents', TRUE);
            $comment_id = $this->input->post('comment_id', TRUE);

            if ($recomment_contents != '' ){
                $write_data = array(
                    "table" => $table,
                    "board_pid" => $board_pid,
                    "contents" => $recomment_contents,
                    "user_id" => $this->session->userdata('user_id'),
                    "depth" => 1,
                    "parent_id" => $comment_id
                );
                
                $result = $this->board_m->insert_recomment($write_data);
                
                if ($result) {
                    $sql = "SELECT * FROM ". $table ." WHERE board_pid = '". $board_pid . "' ORDER BY comment_id DESC";
                    $query = $this->db->query($sql);
                    
?>
<table cellspacing="0" cellpadding="0" class="table table-striped">
    <tbody>
<?php
                    foreach ($query->result() as $lt) {
?>
        <tr>
            <th scope="row">
                <?php echo $lt->user_id;?>
            </th>
            <td><?php echo $lt->contents;?></td>
            <td><?php echo $lt->reg_date;?></td>
            <td>
                <a href="#" class="comment_delete" vals="<?php echo $lt->comment_id; ?>">
                    삭제
                </a>
            </td>
            
        </tr>
<?php
                    }
?>
    </tbody>
</table>
<?php
                } else {
                    // 글 실패시
                    echo "2000";
                }
            } else {
                // 글 내용이 없을 경우
                echo "1000";
            }
        } else {
            // 로그인 필요 에러
            echo "9000";
        }
    }
 

}
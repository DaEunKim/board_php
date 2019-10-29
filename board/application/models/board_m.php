<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
/**
 * 게시판 모델
 */
 
class Board_m extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function get_list($table = 'board', $type = '', $offset = '', $limit = '') {
        $limit_query = '';
        // 페이징 처리
        if ($limit != '' OR $offset != '') {
            $limit_query = ' LIMIT ' . $offset . ', ' . $limit;
        }
        
        $sql ="SELECT * FROM " .$table. " ORDER BY board_id DESC " . $limit_query.";";
        $query = $this->db->query($sql);
        
        if ($type == 'count') {
            $result = $query->num_rows();
            
        } else {
            $result = $query->result();
        }
        return $result;
    }

    /**
     * 게시물 상세보기
     */
    function get_view($table, $id) {
        // 조횟수 증가
        $sql0 = "UPDATE " . $table . " SET hits = hits + 1 WHERE board_id='" . $id . "'";
        $this->db->query($sql0);
        $sql = "SELECT * FROM " . $table . " WHERE board_id = '" . $id . "'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    /**
     * 글쓰기
     */
    function insert_board($arrays) {
        $insert_array = array(
            'user_id' => 'dani717',
            'user_name' => '다은',
            'title' => $arrays['title'],
            'contents' => $arrays['contents'],
            'reg_date' => date("Y-m-d H:i:s")
        );
        $result = $this->db->insert($arrays['table'], $insert_array);
        return $result;
    }

    /**
     * 게시물 수정
     */
    function modify_board($arrays) {
        $modify_array = array(
            'title' => $arrays['title'],
            'contents' => $arrays['contents']
        );
        $where = array(
            'board_id' => $arrays['board_id']
        );
        $result = $this->db->update($arrays['table'], $modify_array, $where);
        return $result;
    }

    /**
     * 게시물 삭제
     */
    function delete_content($table, $no) {
        $delete_array = array(
            'board_id' => $no
        );
        $result = $this->db->delete($table, $delete_array);
        echo $this->db->last_query();
        return $result;
    }

    
    
    /**
     * 게시물 작성자 아이디 반환
     */
    function writer_check() {
        $table = $this->uri->segment(3); //파라미터로 , 예외처리도 
        $board_id = $this->uri->segment(5);
        
        $sql = "SELECT user_id FROM ".$table." WHERE board_id = '".$board_id."'";
        $query = $this->db->query($sql);
        
        return $query->row();
        
    }

    function writer_check2($table, $comment_id) {
        $sql = "SELECT user_id FROM ".$table." WHERE comment_id = '".$comment_id."'";
        $query = $this->db->query($sql);
        
        return $query->row();
        
    }
    /**
     * 댓글 입력
     */
    function insert_comment($arrays) {
        $insert_array = array( 
            'board_pid' => $arrays['board_pid'],
            'user_id' => $arrays['user_id'],
            'user_name' => $arrays['user_id'],
            'contents' => $arrays['contents'],
            'reg_date' => date('Y-m-d H:i:s')
        );
        
        $this->db->insert($arrays['table'], $insert_array);
        
        $board_id = $this->db->insert_id();
        
        return $board_id;
    }
    
    /**
     * 댓글 리스트 가져오기
     */
    function get_comment($table , $id) {
        $sql = "SELECT * FROM ". $table . " WHERE board_pid = '". $id . "' ORDER BY comment_id DESC";
        $query = $this->db->query($sql);
        
        $result = $query->result();
        
        return $result;
    }
    /**
     * 댓글 삭제
     */
    function delete_comment($table, $comment_id) {
        $delete_array = array(
            'comment_id' => $comment_id
        );
        $result = $this->db->delete($table, $delete_array);
        echo $this->db->last_query();
        return $result;
    }

}
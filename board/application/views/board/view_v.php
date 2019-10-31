<?php $rootURL = "/board/index.php/board"; ?>

<article style="text-align:center;" id="board_area">
<header><h1></h1></header>
<table cellspacing="0" cellpadding="0" class="table table-striped">
<thead>
    <tr><th scope="col">제목 : <?php echo $views->title; ?></th></tr>
    <tr>
        <th scope="col">작성자: <?php echo $views->user_id; ?></th>
        <th scope="col">조회수: <?php echo $views->hits; ?></th>
        <th scope="col">작성일: <?php echo $views->reg_date; ?></th>
    </tr>
</thead>
<tbody>
    <tr>
        <th colspan="4">
            <?php echo $views->contents;?>
        </th>
    </tr>
    
     
    
</tbody>
<tfoot>
    <tr>
        <th colspan="4">
            <a href="<?php echo $rootURL.'/lists/'.$this->uri->segment(3).'/page/'.$this->uri->segment(7); ?>" class="btn btn-primary"> 목록 </a>
            <a href="<?php echo $rootURL.'/modify/'.$this->uri->segment(3).'/board_id/'.$this->uri->segment(4).'/page/'.$this->uri->segment(7); ?>" class="btn btn-warning"> 수정 </a>
            <a href="<?php echo $rootURL.'/delete/'.$this->uri->segment(3).'/board_id/'.$this->uri->segment(4).'/page/'.$this->uri->segment(7); ?>" class="btn btn-danger"> 삭제 </a>
            <a href="<?php echo $rootURL.'/write/'.$this->uri->segment(3).'/page/'.$this->uri->segment(7); ?>" class="btn btn-success"> 쓰기 </a>                    
        </th>
    </tr>
</tfoot>
</table>

<!-- 댓글 -->
<?php $this->load->view('board/comment_v'); ?>

</article>
<footer></footer>

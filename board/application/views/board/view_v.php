<?php $rootURL = "/board/index.php/board"; ?>
<script>
$(function() {
        $("#comment_add").click(function () {
            $.ajax({
                url: "/board/index.php/ajax_board/ajax_comment_add",
                type: "POST",
                data: {
                    "comment_contents": encodeURIComponent($("#input01").val()),
                    "csrf_test_name": getCookie('csrf_cookie_name'),
                    "table": "comment",
                    "board_pid": "<?php echo $this->uri->segment(4); ?>"
                },
                dataType: "html",
                complete: function(xhr, textStatus) {
                    if (textStatus == 'success') {
                        if (xhr.responseText == 1000) {
                            alert('댓글 내용을 입력하세요.');
                        } else if (xhr.responseText == 2000) {
                            alert('다시 입력하세요.');
                        } else if (xhr.responseText == 9000) {
                            alert('로그인해야 합니다.');
                        } else {
                            // alert($("#comment_area").html());
                            $("#comment_area").html(xhr.responseText);
                            $("#input01").val('');
                            document.location.reload();
                        }
                    }
                }
            });
        });
        $(".comment_delete").click(function() {
            $.ajax({
                url: '/board/index.php/ajax_board/ajax_comment_delete',
                type: 'POST',
                data: {
                    "csrf_test_name": getCookie('csrf_cookie_name'),
                    "table" : "comment",
                    "comment_id": $(this).attr("vals")
                },
                dataType: "text",
                complete: function(xhr, textStatus) {
                    if (textStatus == 'success') {
                        if (xhr.responseText == 9000) {
                            alert('로그인해야합니다.');
                        } else if (xhr.responseText == 8000) {
                            alert('본인의 댓글만 삭제할 수 있습니다.');
                        } else if (xhr.responseText == 2000) {
                            alert('다시 삭제하세요.');
                        } else {
                            $('#row_num_' + xhr.responseText[45] + xhr.responseText[46]).remove();
                            alert('삭제되었습니다.');
                            document.location.reload();
                        }
                    }
                }
            });
        });
    });
    
    function getCookie(name) {
        var nameOfCookie = name + "=";
        var x = 0;
        
        while ( x <= document.cookie.length) {
            var y = (x + nameOfCookie.length);
            
            if (document.cookie.substring(x, y) == nameOfCookie) {
                if (( endOfCookie = document.cookie.indexOf(";", y)) == -1) 
                    endOfCookie = document.cookie.length;
                
                return unescape(document.cookie.substring(y, endOfCookie));
            }
            
            x = document.cookie.indexOf(" ", x) + 1;
            
            if ( x == 0) 
            
            break;
        }
    }

</script>
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
    
     <?php #$this->load->view('board/comment_v'); ?>
    
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

<form class="form-horizontal" method="POST" action="" name="com_add">
        <fieldset>
            <div class="control-group">
                <label class="control-label" for="input01">댓글</label>
                <div class="controls">
                    <textarea class="form-control" id="input01" name="comment_contents" rows="3"></textarea>
                    <div style="text-align:right;"><input class="btn btn-primary" type="button" id="comment_add" value="작성" /></div>
                    <p class="help-block"></p>
                </div>
            </div>
        </fieldset>
    </form>
    <div id="comment_area">
        <table cellspacing="0" cellpadding="0" class="table table-striped">
            <tbody>
<?php
    foreach ($comment_list as $lt) {
?>
                <tr id="row_num_<?php echo $lt->comment_id; ?>">
                    <th scope="row">
                        <?php echo $lt->user_id;?>
                    </th>
                    <td><?php echo $lt->contents;?></a></td>
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
    </div>

</article>
<footer></footer>

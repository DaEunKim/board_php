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
                            $("#comment_area").html(xhr.responseText);
                            $("#input01").val('');
                            document.location.reload();
                        }
                    }
                }
            });
        });
        $("#comment_delete").click(function() {
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
                            alert('삭제되었습니다.');
                            document.location.reload();
                            $('#row_num_' + xhr.responseText).remove();
                        }
                    }
                }
            });
        });

        $("#recomment_add").click(function(){
            $.ajax({
                url:"/board/index.php/ajax_board/ajax_recomment_add",
                type:"POST",
                data:{
                    "recomment_contents" : encodeURIComponent($("#input_recomment").val()),
                    "csrf_test_name": getCookie('csrf_cookie_name'),
                    "table": "comment",
                    "board_pid": "<?php echo $this->uri->segment(4); ?>",
                    "comment_id": $(this).attr("vals")
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
                            $("#comment_area").html(xhr.responseText);
                            $("#input_recomment").val('');
                            document.location.reload();
                        }
                    }
                }
            });
        });

        $("#recomment_delete").click(function() {
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
                            alert('삭제되었습니다.');
                            document.location.reload();
                            $('#row_num_' + xhr.responseText).remove();
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

<!-- 댓글 작성 form -->
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

    <!-- 댓글 리스트 -->
    <div id="comment_area">
        <table cellspacing="0" cellpadding="0" class="table table-striped">
            <tbody>
<?php
    foreach ($comment_list as $lt) {
        if($lt->depth == 0){
?>
                <tr id="row_num_<?php echo $lt->comment_id; ?>">
                
                    <th scope="row">
                        <?php echo $lt->user_id;?>
                    </th>
                    <td><?php echo $lt->contents;?></a></td>
                    <td><?php echo $lt->reg_date;?></td>
                    <td><button id="comment_delete" type="button" class="btn-sm btn-danger cmt_remove" vals="<?php echo $lt->comment_id; ?>">삭제</button></td>
                </tr>
                <td>
                    <textarea id="input_recomment" class="form-controls"></textarea>
                    <div style="text-align:right;"><input class="btn btn-primary" type="button" id="recomment_add" value="입력" vals="<?php echo $lt->comment_id; ?>"/></div>    
                </td>
                
                <!-- 대댓글 -->
        <?php
            }
            foreach($comment_list as $lt2){
                if($lt->comment_id==$lt2->parent_id){
        ?>
                    <tr id="row_num_<?php echo $lt2->comment_id; ?>">
                        <th style="margin-left:100px; display: inline-block;" scope="row">
                            ---> <?php echo $lt2->user_id;?>
                        </th>
                        <td ><?php echo $lt2->contents;?></a></td>
                        <td><?php echo $lt2->reg_date;?></td>
                        <td><button id="recomment_delete" type="button" class="btn-sm btn-danger cmt_remove" vals="<?php echo $lt2->comment_id; ?>">삭제</button></td>
                    
                    </tr>  
        <?php 
                }
            }
        }
        ?>

            </tbody>
        </table>
    </div>
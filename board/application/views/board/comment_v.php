<!-- <script type="text/javascript" src="/board/include/js/httpRequest.js"></script>

<script>
    
    $(function() {
        $("#comment_add").click(function () {
            $.ajax({
                url: "/board/index.php/board/ajax_board/ajax_comment_add",
                type: "POST",
                data: {
                    "comment_contents": encodeURIComponent($("#input01").val()),
                    "csrf_test_name": getCookie('csrf_cookie_name'),
                    "table": 'comment',
                    "board_id": "<?php echo $this->uri->segment(4); ?>"
                },
                dataType: "html",
                complete: function(xhr, textStatus) {
                    if (textStatus == 'success') {
                        
                            alert($("#comment_area").html());
                            $("#comment_area").html(xhr.responseText);
                            $("#input01").val('');
                        
                    }
                }
            });
        });

        $(".comment_delete").click(function() {
            $.ajax({
                url: '/board/index.php/board/ajax_board/ajax_comment_delete',
                type: 'POST',
                data: {
                    "csrf_test_name": getCookie('csrf_cookie_name'),
                    "table": "comment",
                    "board_id": $(this).attr("vals")
                },
                dataType: "text",
                complete: function(xhr, textStatus) {
                    if (textStatus == 'success') {
                        console.log(xhr.responseText);
                        $('#row_num_'<?php $this->uri->segment(4); ?>).remove();
                        alert('삭제되었습니다.');
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



    <div id="comment_area">
        <table cellspacing="0" cellpadding="0" class="table table-striped">
        <form class="form-horizontal" method="POST" action="" name="com_add">
            <fieldset>
                <div class="control-group">
                    
                    <div class="controls">
                        <div style="text-align:left;"><label style="text-align:left;" class="control-label" for="input01">댓글</label></div>
                        <input class="form-control" id="input01" name="comment_contents" />
                        <div style="text-align:right;"><button class="btn btn-link" type="button" id="comment_add" >확인</button></div>
                        <p class="help-block"></p>
                    </div>
                </div>
            </fieldset>
        </form>
            <tbody>
<?php
    foreach ($comment_list as $lt) {
?>


                <tr id="row_num_<?php echo $lt->board_id; ?>">
                    <th scope="row">
                        <?php echo $lt->user_id;?>
                    </th>
                    <td><?php echo $lt->contents;?></a></td>
                    <td>
                        <time datetime="<?php echo mdate("%Y-%M-%j", human_to_unix($lt->reg_date)); ?>">
                            <?php echo $lt->reg_date;?>
                        </time>
                    </td>
                    <td>
                        
                        <a href="#" class="comment_delete" vals='<?php echo $lt->board_id; ?>'>
                            <i class="icon-trash"></i> 삭제
                        </a>
                    </td>
                </tr>
<?php
    }
?>
            </tbody>
        </table>
     -->
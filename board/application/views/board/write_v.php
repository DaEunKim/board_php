<script>
    $(document).ready(function() {
        $("#write_btn").click(function() {
            if ($("#input01").val() == '') {
                alert('제목을 입력해 주세요.');
                $("#input01").focus();
                return false;
            } else if ($("#input02").val() == '') {
                alert('내용을 입력해 주세요.');
                $("#input02").focus();
                return false;
            } else {
                $("#write_action").submit();
            }
        });
    });
</script>
<article style="text-align:center;" id="board_area" >
    <header><h1></h1></header>
    <?php
        $attributes = array('class' => 'form-horizontal', 'id' => 'write_action');
        echo form_open('board/write/board', $attributes);
   ?>

    <form class="form-horizontal" method="post" action="" id="write_action" >
        <fieldset >
            <legend>
                게시물 쓰기
            </legend>
            <div class="control-group">
                <label class="control-label" for="input01">제목</label>
                <div class="controls">
                    <input type="text" class="form-control" id="input01" name="title">
                    <p class="help-block">
                        게시물의 제목을 써주세요.
                    </p>
                </div>

                
                <label class="control-label" for="input02">내용</label>
                <div class="controls">
                    <textarea class="form-control" id="input02" name="contents" rows="5"></textarea>
                    <p class="help-block">
                        게시물의 내용을 써주세요.
                    </p>
                </div>
                <div class="controls">
                    <p class="help-block"><?php echo validation_errors();?></p>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success" id="write_btn">
                        작성
                    </button>
                    <button class="btn btn-link" onclick="document.location.reload()">
                        취소
                    </button>
                </div>
            </div>
        </fieldset>
    </form>
</article>
<footer></footer>

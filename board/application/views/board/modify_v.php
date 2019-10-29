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

<article id="board_area">
    <header><h1></h1></header>
    <form class="form-horizontal" method="post" action="" id="write_action">
        <fieldset  >
            <legend style="text-align:center;">게시물 수정</legend>
            <div class="control-group">
                <label class="control-label" for="input01">제목</label>
                
                <div class="controls">
                    <input class="form-control" id="input01" type="text" value="<?php echo $views->title ?>" name="title"  >
                </div>

                <label class="control-label" for="input02">내용</label>
                
                <div class="controls">
                    <textarea class="form-control" type="text" id="input02" name="contents" rows="5"><?php echo $views->contents ?></textarea>
                </div>
                <br>
                <div style="text-align:right;" class="form-actions">
                    <button type="submit" class="btn btn-warning" id="write_btn"> 수정 </button>
                    <button class="btn btn-link" onclick="document.location.reload()">취소</button>
                </div>
            </div>
        </fieldset>
    </form>
</article>
<footer></footer>

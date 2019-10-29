<article id="board_area">
    <header><h1></h1></header>
    <?php //echo validation_errors(); ?>
    <?php
        if ( form_error('user_id')) {
            $error_user_id = form_error('user_id');
        } else {
            $error_user_id = form_error('user_id_check');
        }
   ?>
    
    <form method="POST" class="form-horizontal">
        <fieldset>
            <legend> 폼 검증</legend>
            <div class="control-group">
                <label class="control-label" for="input01">아이디</label>
                <div class="controls">
                    <input type="text" name="user_id" class="input-xlarge" id="input01" 
                        value="<?php echo set_value('user_id'); ?>"/>
                    <p class="help-block">
                        <?php 
                        if ($error_user_id == FALSE) {
                            echo "아이디를 입력하세요";
                        } else {
                            echo $error_user_id;
                        }
                       ?>
                    </p>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="input02">비밀번호</label>
                <div class="controls">
                    <input type="password" name="password" class="input-xlarge" id="input02" />
                    <p class="help-block">
                        <?php
                            if (form_error('password') == FALSE) {
                                echo "비밀번호를 입력하세요.";
                            } else {
                                echo form_error('password');
                            }
                       ?>
                    </p>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="input03">비밀번호 확인</label>
                <div class="controls">
                    <input type="password" name="passconf" class="input-xlarge" id="input03" />
                    <p class="help-block">비밀번호를 한 번 더 입력하세요.</p>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="input04">이메일</label>
                <div class="controls">
                    <input type="text" name="email" class="input-xlarge" id="input04" 
                        value="<?php echo set_value('email'); ?>"/>
                    <p class="help-block">이메일을 입력하세요.</p>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="input05">기본 값 설정</label>
                <div class="controls">
                    <input type="text" name="count" class="input-xlarge" id="input05" 
                        value="<?php echo set_value('count', 0); ?>"/>
                    <p class="help-block">기본 값이 출력됩니다.</p>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="input06">Select 값 복원</label>
                <div class="controls">
                    <select name="myselect" id="input06">
                        <option value="one" <?php echo set_select('myselect', 'one', TRUE);?>>
                            One
                        </option>
                        <option value="two" <?php echo set_select('myselect', 'two');?>>
                            Two
                        </option>
                        <option value="three" <?php echo set_select('myselect', 'three');?>>
                            Three
                        </option>
                    </select>
                    <p class="help-block">선택 하세요.</p>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="input07">체크박스</label>
                <div class="controls">
                    1번 <input type="checkbox" name="mycheck[]" id="input07" value="1" 
                        <?php echo set_checkbox('mycheck[]', '1', TRUE);?> />
                    2번 <input type="checkbox" name="mycheck[]" id="input07" value="2" 
                        <?php echo set_checkbox('mycheck[]', '2');?> />
                    <p class="help-block">체크박스를 선택하세요.</p>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="input08">라디오</label>
                <div class="controls">
                    1번 <input type="radio" name="myradio" id="input08" value="1" 
                        <?php echo set_radio('myradio', '1', TRUE);?> />
                    2번 <input type="radio" name="myradio" id="input08" value="2" 
                        <?php echo set_radio('myradio', '2');?> />
                    <p class="help-block">라디오 버튼을 선택하세요.</p>
                </div>
            </div>
        </fieldset>
        
        <div><input type="submit" value="전송" class="btn btn-primary"/></div>
    </form>
</article>

<?php $rootURL = "/board/index.php/board"; ?>
<article style="text-align:center;" id="board_area">
    <header><h1></h1></header>
    <a style="float:right;" href="<?php echo $rootURL.'/write/'.$this->uri->segment(3).'/page/'.$this->uri->segment(7); ?>" class="btn btn-success"> 글쓰기 </a><br><br>
    <table class="col" cellpadding="20" cellspacing="10" style="border:4px gray solid;">
        <thead style="border:4px gray solid;">
            <tr>
                <th scope="col">번호</th>
                <th style="border:1px gray solid;" scope="col">제목</th>
                <th style="border:1px gray solid;" scope="col">작성자</th>
                <th style="border:1px gray solid;" scope="col">조회수</th>
                <th style="border:1px gray solid;" scope="col">작성일</th>
            </tr>
        </thead>
        
        <tbody style="border:4px gray solid;">
            <?php
            $board_num = $list_count - $page_count*$cur_page + 1;
            foreach($list as $lt)
            {
                $board_num--;
            ?>
                <tr>
                    <th style="border:1px gray solid;" scope="row"><?php echo $board_num; ?></th>
                    <td style="border:1px gray solid;"><a rel="external" href="<?php echo $rootURL.'/view/'.$this->uri->segment(3).'/'.$lt->board_id; ?>"><?php echo $lt->title;?></a></td>
                    <td style="border:1px gray solid;"><?php echo $lt->user_id;?></td>
                    <td style="border:1px gray solid;"><?php echo $lt->hits;?></td>
                    <td style="border:1px gray solid;"><time datetime="<?php echo mdate("%Y-%M-%j", human_to_unix($lt->reg_date)); ?>"><?php echo mdate("%Y-%M-%j", human_to_unix($lt->reg_date));?></time></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" style="text-align:center; font-size:25px;" ><?php echo $pagination;?></th>
            </tr>
            
        </tfoot>
    </table>  
</article>
<footer></footer>
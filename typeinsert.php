<?php
include('db.php');
$query = "SELECT id as idx, fixed_type as ft, custom_type as ct FROM flow_type WHERE created_date = (SELECT MAX(created_date) FROM flow_type )";
$result = mysqli_query($dbconn, $query);
$row = mysqli_fetch_array($result);
if($row){
    
    $num = explode('|', $row["ft"]);
    $custom = explode('|', $row["ct"]);
    $subMode = "update";
}

?>
<!DOCTYPE html>
<html lang="en">
    <head><p align="center" style = "font-size:1.5em;"><b>파일 확장자 차단</b></p></head>
    <body>
        <form action="process_type.php" id="frm" method="POST" enctype="multipart/form-data">
            <table align="center" border="1">
                <tr>
                    <td width="150">고정 확장자</td>
                    <td width="400">
                        <input type="checkbox" name="fix[]" value="bat" <?if($num != null && in_array("bat",$num)){?>checked<?}?>>bat</input>
                        <input type="checkbox" name="fix[]" value="cmd" <?if($num != null && in_array("cmd",$num)){?>checked<?}?>>cmd</input>
                        <input type="checkbox" name="fix[]" value="com" <?if($num != null && in_array("com",$num)){?>checked<?}?>>com</input>
                        <input type="checkbox" name="fix[]" value="cpl" <?if($num != null && in_array("cpl",$num)){?>checked<?}?>>cpl</input>
                        <input type="checkbox" name="fix[]" value="exe" <?if($num != null && in_array("exe",$num)){?>checked<?}?>>exe</input>
                        <input type="checkbox" name="fix[]" value="scr" <?if($num != null && in_array("scr",$num)){?>checked<?}?>>scr</input>
                        <input type="checkbox" name="fix[]" value="js" <?if($num != null && in_array("js",$num)){?>checked<?}?>>js</input>
                    </td>
                </tr>
                <input type="hidden" id="subMode" name="subMode" value="<?php echo $subMode?>">
                <tr>
                    <td width="150">커스텀 확장자 개수</td>
                    <td><p align="center"><?php if ($row) {
                        echo count($custom);
                    }else{
                        echo 0;
                    } ?>/200</p></td>
                </tr>     
                <tr>
                    <td width="150">커스텀 확장자</td>
                    <td>
                    <div class="textbox-wrapper">
                            <?php
                                if($row){
                            ?>
                                <div class="input-group">
                                    <?php echo 1.?>
                                    <input type="text" id="text_arr0" name="text_arr[]" maxlength="20" value="<?php if ($custom) {echo $custom[0];}?>" />
                                    <span>
                                        <input type="button" class="add-textbox-recent" value="+추가"/>
                                    </span>
                                </div>
                                <?php
                                for ($i = 1; $i < count($custom);$i++){
                                ?>
                                
                                <div class="input-group">
                                    <?php echo $i+1.?>
                                    <input type="text" id="text_arr<?php echo $i?>" name="text_arr[]" maxlength="20" value="<?php if ($custom) {echo $custom[$i];}?>" />
                                    <span>
                                    <input type="button" class="remove-textbox" value="X"/>
                                    </span>
                                </div>

                                <?php } ?>
                            <?php } else { ?>
                            
                                <div class="input-group">
                                    <input type="text" id="text_arr0" name="text_arr[]" maxlength="20" />
                                    <span>
                                        <input type="button" class="add-textbox" value="+추가"/>
                                    </span>
                                </div>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p align="center">
                            <a href="javascript:void(0)" onclick="fn_submit()">작성완료</a>
                            <a href="process_delete.php?id=<?php echo $row["idx"]?>" >초기화 하기</a>
                        </p>
                    </td>
                </tr>
            </table>
            
        </form>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                var max=200;
                var cnt_recent=<?php if ($row) {
                    echo count($custom) - 1;} else{
                    echo 0;
                    } ?>;
                var cnt=1;
                $(".add-textbox").on("click",function(e){
                    e.preventDefault();
                    if(cnt<max){
                        cnt++;
                        $(".textbox-wrapper").append('<div class="input-group"><input type="text" id="text_arr'+cnt+'" name="text_arr[]" maxlength="20" /><span><input type="button" class="remove-textbox" value="X"/></span></div>');
                    }
                });

                $(".add-textbox-recent").on("click",function(e){
                    e.preventDefault();
                    if(cnt_recent<max){
                        cnt_recent++;
                        $(".textbox-wrapper").append('<div class="input-group"><input type="text" id="text_arr'+cnt_recent+'" name="text_arr[]" maxlength="20" /><span><input type="button" class="remove-textbox" value="X"/></span></div>');
                    }
                });

                $(".textbox-wrapper").on("click",".remove-textbox",function(e){
                    e.preventDefault();
                    $(this).parents(".input-group").remove();
                    cnt--;
                });
            });

            function fn_submit(){
                var cnt_recent=200;
                
                //var type=['bat','cmd','com','cpl','exe','scr','js'];
                for(var i=0; i< cnt_recent ;i++){
                    if($("#text_arr"+i).val()== "bat"||$("#text_arr"+i).val()=="cmd"||$("#text_arr"+i).val()=="com"||$("#text_arr"+i).val()=="cpl"||$("#text_arr"+i).val()=="exe"||$("#text_arr"+i).val()=="scr"||$("#text_arr"+i).val()=="js"){
                        alert("커스텀 확장자에 고정확장자와 중복된 것이 있습니다.");
                        $("#text_arr"+i).focus();
                        return false;
                    }
                }
                frm.submit();
            }
        </script>
    </body>
</html>
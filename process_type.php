<?php
    include('db.php');
    $number = count($_POST["text_arr"]);

    $fixed_arr = implode("|", $_POST["fix"]);
    $custom_arr = implode("|", $_POST["text_arr"]);

    $subMode = $_POST["subMode"];

    if($subMode == "update"){
        $sql = "
            UPDATE flow_type SET 
                fixed_type='{$fixed_arr}',
                custom_type='{$custom_arr}',
                updated_date=NOW()
                WHERE (SELECT * FROM(SELECT MAX(created_date) FROM flow_type)ft)
        ";
        $result = mysqli_query($dbconn, $sql);
        if($result === false) {
            echo "<script> alert('파일확장자 수정을 실패했습니다.'); history.back();</script>";
        } else {
            echo "<script> alert('파일확장자 수정을 성공했습니다.'); location.href='typeinsert.php';</script>";
        }
    }
    else{
        $sql = "
            INSERT INTO flow_type
            (fixed_type, custom_type, created_date)
            VALUE(
                '{$fixed_arr}',
                '{$custom_arr}',
                NOW()
            )
        ";

        $result = mysqli_query($dbconn, $sql);
        if($result === false) {
            echo "<script> alert('파일확장자 입력을 실패했습니다.'); history.back();</script>";
        } else {
            echo "<script> alert('파일확장자 입력을 성공했습니다.'); location.href='typeinsert.php';</script>";
        }
    }
    
?>
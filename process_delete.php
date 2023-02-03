<?php
include('db.php');
$sql = "DELETE FROM flow_type WHERE id = {$_GET['id']}";

$result=mysqli_query($dbconn, $sql);
if($result === false) {
    echo "<script> alert('타입초기화를 실패했습니다.'); history.back();</script>";
} else {
    echo "<script> alert('타입초기화를 완료했습니다.'); location.href='typeinsert.php';</script>";
}
?>
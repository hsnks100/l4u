<?php
include_once('./_common.php');
include_once(G5_PATH.'/head.sub.php');

$msg = isset($msg) ? strip_tags($msg) : '';

$msg2 = str_replace("\\n", "<br>", $msg);

if($error) {
    $header2 = "다음 항목에 오류가 있습니다.";
    $msg3 = "새창을 닫으시고 이전 작업을 다시 시도해 주세요.";
} else {
    $header2 = "다음 내용을 확인해 주세요.";
    $msg3 = "새창을 닫으신 후 서비스를 이용해 주세요.";
}
?>

<script>
var msg = "<?php echo $msg?>";
if(parent == top){
    parent.Swal.fire({
        customClass: {
            header : 'border-b border-gray-600 mb-2 text-sm',
            footer : 'border-t border-gray-600'
        },
        title : '경고',
        html : msg,
        showCancelButton : false,
        showConfirmButton : true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '확인',
        cancelButtonText: '취소',
    }).then((result) => {
        
    });
}else{
    Swal_Ko.fire({
        title: '경고',
        html: msg,
    }).then((result) => {
        window.close();
    });
}
</script>

<?php
include_once(G5_PATH.'/tail.sub.php');
?>
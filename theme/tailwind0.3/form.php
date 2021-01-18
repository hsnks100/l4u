<?php 
include "_common.php";
include G5_PATH.'/head.sub.php';
?>
<div name="ajaxiframe" id="ajaxiframe" style="display:none">
</div>
<script src="<?php echo G5_THEME_URL?>/js/popup.resize.js"></script>
<script>
window.addEventListener('DOMContentLoaded', function(){
    var form = document.getElementById("ajaxiframe"); 
    var fname = '<?php echo $_GET['name'];?>';
    var pf = parent.document.querySelector('[name=' + fname + ']');
    var clone = pf.cloneNode(true);
    form.appendChild(clone);
    clone.submit();
    return false;
    var input = pf.querySelectorAll('input[type="hidden"]');
    form.action = pf.action;
    input.forEach(ele => {
        form.appendChild(ele);
    });
    pf.querySelector('[name=gb_poll]:checked')
    form.appendChild();
    return false;
    form.submit();
})
/*
var form = window.frames['swal_popup'].document.getElementById('ajaxiframe');
        console.log(form);
        form.appendChild(f.po_id);
        form.appendChild(f.skin_dir);
        form.appendChild(f.po_id);
        form.appendchild(document.querySelector('[name=gb_poll]:checked'));
        form.action = f.action;
        form.submit();
        */
function submit(f){
    if(!parent){
        alert('비정상적인 접근입니다');
        return false;    
    }
    return false;
}
</script>
<?php 
include G5_PATH.'/tail.sub.php';
?>
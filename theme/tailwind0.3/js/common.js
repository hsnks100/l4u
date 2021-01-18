const Toast = Swal.mixin({
    toast: true,
    position: 'bottom',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
const Swal_Ko = Swal.mixin({
    customClass: {
        header: 'border-b border-gray-600 mb-2',
    },
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '확인',
    cancelButtonText: '취소',
    title: '경고',
});

// 삭제 검사 확인
function del(href) {
    var height = 0;
    if(parent){
        var iframe = parent.document.querySelector('#swal_popup');
        height = $(iframe).height();
        $(iframe).css('height', "300px");
    }
    Swal_Ko.fire({
        title: '삭제',
        html: '한번 삭제한 자료는 복구할 방법이 없습니다.<br>정말 삭제하시겠습니까?',
        showCancelButton: true,
    }).then((result) => {
        if (result.value) {
            location.href = href;
        }else{
            var iframe = parent.document.querySelector('#swal_popup');
            $(iframe).css('height', height + "px");
        }
    })
    return false;
}
//search html
const TopSearch = [
    '<form name="fsearchbox" method="get" action="' + g5_bbs_url +'/search.php" class="block relative" onsubmit="return fsearchbox_submit(this);">',
    '<input type="hidden" name="sfl" value="wr_subject||wr_content">',
    '<input type="hidden" name="sop" value="and">',
    '<label for="sch_stx" class="sound_only">검색어 필수</label>',
    '<input type="text" name="stx" id="sch_stx" maxlength="20" class="mt-3 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="검색어를 입력해주세요">',
    '<button type="submit" id="sch_submit" class="absolute top-0 right-0 py-2 px-2 text-gray-800 mt-3" value="검색"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>',
    '</form>'
].join('');
// 서치 버튼 클릭
$(document).on('click', '#Search-btn', function (e) {
    $.ajax({
        type: "get",
        url: g5_theme_url + '/lib/popular.lib.php',
        dataType: "html",
        success: function (data) {
            $('.swal2-footer').html(data);
        }
    });
    Swal.fire({
        customClass: {
            header : 'border-b border-gray-600 mb-2 text-sm',
            footer : 'border-t border-gray-600'
        },
        title : '검색',
        html : TopSearch,
        footer : 'asdf',
        showCancelButton : false,
        showConfirmButton : false,
    });
});
function fsearchbox_submit(f) {
    if (f.stx.value.length < 2) {
        alert("검색어는 두글자 이상 입력하십시오.");
        f.stx.select();
        f.stx.focus();
        return false;
    }
    // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
    var cnt = 0;
    for (var i=0; i<f.stx.value.length; i++) {
        if (f.stx.value.charAt(i) == ' ')
            cnt++;
    }
    if (cnt > 1) {
        alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
        f.stx.select();
        f.stx.focus();
        return false;
    }
    return true;
}
// submit 할 때 속성을 검사한다.
function wrestSubmit()
{
    wrestMsg = "";
    wrestFld = null;

    var attr = null;

    // 해당폼에 대한 요소의 개수만큼 돌려라
    for (var i=0; i<this.elements.length; i++) {
        var el = this.elements[i];

        // Input tag 의 type 이 text, file, password 일때만
        // 셀렉트 박스일때도 필수 선택 검사합니다. select-one
        if (el.type=="text" || el.type=="hidden" || el.type=="file" || el.type=="password" || el.type=="select-one" || el.type=="textarea") {
            if (el.getAttribute("required") != null) {
                wrestRequired(el);
            }

            if (el.getAttribute("minlength") != null) {
                wrestMinLength(el);
            }

            var array_css = el.className.split(" "); // class 를 공백으로 나눔

            el.style.backgroundColor = wrestFldDefaultColor;

            // 배열의 길이만큼 돌려라
            for (var k=0; k<array_css.length; k++) {
                var css = array_css[k];
                switch (css) {
                    case "required"     : wrestRequired(el); break;
                    case "trim"         : wrestTrim(el); break;
                    case "email"        : wrestEmail(el); break;
                    case "hangul"       : wrestHangul(el); break;
                    case "hangul2"      : wrestHangul2(el); break;
                    case "hangulalpha"  : wrestHangulAlpha(el); break;
                    case "hangulalnum"  : wrestHangulAlNum(el); break;
                    case "nospace"      : wrestNospace(el); break;
                    case "numeric"      : wrestNumeric(el); break;
                    case "alpha"        : wrestAlpha(el); break;
                    case "alnum"        : wrestAlNum(el); break;
                    case "alnum_"       : wrestAlNum_(el); break;
                    case "telnum"       : wrestTelNum(el); break; // 김선용 2006.3 - 전화번호 형식 검사
                    case "imgext"       : wrestImgExt(el); break;
                    default :
                        if (/^extension\=/.test(css)) {
                            wrestExtension(el, css); break;
                        }
                } // switch (css)
            } // for (k)
        } // if (el)
    } // for (i)

    // 필드가 null 이 아니라면 오류메세지 출력후 포커스를 해당 오류 필드로 옮김
    // 오류 필드는 배경색상을 바꾼다.
    if (wrestFld != null) {
        // 경고메세지 출력
        Swal_Ko.fire({text : wrestMsg});
        if (wrestFld.style.display != "none") {
            var id = wrestFld.getAttribute("id");

            // 오류메세지를 위한 element 추가
            var msg_el = document.createElement("strong");
            msg_el.id = "msg_"+id;
            msg_el.className = "msg_sound_only";
            msg_el.innerHTML = wrestMsg;
            wrestFld.parentNode.insertBefore(msg_el, wrestFld);

            var new_href = document.location.href.replace(/#msg.+$/, "")+"#msg_"+id;

            document.location.href = new_href;

            //wrestFld.style.backgroundColor = wrestFldBackColor;
            if (typeof(wrestFld.select) != "undefined")
                wrestFld.select();
            wrestFld.focus();
        }
        return false;
    }

    if (this.oldsubmit && this.oldsubmit() == false)
        return false;

    return true;
}
$(window).scroll(function(e){
    sv_hide = true;
    $(".sv").removeClass("sv_on");
});
// 사이드뷰
$(function(){
    var sv_hide = false;
    setTimeout(() => {
        $(".sv_member, .sv_guest").off();    
        $(".sv_member, .sv_guest").click(function(e) {
            var offset = $(this).offset();
            var scrollHeight = $('html').scrollTop();
            $(this).closest(".sv_wrap").find(".sv").css({
                top : (offset.top + 25 - scrollHeight) + "px",
                left : (offset.left) + "px",
            });
            $(".sv").removeClass("sv_on");
            $(this).closest(".sv_wrap").find(".sv").addClass("sv_on");
        });
    }, 1);
});

/**
 * 스크랩
 */
function is_scrap_swal(){
    Swal.fire({
        customClass: {
            header : 'border-b border-gray-600 mb-2 text-sm',
            footer : 'border-t border-gray-600'
        },
        title : '스크랩',
        html : '이 글을 스크랩 하였습니다.<br>지금 스크랩을 확인하시겠습니까?',
        showCancelButton : true,
        showConfirmButton : true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '확인',
        cancelButtonText: '취소',
    }).then((result) => {
        if (result.value) {
            console.log('왜 안됨..?');
            Swal.fire({
                customClass: {
                    popup : 'bg-gray-900',
                    container : 'p-0'
                },
                html : '<iframe class="w-full m-0 p-0" id="swal_popup" name="swal_poup" src="'+g5_bbs_url+'/scrap.php"> </iframe>',
                showCancelButton : false,
                showConfirmButton : false,
            });
        }else if(result.dismiss == "cancel"){
            //location.href = json.back_url;
        }
    });
}
function getUrlParams(href) {
    var params = {};
    href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(str, key, value) { params[key] = value; });
    return params;
}
function win_scrap(href){
    console.log('테스트');
    var params = getUrlParams(href);

    $.ajax({
        type: "get",
        url: g5_theme_url+'/lib/scrap.lib.php',
        data : {
            bo_table : params.bo_table,
            wr_id : params.wr_id,
        },
        dataType : "json",
        success: function (data) {
            console.log(data);
            if(data.is_scrap == "false"){
                Swal.fire({
                    customClass: {
                        popup : 'bg-gray-900',
                        container : 'p-0'
                    },
                    html : '<iframe class="w-full m-0 p-0" id="swal_popup" name="win_scrap" src="'+href+'"> </iframe>',
                    showCancelButton : false,
                    showConfirmButton : false,
                });
            }else{
                var html = [
                    '<p>이미 스크랩하신 글 입니다.</p>',
                    '<p>지금 스크랩을 확인하시겠습니까?</p>',
                ].join('');
                Swal.fire({
                    customClass: {
                        header : 'border-b border-gray-600 mb-2 text-sm',
                        footer : 'border-t border-gray-600'
                    },
                    title : '스크랩',
                    html : html,
                    showCancelButton : true,
                    showConfirmButton : true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '확인',
                    cancelButtonText: '취소',
                }).then((result) => {
                    if (result.value) {
                        Swal.fire({
                            customClass: {
                                popup : 'bg-gray-900',
                                container : 'p-0'
                            },
                            html : '<iframe class="w-full m-0 p-0" id="swal_popup" name="swal_poup" src="'+g5_bbs_url+'/scrap.php"> </iframe>',
                            showCancelButton : false,
                            showConfirmButton : false,
                        });
                    }else if(result.dismiss == "cancel"){
                        //location.href = json.back_url;
                    }
                });
            }
        }
    });
    return false;
}
$(document).on('click', '.popup_href', function (e) {
    e.preventDefault();
    Swal.fire({
        customClass: {
            popup : 'bg-gray-900',
            container : 'p-0'
        },
        html : '<iframe class="w-full m-0 p-0" id="swal_popup" name="swal_poup" src="'+$(this).attr('href')+'"> </iframe>',
        showCancelButton : false,
        showConfirmButton : false,
    });
    return false;
});
window.onbeforeunload = function(e){
    //sessionStorage.removeItem('vmenu');
}

/**
 * 메뉴 저장
 */
$(function(){
    $('a[data-menunum]').click(function (e) { 
        e.preventDefault();
        sessionStorage.setItem("vmenu", this.getAttribute('data-menunum'));
        location.href = $(this).attr('href');
    });
    var vmenu = sessionStorage.getItem('vmenu');
    if(vmenu && $('a[data-menunum]').length > 0){
        console.log($('a[data-parentnum='+vmenu+']'), 'a[data-parentnum='+vmenu+']');
        var color = $('a[data-parentnum='+vmenu+']')[0].getAttribute('data-mcolor');
        $('#parent_menu_'+vmenu).addClass(color);
        var width = $('#parent_menu_'+vmenu).width();        
        $('#top_menu').scrollLeft(width * vmenu);
    }
});


/**
 * 포인트 창
 **/
var win_point = function(href) {
    Swal.fire({
        customClass: {
            popup : 'bg-gray-900',
            container : 'p-0'
        },
        html : '<iframe class="w-full m-0 p-0" id="swal_popup" name="swal_poup" src="'+href+'"> </iframe>',
        showCancelButton : false,
        showConfirmButton : false,
    });
}

/**
 * 쪽지 창
 **/
var win_memo = function(href) {
    Swal.fire({
        customClass: {
            popup : 'bg-gray-900',
            container : 'p-0',
        },
        html : '<iframe class="w-full m-0 p-0 h-32" id="swal_popup" name="swal_poup" src="'+href+'"> </iframe>',
        showCancelButton : false,
        showConfirmButton : false,
    });
}

/**
 * 쪽지 창
 **/
var check_goto_new = function(href, event) {
    if( !(typeof g5_is_mobile != "undefined" && g5_is_mobile) ){
        if (window.opener && window.opener.document && window.opener.document.getElementById) {
            event.preventDefault ? event.preventDefault() : (event.returnValue = false);
            window.open(href);
            //window.opener.document.location.href = href;
        }
    }
}

/**
 * 메일 창
 **/
var win_email = function(href) {
    Swal.fire({
        customClass: {
            popup : 'bg-gray-900',
            container : 'p-0'
        },
        html : '<iframe class="w-full m-0 p-0" id="swal_popup" name="swal_poup" src="'+href+'"> </iframe>',
        showCancelButton : false,
        showConfirmButton : false,
    });
}

/**
 * 자기소개 창
 **/
var win_profile = function(href) {
    Swal.fire({
        customClass: {
            popup : 'bg-gray-900',
            container : 'p-0'
        },
        html : '<iframe class="w-full m-0 p-0" id="swal_popup" name="swal_poup" src="'+href+'"> </iframe>',
        showCancelButton : false,
        showConfirmButton : false,
    });
}

/**
 * 홈페이지 창
 **/
var win_homepage = function(href) {
    Swal.fire({
        customClass: {
            popup : 'bg-gray-900',
            container : 'p-0'
        },
        html : '<iframe class="w-full m-0 p-0" id="swal_popup" name="swal_poup" src="'+href+'"> </iframe>',
        showCancelButton : false,
        showConfirmButton : false,
    });
}
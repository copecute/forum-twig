{% use '_template.php' %}
{% if get_get('act') == 'change_info.php' %}
{% set title = 'Câp nhật hồ sơ' %}
{% elseif get_get('act') == 'change_pass.php' %}
{% set title = 'Thay đổi mật khẩu' %}
{% else %}
{% set title = 'Trang cá nhân' %}
{% endif %}
 {{ block( 'header' ) }}
<style>
/* profile */
@media only screen and (max-width: 800px){
.profileCard > .profileCover{height:160px!important;}
.profileCard > .profileAvatar img{top:90px!important;}}
.profileCard{background-color:#ccc;position: relative;}
.profileCard > .profileCover{height:250px;background-size:cover;position:relative;}
.profileCard > .profileCover:before{content: '';background: linear-gradient(transparent,black);position: absolute;left: 0;width: 100%;height: 100%;opacity: 0.2;z-index: 1;}
.profileCard > .profileCover > .profileInfo{z-index: 2;position: absolute;bottom: 5px;left: 111px;font-weight: bold;padding: 3px;}
.profileCard > .profileAvatar img {z-index: 2;border-radius: 50%;position:absolute;width:100px;height:100px;left:5px;top:180px;background-color:#fff;background-size:100%;background-repeat:no-repeat;border:1px solid #fff;}
.profileCard > .profileMenu {padding-left: 111px;}
.check-admin{display: -webkit-inline-box!important;}
</style>
 {% from 'func.twig' import rwurl,get,login,add,up,lever,edit,ago %} 
{% if login() %}
{% set login=login()|trim %}
{% endif %}
 {% set url=get_uri_segments() %}

 {% set avatar=get_get('avatar')|trim %}
 {% set cover=get_get('cover')|trim %}
{% if avatar %}
{% if login %}
<style>.main-wrapper{width: 100%!important;}</style>
<div class="menu"><center>Cập nhật ảnh đại diện thành công<br /><br /> <img src="{{avatar}}" alt="anh" width="200px" height="200px"/><br /><a id="mi" class="like" href="/profile">Quay lại trang cá nhân</a></div>
{% if login == 'bot' %}
{% else %}
{% set comment = {"name":"bot","time":"now"|date('U'), "comment":" @"~login~" vừa thay đổi ảnh đại diện! [img]"~avatar~"[/img]"} %}
{% set save = save_data( "chat_ver0", comment|json_encode ) %}
{% endif %}
{{ add('user_'~login,'avt',avatar) }}
{% else %}
<div class="rmenu">Chức năng này không dành cho thành viên chưa đăng nhập</div>
{% endif %}
{% elseif cover %}
{% if login %}
<style>.main-wrapper{width: 100%!important;}</style>
<div class="menu"><center>Cập nhật ảnh bìa thành công<br /><br /> <img src="{{cover}}" alt="anh" width="100%"/><br /><a id="mi" class="like" href="/profile">Quay lại trang cá nhân</a></div>
{% if login == 'bot' %}
{% else %}
{% set comment = {"name":"bot","time":"now"|date('U'), "comment":" @"~login~" vừa thay đổi ảnh bìa! [img]"~cover~"[/img]"} %}
{% set save = save_data( "chat_ver0", comment|json_encode ) %}{% endif %}
{{ add('user_'~login,'cover',cover) }}
{% else %}
<div class="rmenu">Chức năng này không dành cho thành viên chưa đăng nhập</div>
{% endif %}
{% else %}


{% if not url[1] and not login or url[1] and get_data_count('user_'~rwurl(url[1])) == 0 %}
<div class="rmenu">Tài khoản này không tồn tại.</div>
{% else %}
{% if login and not url[1] %}
{% set user='user_'~login %} 
 {% set tk=login %} 
{% else %}
{% set user='user_'~rwurl(url[1]) %}
 {% set tk=rwurl(url[1]) %} 
{% endif %}
{% if get_get('act') == 'change_info.php' or get_get('act') == 'change_pass.php' %}
{% if login != tk %}
{% if login %}
<div class="rmenu">Bạn không thể chỉnh sửa thông tin của người khác</div>
{% else %}
<div class="rmenu">Chức năng này không dành cho thành viên chưa đăng nhập</div>
{% endif %}
{% elseif get_get('act') == 'change_info.php' %}
{% set lever=get('user_'~login,'lever')|trim %} 
{% set tien=get('user_'~login,'xu')|trim %} 
{% if login %} 
<style>
.main-wrapper {
    width: 100%!important;}
</style>
<form method="post" action="">
<div class="phdr"><span>Cập nhật hồ sơ</span></div> 
{% set gt=get_post('gt')|trim %}
{% set avt=get_post('avt')|trim %}
{% set cover=get_post('cover')|trim %}
{% set xu=get_post('xu')|trim %}
{% set tt=get_post('tt')|trim %}
{% set ten=get_post('ten')|trim %}
{% if request_method()|lower == "post" %}
{% if ten and ten|length>2 and ten|length<=50 or tt and tt|length>=3 and tt|length<=50 or gt or avt or cover %}
<div class="rmenu">Cập nhật thành công.</div>
{% endif %}
{% if gt %}
{{ add('user_'~login,'gt',gt) }} 
{% endif %}
{% if avt %}
{{ add('user_'~login,'avt',avt) }}
{% endif %}
{% if cover %}
{{ add('user_'~login,'cover',cover) }}
{% endif %}

{% if xu %}
{% if xu matches '/^[0-9]+[0-9]$/' %}
{% if xu >= '10' %}
{% if xu|length < '15' %}
<div class="rmenu">Cập nhật thành công</div>
{{ add('user_'~login,'xu',xu) }}
{% elseif tien|length >= '15' %}
{% if xu|length <= '15' %}
<div class="rmenu">Cập nhật thành công
{{ add('user_'~login,'xu',xu) }}
{% else %}
<div class="rmenu">Số xu của bạn đã trên 15 kí tự ko thể chỉnh sửa hơn 15 kí tự, vui lòng pm Admin để edit</div>
{% endif %}
{% else %}
<div class="rmenu">Số xu nhập vào phải nhỏ hơn 15 kí tự</div>
{% endif %}
{% else %}
<div class="rmenu">Số xu nhập vào phải từ 10 xu trở lên</div>
{% endif %}
{% else %}
<div class="rmenu">Số xu nhập vào không hợp lệ. Giá trị xu nhập vào phải là số và phải từ 10 xu trở lên</div>
{% endif %}
{% endif %}

{% if tt %}
{% if tt|length>=3 and tt|length<=50 %}
{{ add('user_'~login,'tamtrang',tt) }}
{% else %}
<div class="rmenu">Tâm trạng phải từ 3 đến 50 kí tự</div>
{% endif %}
{% endif %}

{% if ten %}
{% if ten|length>2 and ten|length<=50 %}
{{ add('user_'~login,'nick',ten) }}
{% else %}
<div class="rmenu">Tên hiển thị phải từ 2 đến 50 kí tự</div>
{% endif %}
{% endif %}

{% endif %}
<div class="menu">
Tên hiển thị(2 - 50):<br />
<input type="text" name="ten"><br />
Tâm trạng(3 - 50)<br /><input type="text" name="tt"><br />
Avatar (nhập link): | <a id="mi" href="/modules/avatar.php">Upload avatar</a><br />
<input type="text" name="avt"><br />
Ảnh bìa (nhập link): | <a id="mi" href="/modules/cover.php">Upload ảnh bìa</a><br />
<input type="text" name="cover"><br />
{% if lever == 'admin' or lever == 'smod' or lever == 'mod' %}
Tài sản:<br /><input type="text" name="xu" ><br />
{% endif %}
Giới tính:<br/>
<input type="radio" name="gt" value="boy" /> Con trai<br />
<input type="radio" name="gt" value="girl" /> Con gái
</div><div class="menu"><a id="mi" href="/profile?act=change_pass.php"><i class="fal fa-lock"></i> Đổi mật khẩu</a></div>
<div class="menu">
<button class="btn_status" type="submit" style="color: #fff; background: #455b64; border-radius: 4px;margin: 10px 0 0 0;display: inline-block;padding: 5px 15px;">Lưu</button></div></form>
{% else %}<div class="rmenu">Bạn chưa đăng nhập nên không thể sử dụng chức năng này</div> 
{% endif %}

{% if login() %}
 {% set avatar=get_get('avatar')|trim %}
 {% set cover=get_get('cover')|trim %}
{% elseif avatar %}
{{ block('header') }}
<style>.copecute_404{display:none;}.main-wrapper{width: 100%!important;}
.post{display:none;!important;}</style>
<div class="menu"><center>Cập nhật ảnh đại diện thành công<br /><br /> <img src="{{avatar}}" alt="anh" width="200px" height="200px"/><br /><a id="mi" class="like" href="/profile">Quay lại trang cá nhân</a></div>
{{ add('user_'~login,'avt',avatar) }}
{% elseif cover %}
{{ block('header') }}
<style>.copecute_404{display:none;}.main-wrapper{width: 100%!important;}
.post{display:none;!important;}</style>
<div class="menu"><center>Cập nhật ảnh bìa thành công<br /><br /> <img src="{{cover}}" alt="anh" width="200px" height="200px"/><br /><a id="mi" class="like" href="/profile">Quay lại trang cá nhân</a></div>
{{ add('user_'~login,'cover',cover) }}
{% endif %}

{% elseif get_get('act') == 'change_pass.php' %}
<style>
.main-wrapper {
    width: 100%!important;}
</style>
  {% if login %}   
   <div class="phdr"><span>Thay đổi mật khẩu</span></div>   
   {% set cu=get_post('cu')|trim %}   
   {% set moi=get_post('moi')|trim %}
 {% set remoi=get_post('remoi')|trim %}
    {% if request_method()|lower == "post" %}    
      {% if cu and moi and remoi %}   
             {% if get('user_'~login,'pass')!=cu %}   
    <div class="rmenu">Mật khẩu cũ không đúng.</div>
{% elseif moi!=remoi %}
<div class="rmenu">Mật khẩu mới nhập lại không khớp</div>
            {% else %}   
    <div class="rmenu">Đổi mật khẩu thành công.</div>   
   {{ add('user_'~login,'pass',moi) }}   
   {% endif %}
{% else %}
<div class="rmenu">Vui lòng nhập đầy đủ thông tin</div>
   {% endif %}
   {% endif %}
   <div class="menu"><form method="post" action="">Nhập mật khẩu cũ:<br /><input type="password" name="cu"><br />Nhập mật khẩu mới:<br /><input type="password" name="moi"><br />Nhập lại mật khẩu mới<br />
<input type="password" name="remoi">
<br /><button class="btn_status" type="submit" style="color: #fff; background: #455b64; border-radius: 4px;margin: 10px 0 0 0;display: inline-block;padding: 5px 15px;">Lưu</button></form></div>   
   {% else %}<div class="rmenu">Bạn chưa đăng nhập nên không thể sử dụng chức năng này</div>   
   {% endif %}
{% endif %}

{% else %}
{% if get_get('act') == 'tuongnha' %}
{% set tn=get('user_'~tk,'tuongnha')|trim %}
{% if login == tk %}
{% if tn > '0' %}

 {{ add('user_'~tk,'tuongnha',tn|trim-tn) }}
{% endif %}
{% endif %}
{% endif %}

{% set lever=get(user,'lever')|trim %} 
{% set on=get(user,'on')|trim %}
{% set nick=get('user_'~login,'nick')|trim %}
<div class="profileCard"><div class="profileCover" style="background-image:url('{{get(user,'cover')}}')"><div class="profileInfo"><span style="color: white;"><span style="font-size:18px;color:white;">{{get(user,'nick')}}</span> <span style="display:none" class="check-{{lever}}"><i class="fas fa-check-circle" style="color: #455b64;"></i></span><br /><span style="font-weight: 549;">({{get(user,'tamtrang')}})</span></div></div>
   <div class="profileAvatar"><img src="{{get(user,'avt')}}">{% if on < ('now'|date('U')-600) %}{% else %}<span name="online" style="position: absolute;left: 80px;z-index: 2;"><i class="fas fa-circle" style="position: absolute;bottom: -23px;color: green;font-size: 16px;"></i></span>{% endif %}</div>
    <div class="profileMenu menu">
{% if login == rwurl(url[1]) or not url[1] %}
<a id="mi" href="/account/auto"><i class="fal fa-user-friends"></i> Auto login</a> · <a id="mi" href="/profile?act=change_info.php"><i class="fal fa-user-edit"></i> Cập nhật hồ sơ</a>
{% else %}
<a id="mi" href="/messages/{{rwurl(url[1])}}"><i class="fal fa-comment-lines"></i> Gửi tin nhắn</a>  ·  <a id="mi" href="/map/farm/nongtrai.html?u={{rwurl(url[1])}}">Thăm nông trại</a> {% set lv=get('user_'~rwurl(url[1]),'lever')|trim %} 
 {% set lever=get('user_'~login,'lever')|trim %} 
{% if lever=='admin' and lv!='admin'  or lever=='smod' and lv!='admin' and lv!='smod' or lever=='mod' and lv=='mem' %}  · <a id="mi" href="/modules/manager/{{rwurl(url[1])}}"><i class="fal fa-key"></i> Quản lý thành viên</a>{% endif %}{% endif %}
</div></div>
</div><div class="sidebar-wrapper">
<div class="menu">
 {% if login %}
<i class="fal fa-user"></i> Tài khoản: {{tk}}<br/>
<i class="fal fa-fingerprint"></i> ID: {{get(user,'id')}}<br/> 
<i class="fal fa-user-plus"></i> Đăng ký lúc: {{get(user,'reg')|trim|date('H:i d/m/Y','Asia/Ho_Chi_Minh')}}<br />
<i class="fal fa-restroom"></i> Giới tính: {% if get(user,'gt') == 'boy' %}Nam{% else %}Nữ{% endif %}<br />
<i class="fal fa-sack-dollar"></i> Tài sản: {{get(user,'xu')}} Xu<br />
<i class="fal fa-thumbs-up"></i> Thích: {{get(user,'like')}}<br />
<i class="fal fa-comments"></i> Bình luận: {{get(user,'cmt')}}<br />
<i class="fal fa-globe-asia"></i> Trạng Thái: {% if tk=='bot' %}Đang Hoạt Động{% else %}{{ ago(on|trim) }}{% endif %}
</div>
{% endif %}
</div><div class="main-wrapper">
 {% from 'func.twig' import paging,bbcode,ago %} 
{% set login=login()|trim %}
 {% set taolap=get(user,'id') %}
{% set lvs = get('user_'~login,'lever') %}
{% set lvi = get('user_'~tk,'lever') %}
<div class="menublock">
{% if login %}
{% set cmt = get_post( 'comment' )|trim %}
{% set id = get_get('id') %}
{% set act = get_get('act') %}
{% set idl = get('user_'~tk,'id') %}
{% set key2 = get_data_by_id(idl~'chat_ver',id).data|json_decode %}
{% set cs = key2.comment %}
<div id='post_status' style="border-bottom: 1px solid #EBEBEB;">
  <h2><span style='padding: 0 7px 0 0; border-right: 1px solid #ddd'><i class="fa fa-pencil" aria-hidden="true"></i> Tạo bài viết mới</span>{% if login == tk %}
<a id="mi" href="/profile?id=xoa" style="float: right;"><i class="fal fa-trash"></i></a>
{% elseif lvs == 'admin' and lvi != 'admin' or lvs == 'smod' and lvi != 'admin' and lvi !='smod' or lvs == 'mod' and lvi == 'mem' %}
<a id="mi" href="/profile?id=xoa" style="float: right;"><i class="fal fa-trash"></i></a>
{% endif %}</h2>
 <form name="form" method="post" action="">
<script>
function tag(text1, text2) {
if ((document.selection)) {
document.form.comment.focus();
document.form.document.selection.createRange().text = text1+document.form.document.selection.createRange().text+text2;
} else if(document.forms['form'].elements['comment'].selectionStart!=undefined) {
var element = document.forms['form'].elements['comment'];
var str = element.value;
var start = element.selectionStart;
var length = element.selectionEnd - element.selectionStart;
element.value = str.substr(0, start) + text1 + str.substr(start, length) + text2 + str.substr(start + length);
} else {
document.form.nd.value += text1+text2;
}
}
function show_hide(elem) {
obj = document.getElementById(elem);
if( obj.style.display == "none" ) {
obj.style.display = "block";
} else {
obj.style.display = "none";
}
}
</script>
<div id="bbcode"><a href="javascript:tag('[b]', '[/b]')" rel="nofollow"><i class="fa fa-bold"></i></a> <a href="javascript:tag('[i]', '[/i]')" rel="nofollow"><i class="fal fa-italic"></i></a> <a href="javascript:tag('[u]', '[/u]')" rel="nofollow"><i class="fal fa-underline"></i></a> <a href="javascript:tag('[s]', '[/s]')" rel="nofollow"><i class="fal fa-strikethrough"></i></a>
<a href="javascript:tag('[img]', '[/img]')" rel="nofollow"><i class="fal fa-image"></i></a> <a href="javascript:tag('[url=]', '[/url]')" rel="nofollow"><i class="fal fa-link"></i></a> <a href="javascript:tag('[code]', '[/code]')" rel="nofollow"><i class="fal fa-code"></i></a> <a href="javascript:tag('[red]', '[/red]')" rel="nofollow"><span style="font-size:10px;color:red">Text</span></a> <a href="javascript:tag('[blue]', '[/blue]')" rel="nofollow"><span style="font-size:10px;color:blue">Text</span></a> <a href="javascript:tag('[green]', '[/green]')" rel="nofollow"><span style="font-size:10px;color:green">Text</span></a> <a href="javascript:tag('[h2]', '[/h2]')" rel="nofollow"><i class="fal fa-h2"></i></a>
</div>
<div class='content'>
<textarea id="copecute" type="text" name="comment" style="width: 100%;left: 0;height: 50px;padding: 10px;" placeholder="Bạn đang nghĩ gì ?">{% if act == 'edit' %}{{cs}}{% endif %}</textarea>
  </div>
<a id="upload" class='btn_status'><div id="status"><i style='color:#5db98b' class="fal fa-image" aria-hidden="true"></i> Ảnh</div></a>
 <a class='btn_status' id="smilex_button"><i style='color:#cc7762' class="fa fa-heartbeat" aria-hidden="true"></i> Cảm xúc</a>
  <button class='btn_status' type="submit" style='float: right; color: #fff; background: #455b64; border-radius: 4px;margin: 10px 0 0 0;display: inline-block;padding: 5px 15px;'>Đăng</button></form>    <input style="display:none" type="file" id="f" accept="image/*">
</div> 
{% if act == 'xoa' %}
{{delete_data_by_id(idl~'chat_ver',id)}}
<div class="menu">Xong rồi nhé!!!</div>
 <script>window.location.href='/profile{% if login != tk %}/{{tk}}{% endif %}'</script>
{% endif %}
{% if request_method()|lower == "post" %}
{% if cmt %}
{% if act == 'edit' %}
{{ edit(idl~'chat_ver','comment',cmt) }}
<div class="menu">Xong rồi nhé!!!</div>
 <script>window.location.href='/profile{% if login != tk %}/{{tk}}{% endif %}'</script>
{% else %}
{% if login != tk %}
{% set tn=get('user_'~tk,'tuongnha')|trim %}
{{ add('user_'~tk,'tuongnha',tn|trim+1) }}
{% endif %}
{% set comment = {"name" :login,"time":"now"|date('U'), "comment":cmt} %}
{% set status = save_data( taolap~"chat_ver", comment|json_encode ) %}
<script>window.location.href='/profile{% if login != tk %}/{{tk}}{% endif %}'</script>
{% endif %}
{% endif %}
{% endif %}
{% endif %}
{% set data=[] %}
{% set play='yes' %}
{% for i in 1..100 %}
{% if play=='yes' %}
{% set data2=get_data( taolap~'chat_ver',100,i) %}
{% endif %}
{% if data2 %}
{% set data=data2|reverse|merge(data) %}
{% else %}
{% set play='no' %}
{% set data2='' %}
{% endif %}
{% endfor %}
{% set total=data|length %}
{% set page_max=total//10 %}
{% if total//10 != total/10 %}
{% set page_max=total//10+1 %}
{% endif %}
{% set url=get_uri_segments() %}
{% set p=url[1]|default(1) %}
{% if p matches '/[a-zA-z]|%/' or p<1 %}
{% set p=1 %}
{% endif %}
{% if p>page_max %}
{% set p=page_max %}
{% endif %}
{% set st=p*10-10 %}
 {% if id == 'xoa' %}
{% if login == tk %}
{% if total >= '1' %}
<div class="rmenu">Xoá thành công! Tường nhà trống</div>
{% set key = get('user_'~tk,'id')~'chat_ver' %}
{% for i in 1..get_data_count(key) %}
{{ delete_data_by_id(key,get_data(key)|last.id) }}
{% endfor %}
 <script>window.location.href='/profile'</script>
{% else %}
<div class="rmenu">Bình luận trống không cần xoá</div>
 <script>window.location.href='/profile{% if login != tk %}/{{tk}}{% endif %}'</script>
{% endif %}
{% elseif lvs == 'admin' and lvi != 'admin' or lvs == 'smod' and lvi != 'admin' and lvi != 'smod' or lvs == 'mod' and lvi == 'mem' %}
{% if total >= '1' %}
<div class="rmenu">Xoá thành công! Tường nhà trống</div>
{% set key = get('user_'~tk,'id')~'chat_ver' %}
{% for i in 1..get_data_count(key) %}
{{ delete_data_by_id(key,get_data(key)|last.id) }}
{% endfor %}
 <script>window.location.href='/profile{% if login != tk %}/{{tk}}{% endif %}'</script>
{% else %}
<div class="rmenu">Bình luận trống không cần xoá</div>
 <script>window.location.href='/profile{% if login != tk %}/{{tk}}{% endif %}'</script>
{% endif %}
{% else %}
<div class="rmenu">Bạn không có quyền xoá bình luận tường nhà của người này</div>
 <script>window.location.href='/profile{% if login != tk %}/{{tk}}{% endif %}'</script>
{% endif %}
{% else %}
{% if total == '0' %}
<div class="rmenu">Chưa có bài đăng nào</div>
{% endif %}
 {% from 'func.twig' import ago %} 
{% set entries= data|slice(st,10) %}
{% set data='' %} 
{% for tiax in entries %}
{% set entry = tiax.data|json_decode %}
{% set user='user_'~entry.name %}
{% set nd = entry.comment %}
{% set lever=get(user,'lever')|trim %} 
{% set on=get(user,'on')|trim %}
{% set time = entry.time %}
<div class="menu"><div class="list2">
<table id="'$value'" cellpadding="0" cellspacing="1"><tr><td width="auto"><img class="avt" style="border-radius: 50%;border: none;" src="{{get(user,'avt')}}" width="40" height="40" /></td><td>
{% if ic %}
<img src="/images/{{ic}}.png" alt="{{ic}}" />
{% endif %}
<b><a id="mi" href="/profile/{{entry.name}}"><font class="{{lever}}">{{get(user,'nick')}}</font></a></b></span>
<br />
<i class="fal fa-clock"></i> {{ ago(time) }}
</td></tr></table></div>
 
{{bbcode(nd|raw)}}
 <table cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="text-align:left;"> </td><td style="text-align:right;">
{% if login == entry.name %}
<a id="mi" href="/profile{% if login != tk %}/{{tk}}{% endif %}?act=edit&id={{tiax.id}}#tuongnha" class="like"><i class="fal fa-edit"></i></a>
{% elseif lvs == 'admin' and lever != 'admin' or lvs == 'smod' and lever != 'admin' and lever != 'smod' or lvs == 'mod' and lever == 'mem' %}
<a id="mi" href="/profile{% if login != tk %}/{{tk}}{% endif %}?act=edit&id={{tiax.id}}#tuongnha" class="like"><i class="fal fa-edit"></i></a>
{% endif %}
{% if lvs == 'admin' or lvs == 'smod' or lvs == 'smod' or login == tk %}
{% if login == tk %}
<a id="mi" href="/profile{% if login != tk %}/{{tk}}{% endif %}?act=xoa&id={{tiax.id}}#tuongnha" class="like"><i class="fal fa-trash"></i></a>
{% elseif login == entry.name %}
<a id="mi" href="/profile{% if login != tk %}/{{tk}}{% endif %}?act=xoa&id={{tiax.id}}#tuongnha" class="like"><i class="fal fa-trash"></i></a>
{% elseif lvs == 'admin' and lever != 'admin' or lvs == 'smod' and lever != 'admin' and lever != 'smod' or lvs == 'mod' and lever == 'mem' %}
 <a id="mi" href="/profile{% if login != tk %}/{{tk}}{% endif %}?act=xoa&id={{tiax.id}}" class="like"><i class="fal fa-trash"></i></a>
{% endif %}
{% endif %}
</td></tr></tbody></table>
</div>
{% endfor %}
{{ paging(url[0],p,page_max) }}
{% endif %}
{% endif %}
{% endif %}
<script src="/js/api-imgur.js"></script>
<script>
document.querySelector("#upload").onclick = function() {
document.querySelector("#f").click();}
copecute_imgur("#f",{loading : function(load) {document.querySelector("#upload").innerHTML = '<i class="fal fa-spinner fa-spin"></i> '+load},
loaded : function(link,size,type,time) {
var input = $("textarea").val();
$("textarea").val(input+" [img]"+link+"[/img] ");
$("#upload").html('<div id="status"><i style="color:#5db98b" class="fal fa-image" aria-hidden="true"></i> Ảnh</div>');}})
</script>
<script src="/js/auto_tag.js"></script>
<script>var user = []
var data = "{{block('tag')}}"
var sp = data.split("@");
for(i in sp){user[i] = sp [i].trim();}
var input = document.querySelector("#comment");
autocomplete(input,user)
</script>
{% endif %}
 {{ block( 'footer' ) }} 
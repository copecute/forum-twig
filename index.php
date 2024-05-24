{% from 'func.twig' import rwurl,get,login,lever,up,add,edit,auto,paging,bbcode,ago,ca,bo  %}
{% use '_template.php' %}
{% set login=login()|trim %}
{% if login %}
{% set title='Diễn Đàn Cộng Đồng Mod' %}
{{ block( 'header' ) }}
{% set id = get_get('id') %}
{% set act = get_get('act') %}
{% set lv = get('user_'~login,'lever')|trim %}
{% set data=[] %}
{% set play='yes' %}
{% for i in 1..100 %}
{% if play=='yes' %}
{% set data2=get_data('tb',100,i) %}
{% endif %}
{% if data2 %}
{% set data=data2|reverse|merge(data) %}
{% else %}
{% set play='no' %}
{% set data2='' %}
{% endif %}
{% endfor %}
{% set total=data|length %}
{% set entries= data|slice(st,3) %}
{% set data='' %} 
{% if total == '0' %}{% else%}
<div class="menublock">
<div class="phdr"><span>Bảng tin cộng đồng mod</span></div>
{% endif %}
{% for tiax in entries %}
{% set entry = tiax.data|json_decode %}
{% set user='user_'~entry.name %}
{% set nd = entry.comment %}
{% set lever=get(user,'lever')|trim %}
<div class="menu">
  {% if nd|length > 200 %}
{{ nd|slice(0,200)|raw }} ... <a id="mi" href="/modules/thongbao?act=xem&id={{tiax.id}}">Xem thêm >></a>
{% else %} 
{{ bbcode(nd)|raw }}
{% endif %}
{% if act == 'deltb' %}
{{delete_data_by_id('tb',id)}}
<div class="list1">Xong rồi nhé!!!</div>
{% endif %}
<span style="text-align:right;">
{% if lv == 'admin' or lv == 'smod' or lv == 'mod' %}
{% if login == entry.name %}
<a id="mi" href="/modules/thongbao?act=edit&id={{tiax.id}}"><i class="fal fa-edit"></i></a> · <a id="mi" href="?act=deltb&id={{tiax.id}}"><i class="fal fa-trash"></i></a>
{% elseif lv == 'admin' and lever != 'admin' or lv == 'smod' and lever != 'admin' and lever != 'smod' or lv == 'mod' and lever == 'mem' %}
<a id="mi" href="/modules/thongbao?act=edit&id={{tiax.id}}"><i class="fal fa-edit"></i></a> · <a id="mi" href="/modules/thongbao?act=xoa&id={{tiax.id}}"><i class="fal fa-trash"></i></a>
{% endif %}
{% endif %}
</span></div>
{% endfor %}
{% if total == '0' %}
{% else%}
<div class="gmenu"><a id="mi" href="/modules/thongbao"><i class="fal fa-newspaper"></i> Lưu trữ tin tức ({{total}})</a></div>
</div>
{% endif %}
{% if login %}
<div class="menublock">
<script language="javascript"> 
function load_ajax(){ 
$.ajax({ 
url : "/modules/request_chat", 
type : "post", 
dataType:"text", 
data : { 
comment : $("#comment").val() 
}, 
beforeSend:function(){ 
$('#submit').html('<i class="fal fa-spinner fa-spin"></i> Đang gửi...'); 
}, 
success : function (data){ 
$("#chatbox_content").html(data); 
$('#submit').html('Gửi'); 
$("#comment").val(''); 
} 
}); 
}
$.get("/modules/request_chat", function(data){ 
$("#chatbox_content").html(data); 
setInterval(function() {$('#chatbox_content').load('/modules/request_chat');}, 5000);
});
</script>
{% if login %}
{% set cmt = get_post( 'comment' )|trim %}
{% set key = get_data_by_id('chat_ver0',id).data|json_decode %}
{% set cs = key.comment %}
<script>function quote(username,id){content_quote = $("#chat_" + id).html().replace(/<\/?[^>]+>/gi, '').replace(/\s+/g, " ").slice(0,100);
content_quote = "[quote=" + username + "]" + $.trim(content_quote) + "[/quote]";
$("textarea").focus();
$("textarea").val($("textarea").val()+content_quote);}
</script>
 <form id="chatbox" name="form" method="post"><div id='post_status' style="border-bottom: 1px solid #EBEBEB;">
  <h2><span style='padding: 0 7px 0 0; border-right: 1px solid #ddd'><i class="fa fa-pencil" aria-hidden="true"></i> Chatbox</span><span style='padding: 0 7px 0 0; border-right: 1px solid #ddd'> <a id="mi" href="/modules/status">New Feed</a></span><a onclick="if(document.getElementById('bbcode') .style.display=='none') {document.getElementById('bbcode') .style.display=''}else{document.getElementById('bbcode') .style.display='none'}"><span style='margin:0 0 0 8px'>BBcode</span></a>{% if lv=='admin' or lv=='smod' or lv=='smod'  %}<a id="mi" href="?id=xoa" style="float: right;"><i class="fal fa-trash"></i></a>{% endif %}{% endif %}</h2>
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
<div id="bbcode" style="display:none"><a href="javascript:tag('[b]', '[/b]')" rel="nofollow"><i class="fa fa-bold"></i></a> <a href="javascript:tag('[i]', '[/i]')" rel="nofollow"><i class="fal fa-italic"></i></a> <a href="javascript:tag('[u]', '[/u]')" rel="nofollow"><i class="fal fa-underline"></i></a> <a href="javascript:tag('[s]', '[/s]')" rel="nofollow"><i class="fal fa-strikethrough"></i></a>
<a href="javascript:tag('[img]', '[/img]')" rel="nofollow"><i class="fal fa-image"></i></a> <a href="javascript:tag('[url=]', '[/url]')" rel="nofollow"><i class="fal fa-link"></i></a> <a href="javascript:tag('[code]', '[/code]')" rel="nofollow"><i class="fal fa-code"></i></a> <a href="javascript:tag('[noi]', '[/noi]')" rel="nofollow"><i class="fal fa-microphone"></i></a> <a href="javascript:tag('[red]', '[/red]')" rel="nofollow"><span style="font-size:10px;color:red">Text</span></a> <a href="javascript:tag('[blue]', '[/blue]')" rel="nofollow"><span style="font-size:10px;color:blue">Text</span></a> <a href="javascript:tag('[green]', '[/green]')" rel="nofollow"><span style="font-size:10px;color:green">Text</span></a> <a href="javascript:tag('[h2]', '[/h2]')" rel="nofollow"><i class="fal fa-h2"></i></a>
</div>
<div class='content'>
<img src='{{get('user_'~login(),'avt')}}'/>
<textarea style="overflow: hidden;padding:0;margin:0;position:absolute;top:50%;transform:translate(0,-50%);left:50px;color:#666;background:0;border:0;outline:0;font-family:Roboto,sans-serif;font-size:15px;width:89%;" {% if get_get('act') == 'edit' %}{% else %}id="comment" {% endif %}type= "text" name="comment" placeholder="Bạn đang nghĩ gì ?">{% if get_get('act') == 'edit' %}{{cs}}{% endif %}</textarea>
  </div>
{% if act == 'edit' %}
  <button class='btn_status' id="submit" onclick="load_ajax()" style='float: right; color: #fff; background: #455b64; border-radius: 4px;margin: 10px 0 0 0;display: inline-block;padding: 5px 15px;'>Sửa</button>
{% else %}
<a class='btn_status' id="submit" onclick="load_ajax()" style='float: right; color: #fff; background: #455b64; border-radius: 4px;margin: 10px 0 0 0;display: inline-block;padding: 5px 15px;'>Đăng</a>
{% endif %}</form>
<a id="upload" class='btn_status'><div id="status"><i style='color:#5db98b' class="fal fa-image" aria-hidden="true"></i> Ảnh</div></a>
  <a class='btn_status' id="smilex_button"><i style='color:#cc7762' class="fa fa-heartbeat" aria-hidden="true"></i> Cảm xúc</a>
  <a class='btn_status' href='#'><span>...</span></a>
<input style="display:none" type="file" id="f" accept="image/*">
</div><div id="chatbox_content"></div> 
{% if get_get('act') == 'xoa'  and lv=='admin' or lv=='smod' %}
{{delete_data_by_id('chat_ver0',id)}}
<div id="snackbar" class="show">Xóa thành công!</div>
<meta http-equiv="refresh" content="1;url=/">
{% endif %}
{% if request_method()|lower == "post" %}
{% if cmt %}
{% if get_get('act') == 'edit' %}
{{ edit('chat_ver0','comment',cmt) }}
<div id="snackbar" class="show">Chỉnh sửa thành công!</div>
<meta http-equiv="refresh" content="1;url=/">
{% else %}
{{ add('user_'~login,'xu',get('user_'~login,'xu')|trim+10) }} 
{% set comment = {"name" :login,"time":"now"|date('U'), "comment":cmt} %}
{% set status = save_data( "chat_ver0", comment|json_encode ) %}
{% set kq=random(30) %}
{% set so=random(10000) %}
{% if 'bot ơi' in cmt or 'Bot ơi' in cmt or 'BOT ơi' in cmt %}
{% set comment = {"name":"bot","time":"now"|date('U'), "comment":"@"~login~" gọi bot có gì không? :o:"} %}
{% set save = save_data( "chat_ver0", comment|json_encode ) %}
{% elseif 'bot' in cmt or 'Bot' in cmt or 'BOT' in cmt %}
{% set tl =random(['Có ngon thì đừng có chạy :chay:','Để anh cởi quần lót ra đã, anh sẽ cho chú biết tay :buoi:','Yêu cầu các thí chủ yên lặng :troll19:']) %}
{% set comment = {"name":"bot","time":"now"|date('U'), "comment":tl} %}
{% set save = save_data( "chat_ver0", comment|json_encode ) %}
{% elseif 'Quay' in cmt or 'quay' in cmt %}
{% if get('user_'~login,'xu') >='150' %}
{% if kq =='1' %}
{{ add('user_'~login,'xu',get('user_'~login,'xu')|trim+4000) }}
{% set comment = {"name":"bot","time":"now"|date('U'), "comment":"À zí ạ zị. @"~login~" quay được số "~so~"! Xin chúc mừng bạn đã quay được giải nhất của chương trình quay số may mắn! Phần thưởng 4000 xu!"} %}
{% set save = save_data( "chat_ver0", comment|json_encode ) %}
{% elseif kq=='2' %}
{{ add('user_'~login,'xu',get('user_'~login,'xu')|trim+2500) }}
{% set comment = {"name":"bot","time":"now"|date('U'), "comment":"À zí ạ zị. @"~login~" quay được số "~so~"! Xin chúc mừng bạn đã quay được giải nhì của chương trình quay số may mắn! Phần thưởng 2500 xu!"} %}
{% set save = save_data( "chat_ver0", comment|json_encode ) %}
{% elseif kq=='3' %}
{{ add('user_'~login,'xu',get('user_'~login,'xu')|trim+1500) }}
{% set comment = {"name":"bot","time":"now"|date('U'), "comment":"À zí ạ zị. @"~login~" quay được số "~so~"! Xin chúc mừng bạn đã quay được giải ba của chương trình quay số may mắn! Phần thưởng 1500 xu!"} %}
{% set save = save_data( "chat_ver0", comment|json_encode ) %}
{% else %}
{{ add('user_'~login,'xu',get('user_'~login,'xu')|trim-150) }}
{% set comment = {"name":"bot","time":"now"|date('U'), "comment":"Muahaha @"~login~" quay được số "~so~" chúc may mắn lần sau! BOT đã lấy của @"~login~" 150 xu làm chi phí ăn nhậu :troll:
"} %}
{% set save = save_data( "chat_ver0", comment|json_encode ) %}
{% endif %}
{% endif %}
{% endif %}
{% endif %}
{% endif %}
{% endif %}
{% endif %}
{% set data=[] %}
{% set play='yes' %}
{% for i in 1..100 %}
{% if play=='yes' %}
{% set data2=get_data( 'chat_ver0',100,i) %}
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
{% if get_get('id') == 'xoa' and lv=='admin' or lv=='smod' %}
{% if data|length >= '1' %}
<div id="snackbar" class="show">Xoá thành công! Phòng chat trống.</div>

<meta http-equiv="refresh" content="1;url=/">
{% set key = 'chat_ver0' %}
{% for i in 1..get_data_count(key) %}
{{ delete_data_by_id(key,get_data(key)|last.id) }}
{% endfor %}
{% else %}
<div class="rmenu">Nội dung chat box trống không cần xoá</div>
{% endif %}
{% else %}
{% if data|length == '0' %}
{% if login %}
<div class="rmenu">Chưa có nội dung nào</div>
{% endif %}{% endif %}
<div id="chatbox_index">
 {% from 'func.twig' import ago %} 
{% set entries= data|slice(0,5) %}
{% set data='' %}
{% for tiax in entries %}
{% set entry = tiax.data|json_decode %}
{% set user='user_'~entry.name %}
{% set nd = entry.comment %}
{% set lever=get(user,'lever')|trim %} 
{% set on=get(user,'on')|trim %}
{% set time = entry.time %}
{% if login %}
 <div class="menu"><div class="list2"><table  id="'.$value.'" cellpadding="0" cellspacing="1"><tr><td width="auto"><img style="border: none;border-radius: 50%;" class="avt" src="{{get(user,'avt')}}" width="40" height="40" />{% if on < ('now'|date('U')-600) %}{% else %}<span name="online" style="position: absolute;left: 42px;"><i class="fas fa-circle" style="position: absolute;bottom: -44px;color: green;font-size: 11px;"></i></span>{% endif %}</td><td>{% set ic=get(user,'icon') %}
{% if ic %}
<img src="/images/{{ic}}.png" alt="{{ic}}" />
{% endif %}
 <b style="font-size: 16px;"><a id="mi" href="/profile/{{entry.name}}"><font class="{{lever}}">{{get(user,'nick')}}</font></a></b><br />
<div style="font-size: 11px;"><i class="fal fa-clock"></i> {{ ago(time) }}</div>
</td></tr></table></div>
<div style="margin:0 5px;" id="chat_{{tiax.id}}">{{bbcode(nd|raw)}}</div> <table cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="text-align:left;"> </td><td style="text-align:right;">
{% if login == entry.name %}
<a id="mi" href="?act=edit&id={{tiax.id}}" class="like"><i class="fal fa-edit"></i></a>
{% elseif lv=='admin' and lever!='admin'  or lv=='smod' and lever!='admin' and lever!='smod' or lv=='mod' and lever=='mem' %}
<a id="mi" href="?act=edit&id={{tiax.id}}" class="like"><i class="fal fa-edit"></i></a>
{% endif %}
{% if lv=='admin' or lv=='smod' or lv=='mod' %}
{% if login==entry.name %}
<a id="mi" href="?act=xoa&id={{tiax.id}}" class="like"><i class="fal fa-trash"></i></a>
{% elseif lv=='admin' and lever!='admin'  or lv=='smod' and lever!='admin' and lever!='smod' or lv=='mod' and lever=='mem' %}
<a id="mi" href="?act=xoa&id={{tiax.id}}" class="like"><i class="fal fa-trash"></i></a>
{% endif %}
{% endif %}
<a class="like" onclick="quote(&quot;{{get(user,'nick')}}&quot;,&quot;{{tiax.id}}&quot;)"><i class="fal fa-quote-right"></i></a>
</td></tr></tbody></table>
</div>
{% endif %}
{% endfor %}
{% if login %}
{% if total > '5' %}
 <div class="topmenu"><a id="mi" href="/modules/chat">Xem thêm &gt;&gt;</a></div>
{% endif %}
{% endif %}
{% endif %}
{% if login %}</div>{% endif %}</div>
 <div class="menublock">
 <div class="phdr"><span>Bài viết mới</span></div> 
 {% set url=get_uri_segments() %}

{% if url[2] and ca(url[1]) and bo(url[1],url[2]) %}
 <div class="phdr"><span> {{ ca(url[1]) }} » {{ bo(url[1],url[2]) }}</span></div>
 {% set key='bo_'~url[1]~'_'~url[2] %}
{% elseif ca(url[1]) and url[1]%}
<div class="phdr"><span> {{ ca(url[1]) }}</span></div> 
   {% set key='ca_'~url[1] %} 
{% else %}
 {% set key='forum_data' %}
{% endif %} 
 {% set p=url[1]|default(1) %} 
 {{ block( 'forum' ) }} 
 {% set data=get(key)|split('@') %}
 {% set total=data|length-1 %} 
 {% set page_max=total//10 %}
{% if total//10 != total/10 %}
{% set page_max=total//10+1 %}
{% endif %} 
 {{ paging('forum',p,page_max,'.html') }} 
{% if login %}</div><div class="menublock" id="new_cmt">
<style>
#new_cmt div.list1 img{max-width:100px!important;}
#new_cmt div.list1 a{color:black}</style>
 <div class="phdr"><span>Bình Luận Mới</span></div> 
{% set key='new_data' %}
 {% set data=get(key)|split('@') %}
 {% set total=data|length-1 %} 
 {% if total==0 %}
 <div class="rmenu">Chưa có bài viết nào ở đây.</div> 
{% endif %} 

 {% for id in data|slice(0,total)|slice(0,5) %}
{% set entry=id|trim %}
{% set key='cmt_'~entry %} 
 {% set top=get('top_'~entry,'act')|trim %} 
 {% set user = 'user_'~get(key,'ten')|trim %}
 {% set nd = get(key,'nd') %} 

{% set lever=get(user,'lever')|trim %} 
{% set on=get(user,'on')|trim %}
 {% set last=get('th_'~entry)|split('@')|first|trim %} 
<div class="list1"><a id="mi" href="/threads/{{id|trim}}">{% if on < ('now'|date('U')-600) %}{% else %}<i class="fas fa-circle" style="color: green;font-size: 11px;"></i>{% endif %} <b><font class="{{lever}}">{{get(user,'nick')}}</font></b> : {% set re=get(key,'re')|trim %}
{% if re %}
<b>@{{get(('user_'~get('cmt_'~re,'ten')|trim),'nick')|trim}},</b>{% endif %} 
 {% set nd_edit=get(key,'nd_edit') %} 
{% if nd_edit %}{% set nd=nd_edit %}{% endif %}
 {% if nd|length > 200 %}
{{ nd|slice(0,200)|raw }} ...
{% else %} 
{{ bbcode(nd)|raw }}
{% endif %}
 {% if nd_edit %}
 <div class="edit">{{ get(key,'type_edit') }} bởi: {{get('user_'~get(key,'editer')|trim,'nick') }}</div>
{% endif %}
</a></div>
{% endfor %}
{% if total > '5' %}
 <div class="topmenu"><a id="mi" href="/old">Cũ hơn &gt;&gt;</a></div>
{% endif %}
 {% endif %}</div>
 </div><div class="sidebar-wrapper"><div class="menublock">
 <div class="phdr"><span> Danh mục bài viết</div>
 {% for k,v in ca()|json_decode %}
 <div class="list1"><img src="/images/{{loop.index}}.png" />
 <a id="mi" href="/threads/{{k}}" title="{{v}}">{{v}}</a></div>
{% endfor %}
 {% if login %}
<div class="list1">
<img src="/images/{{ca()|json_decode|length+1}}.png" /> <a id="mi" href="/threads/thung-rac" title="Thùng Rác">Thùng Rác</a></div>
{% endif %}
</div>
{% from 'func.twig' import add,get,up,lever %}
 <div class="menublock">
<div class="phdr"><span>Top đại gia</span></div>
{% set data=[] %}{% for i in 1..100 %}{% set data=get_data('id_users',100,i)|merge(data) %}{% endfor %}
{% set listxu %}{% for i in data %}{% set user = i.data %}{% set xu = get('user_'~user,'xu')|trim %}{{xu}}#{% endfor %}{% endset %}
{% set listname %}{% for i in data %}{% set user = i.data %}{% set xu = get('user_'~user,'xu')|trim %}{{user}}#{{xu}}.{% endfor %}{% endset %}
{% set listtop %}{% for i in listxu|split('#')|sort|reverse %}{% for top in listname|split('.') %}{% if '#'~i in top %}{{top}}.{% endif %}{% endfor %}{% endfor %}{% endset %}
{% set list=[] %}{% for i in listtop|split('.') %}{% if i not in list %}{% set list=list|merge([i]) %}{% endif %}{% endfor %}
{% for i in list|slice(0,6) %}
{% set giang = i|split('#') %}
{% set lv = get('user_'~giang[0],'lever')|trim %}
{% set names = get('user_'~giang[0],'nick')|trim %}
{% if loop.last==false %}
<div class="list1"><img src="/images/{{loop.index}}.png"> <a id="mi" href="/profile/{{giang[0]}}"><b class="{{lv}}">{{names}}</b></a> - {{giang[1]}} xu</div>
{% endif %}
{% endfor %}
</div><div class="menublock">
<div class="phdr"><span>Menu</span></div>
<div class="list1"><img src="/images/1.png" /> <a id="mi" href="/users/bxh">Bảng xếp hạng</a></div>
<div class="list1"><img src="/images/2.png" /> <a id="mi" href="/users">Danh sách thành viên</a></div>
{% set total=get('forum_data')|split('@')|length-1 %}
{% set total2=listxu|split('#')|length-1 %}
</div><div class="menublock">
<div class="phdr"><span>Thống kê diễn đàn</span></div><div class="list1">Bài viết: <a id="mi" href="/threads"><b><font color="red">{{total}}</font></b></a></div>
<div class="list1">Thành viên: <a id="mi" href="/users"><b><font color="red">{{total2}}</font></b></a>
</div><div class="list1">
{% set nick = data[total2-1].data %}
 {% set tt = 'user_'~nick %}
{% set ic=get(tt,'icon') %}
Thành viên mới: {% if ic %}<img src="/images/{{ic}}.png" alt="{{ic}}" /> {% endif%} <a id="mi" href="/profile/{{nick}}"><b><font class="{{get(tt,'lever')}}">{{get(tt,'nick')}}</font></b></a>
</div>
{% set data=get('on_total')|json_decode %}
{% if ("now"|date("U") - data|first) > 300 %}
{{ up('on_total',data|slice(1,data|length)|json_encode) }}
{% endif %}
{{ up('on_total',get('on_total')|json_decode|sort|json_encode) }}
{# gán tài khoản thành viên là biến login nhé #}
{% if get_data_count('online')>0 %}
{% set nickon = login|trim %}
{% set time_now = "now"|date("U") %}
{% if login %}
{{add('online',nickon,time_now)}}
{% endif %}
{% set data=get('online')|json_decode %} 
{% set i=0 %} 
{% set online={} %} 
{% set list_online %} 
{% for user,time in data|sort %} 
{% if time>=(time_now-300) %} 
{% set i=i+1 %}
{% set online=online|merge({(user):time}) %}
{% set tt ='user_'~user %}
{% set ic = get(user,'icon') %}
{% if ic %}<img src="/images/{{ic}}.png" /> {% endif %}<a href="/profile/{{user}}"><span class="{{get(tt,'lever')}}">{{get(tt,'nick')}}</span></a>{% if loop.last==false %}, {% endif %}
{% endif %} 
{% endfor %} 
{% endset %}
</div><div class="menublock">
 <div class="phdr"> Online [{{i}}/{{ get('on_total')|json_decode|length }}] </div>
<div class="list1">
{% if i == '0' %}
Không có thành viên nào online
{% endif %}
{{list_online}}
{{update_data_by_id('online',get_data('online')|last.id,online|json_encode)}}
</div>
{% else %}
{% set save = save_data("online",[]|json_encode ) %}
{% endif %}</div>

<script src="https://copecute.github.io/forum/js/api-imgur.js"></script>
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
 {{ block( 'footer' ) }}
{% else %}
{% include 'account' %}
{% endif %}
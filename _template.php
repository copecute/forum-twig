{% block header %}
 {% from 'func.twig' import get,login,add,up %} 
 {% set login=login()|trim %}
 {% set url=get_uri_segments() %}
{% if login %}
{{ add('user_'~login,'on','now'|date('U')) }}
 {% if get_data_count('on_data') == 0 %}
{% set save=save_data('on_data',' '~login~' @ ') %}
{% else %}
 {% set save=up('on_data',login,'up') %} 
{% endif %} 
{% endif %} 
 <!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="theme-color" content="#455b64">
<title>{{title|default('Cộng Đồng Mod Android')|raw}}</title>
{{seo|default('')|raw}}
<link type="text/css" rel="stylesheet" href="{{ dir.css }}/style.css?v={{ "now"|date('U') }}" media="all,handheld"/>
<link rel="stylesheet" href="https://copecute.github.io/css/all.css" media="all">
  <link rel="icon" href="https://android-developer.tk/favicon.ico" type="image/png">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
<copecute>
 <div class="header" style="height: 49px!important;">
{% if login %}
<div class="header_logo">{%else%}<div style="float: left;padding: 7px 15px 0;">{%endif%}
<a id="mi" href="/"><img alt="Cộng Đồng Mod" src="//1.bp.blogspot.com/-uCcLEqnys2U/XD8nXq3vMEI/AAAAAAAACkM/3kDSeikbtPk9UCJXtry07UXXtr9mPRemwCPcBGAYYCw/s1600/logo-color-40x40.png"><h1 style="display:none">Cộng Đồng Mod Android Trên Facebook</h1></a>
</div>

{% if login %}
<div class="header_search">
<form action="/search.php" method="get"><input type="search" name="id" placeholder="Nhập từ khóa tìm kiếm..." style="border-radius: 20px 0 0 20px!important;margin-right: -5px;"><button type="submit" style="background: #455b64;height: 37px;border-radius: 0 20px 20px 0;"><i class="fal fa-search" style="padding: 5px;"></i></button></form>
</div>
<div class="header_right">
<table class="header_item" width="100%" border="0"><tbody>
<td width="16%" align="center" style="font-size:20px;"><a style="display: inline-block;width: 100%;text-align: center;padding: 10px 0;color:#455b64" href="/" id="mi"><i class="fal fa-newspaper"></i></a></td>
<td id="game" width="16%" align="center" style="font-size:20px;"><a style="display: inline-block;width: 100%;text-align: center;padding: 10px 0;color:#455b64" href="/game" id="mi"><i class="{% if url[0] == 'game' %}_3w6y fas{% else %}fal{% endif %} fa-gamepad"></i></a></td>
<td id="search" width="16%" align="center" style="font-size:20px;"><a style="display: inline-block;width: 100%;text-align: center;padding: 10px 0;color:#455b64" href="/search.php" id="mi"><i class="{% if url[0] == 'search.php' %}_3w6y fas{% else %}fal{% endif %} fa-search"></i></a></td>
<td width="16%" align="center" style="font-size:20px;"><a style="display: inline-block;width: 100%;text-align: center;padding: 10px 0;color:#455b64" href="/video" id="mi"><i class="{% if url[0] == 'video' %}_3w6y fas{% else %}fal{% endif %} fa-play"></i></a></td>
{% set mail=get('user_'~login,'mail')|trim %}
{% if mail==1 %}
<td width="16%" align="center" style="padding: 5px 0;"><div class="dropdown">
<button class="dropbtn" style="font-size:20px;color: #455b64;"><i class="{% if url[0] == 'messages' %}_3w6y fas{% else %}fal{% endif %} fa-comment-lines"></i>
<span class="noti">1</span>
</button>
<div class="dropdown-content" style="right:auto">
<a href="/messages/{{ get('unread_mail_'~login)|split('@')|first|trim }}">Tin nhắn từ {{get('user_'~(get('unread_mail_'~login)|split('@')|first|trim),'nick')}}</a>
<a id="mi" style="text-align: center;border-top: 1px solid #e9e9e9;" href="/messages">Xem tất cả</a>
</div>
{% elseif mail>1 %}
<td width="16%" align="center" style="padding: 5px 0;"><div class="dropdown">
<button class="dropbtn" style="font-size:20px;color: #455b64;"><i class="{% if url[0] == 'messages' %}_3w6y fas{% else %}fal{% endif %} fa-comment-lines"></i>
<span class="noti">{{mail}}</span>
</button>
<div class="dropdown-content" style="right:auto">
{% set login = login() %} {% set key = "unread_mail_"~login|trim %} {% for mail in get(key)|split("@") %} {% if mail|trim!="" %} <a href="/mail/{{ mail|trim }}">{{ mail|trim }}</a> {% endif %} {% endfor %}
<a id="mi" style="text-align: center;border-top: 1px solid #e9e9e9;" href="/messages">Xem tất cả</a>
</div>
{% else %}
<td width="16%" align="center" style="font-size: 20px;" id="loadheader"><a style="display: inline-block;width: 100%;text-align: center;padding: 10px 0;color:#455b64" href="/messages" id="mi"><i class="{% if url[0] == 'messages' %}_3w6y fas{% else %}fal{% endif %} fa-comment-lines"></i>
{% endif %}
</a></td>

<td width="16%" align="center" style="padding: 5px 0;"><div class="dropdown">
    <button class="dropbtn" style="font-size:20px;color: #455b64;"><i class="{% if url[0] == 'notification' %}_3w6y fas{% else %}fal{% endif %} fa-bell"></i>
{% set noti=get('user_'~login,'notification')|trim %}
{% if noti and noti>1 %}<span class="noti">{{noti}}</span>{% elseif noti and noti==1 %}<span class="noti">1</span>{% endif %}

 {% if get_data_count('follow_unread_'~login)>0 %}
{% set fol = get('follow_unread_'~login)|trim|split('@')|length %}
{% if fol > 1 %}<span class="noti">{{fol-1}}</span>{% endif %}{% endif %}

 {% if get_data_count('notification_like_unread_'~login)>0 %}
{% set fol = get('notification_like_unread_'~login)|trim|split('@')|length %}
{% if fol > 1 %}<span class="noti">{{fol-1}}</span>{% endif %}{% endif %}
   </button>
    <div class="dropdown-content" style="right:5px">
{% set noti=get('user_'~login,'notification')|trim %}
{% if noti and noti>1 %}
<a href="/notification">{% for u in get('notification_name_'~login)|trim|split('@')|slice(0,get('notification_name_'~login)|trim|split('@')|length-1) %}{{get(('user_'~u|trim),'nick')}}{% if loop.last==false %} , {%endif %}{% endfor %} đã trả lời trong {{noti}} Bình luận</a><style><style>#no-noti{display:none!important}</style>
{% elseif noti and noti==1 %}<a href="/notification">{{get(('user_'~get('notification_name_'~login)|split('@')|first|trim),'nick')}} đã trả lời Bình luận của bạn</a><style>#no-noti{display:none!important}</style>
{% endif %} 

 {% if get_data_count('follow_unread_'~login)>0 %}
{% set fol = get('follow_unread_'~login)|trim|split('@')|length %}
{% if fol > 1 %}
<a href="/notification/follow">{% for u in get('follow_name_'~login)|trim|split('@')|slice(0,get('follow_name_'~login)|trim|split('@')|length-1) %}{{get(('user_'~u|trim),'nick')}}{% if loop.last==false %} , {%endif %}{% endfor %} cũng đã trả lời trong {{fol-1}} bài viết mà bạn quan tâm</a><style>#no-noti{display:none!important}</style>
{% endif %}
 {% endif %} 

 {% if get_data_count('notification_like_unread_'~login)>0 %}
{% set fol = get('notification_like_unread_'~login)|trim|split('@')|length %}
{% if fol > 1 %}
<a href="/notification/like">{% for u in get('notification_like_name_'~login)|trim|split('@')|slice(0,get('notification_like_name_'~login)|trim|split('@')|length-1) %}{{get(('user_'~u|trim),'nick')}}{% if loop.last==false %} , {%endif %}{% endfor %} đã thích {{fol-1}} bài viết của bạn</a><style>#no-noti{display:none!important}</style>
{% endif %}
{% endif %}
<span id="no-noti" style="float: none;color: black;padding: 12px 16px;text-decoration: none;text-align: left;display: block;">không có thông báo mới</span>
<a id="mi" style="text-align: center;border-top: 1px solid #e9e9e9;" href="/notification">Xem tất cả</a>
</div></div></td>

<td width="16%" align="center" style="padding: 0px 0;">
<div class="dropdown">
    <button class="dropbtn" style="font-size:20px;padding: 0px 0px;"> 
<img class="avt" src="{{get('user_'~login(),'avt')}}" width="36" height="36" style="border-radius: 50%;border: none;">
{% set tn=get('user_'~login,'tuongnha')|trim %}{% if tn > 0 %}<span class="noti">{{tn}}</span>{% endif %} 
</button>
    <div class="dropdown-content">
{% set tn=get('user_'~login,'tuongnha')|trim %}
{% if tn > 0 %}
<a href="/profile?act=tuongnha#new">Tường nhà của bạn có {{tn}} bình luận mới</a>
{% else %}
<a id="mi" href="/profile">{{get('user_'~login(),'nick')}}</a>{% endif %} 
      <a id="mi" href="/chucnang">Chức năng</a>
{% set lv=get('user_'~login,'lever')|trim %} 
{% if lv=='admin' or lv=='smod' or lv=='mod' %}      <a id="mi" href="/modlog">Lịch sử quản lí</a>
{% endif %}
      <a id="mi" href="/game">Trò chơi</a>
      <a id="mi" href="/profile?act=change_info.php">Cài đặt tài khoản</a>
      <a id="mi" href="/account/logout.php" style="color:#d25252;">Đăng xuất</a>
    </div>
  </div></td>
</tbody></table></div>
{% else %}
<div class="header_right" style="width: 100%;position: absolute;">
<table class="header_item" style="float: right;" width="30%" border="0"><tbody><tr>
<td width="20%" align="center" style="font-size: 20px;">
<a style="color:#455b64" href="/account"><i class="fal fa-sign-in-alt"></i></a></td>
<td width="20%" align="center" style="padding: 5px 0;height: 37px;">
<a style="font-size: 20px;color: #455b64;" href="/account/register.php"><i class="fal fa-user-plus"></i></a></td>
</tr></tbody></table></div>
{% endif %}
</div>
<div class="main-container">
<noscript><div class="rmenu">Hãy bật JavaScript để có thể trải nghiệm được toàn bộ tính năng của diễn đàn <b>Cộng Đồng Mod</b> một cách tốt nhất</div></noscript>
<div class="main-wrapper">

{# Code online #}
{% if ip() %}
 {% if get_data_count('on_total') == 0 %}
{% set save=save_data('on_total','{"ip_'~ip()~'":"'~"now"|date("U")~'"}') %}
{% else %}
 {{ add('on_total','ip_'~ip(),"now"|date("U")) }} 
{% endif %} 
{% endif %}
    {% endblock %}
 
{% block footer %}
 </div><div class="footer" align="center">Ip: {{ip()}}<br />Cộng Đồng Mod © 2019
</div><a href="/creater" id="mi" class="post"><i class="fal fa-pen"></i> <span>Tạo bài viết</span></a>
<div id="smilex_content"></div>
<script>
$(document).ready(function(){
$("#smilex_button").click(function(){
$("#smilex_content").load("/modules/smilex");});});
</script>
</copecute>
<script src="https://code.responsivevoice.org/responsivevoice.js?key=lpMqvTPS"></script>
<script src="https://copecute.github.io/forum/js/autoLoad.js"></script>
</body>
</html>
{% endblock %}

 {% block forum %}
 {% from 'func.twig' import rwurl,get,ago,ca,bo %}
 {% set data=get(key)|split('@') %}
 {% set total=data|length-1 %} 
 {% if total==0 %}
 <div class="rmenu">Chưa có bài viết nào ở đây.</div> 
{% endif %} 
 {% set page_max=total//10 %}
{% if total//10 != total/10 %}
{% set page_max=total//10+1 %}
{% endif %}
{% set url=get_uri_segments() %}

{% if p matches '/[a-zA-z]|%/' or p<1 %}
{% set p=1 %}
{% endif %}
{% if p>page_max %}
{% set p=page_max %}
{% endif %}
{% set st=p*10-10 %}

 {% for id in data|slice(0,total)|slice(st,10) %}
{% set id=id|trim %}
{% set key='top_'~id %} 
{% set title=get(key,'title') %}
 {% set first=get(key,'first') %} 
 {% set last=get(key,'last') %}
 {% set tot=get('th_'~id)|split('@')|length-1 %}
{% set sub=bo(get('top_'~id,'ca')|trim,get('top_'~id,'bo')|trim) %} 
 {% if title|trim matches '/^\\[(.+?)\\](.+?)$/' %}
{% set sub=title|split(']')|first|split('[')|last|raw %}
{% set title=title|split(']',2)|last|raw %}
{% endif %} 


 <div class="list1">
<table id="{{id}}" cellpadding="0" cellspacing="1"><tr><td width="55px"><img class="avt" src="{{get('user_'~first,'avt')}}" width="50" height="50" alt="{{first}}"/></td> <td width="5px"></td> <td><h2 style="font-size: large;"><a style="color:#3c4043" id="mi" href="/threads/{{id}}/{{rwurl(title)}}.html" title="{{title|raw}}">{{title|raw}}</a></h2>
<span style="background: #f1f1f1;border-radius: 3px;padding: 2px 5px;margin-right:2px;"><i class="fal fa-folder-open"></i> {{ sub|raw }}</span> <span style="background: #f1f1f1;border-radius: 3px;padding: 2px 5px;"><i class="fal fa-eye"></i> {{ get('view_'~id)|trim }} </span></td></tr></table></div> 
{% endfor %}

{% endblock %}
 {% block share %}
</div><div class="sidebar-wrapper"><div class="phdr">Chia sẻ</div>
 <div class="list1">BBCode: <br/><input type="text" value="[url=https://forum.android-developer.tk/{{url[0]}}/{{id}}/{% if p>1 %}{{p}}-{% endif %}{{link}}.html]{{title|raw}}[/url]" size="12%" ><br/>Link:<br/> <input type="text" value="https://forum.android-developer.tk/{{url[0]}}/{{id}}/{% if p>1 %}{{p}}-{% endif %}{{link}}.html" size="12" ></td></div>
{% endblock %}
 {% block tag %}
{% from 'func.twig' import rwurl,get,login,lever,up,add,paging %}{% set data=[] %}{% set play='yes' %}{% for i in 1..100 %}{% if play=='yes' %}{% set data2=get_data( 'id_users',100,i) %}{% endif %}{% if data2 %}{% set data=data2|reverse|merge(data) %}{% else %}{% set play='no' %}{% set data2='' %}{% endif %}{% endfor %}{% set entries= data|slice(st,10) %}{% set data='' %}{% for taolap in entries %}{% set copecute = taolap.data %}{% set user = 'user_'~copecute|striptags~get(key,'ten')|trim %}{{copecute|striptags}} @{% endfor %}
{% endblock %}
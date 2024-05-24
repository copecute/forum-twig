{% from 'func.twig' import login,up,add,get,paging,del %}
{% use '_template.php' %}
{% set title='Tìm kiếm' %}
{{block('header')}}
<div class="phdr"><span>Tìm kiếm bài viết trong diễn đàn</span></div>
<div class="menu"><form action="/search.php" method="get"><input type="text" name="id" value="{{get_get('id')}}"><input type="submit" value=" Tìm "></form></div>
{% set data = get('forum_data')|split('@') %}
{% set data1 %}{% for i in data %}{% set ten = get('top_'~i|trim,'title') %}{% set key = get_get('id') %}
{% if key|length>'0' and key in ten|trim %}{% if loop.last==false %}{{i|trim}}.{% endif %}{% endif %}{% endfor %}{% endset %}
{% set dem = data1|split('.')|length-1 %}
{% if dem > '0' %}
<div class="rmenu"> Có {{dem}} kết quả được tìm thấy</div>
{% else %}
{% if get_get('id')|length > 0 %}
<div class="rmenu"> Không tìm thấy kết quả nào </div>
{% endif %}
<div class="menu"> Lưu ý ô tìm kiếm ko dc để trống </div>
{% endif %}
 {% set data=data1|split('.') %}
 {% set total=data|length-1 %} 
{% set per = '2' %}
 {% set page_max=total//per %}
{% if total//per != total/per %}
{% set page_max=total//per+1 %}
{% endif %}
 {% set url=get_get('p') %}
{% set p=url|default('1') %} 

{% if p matches '/[a-zA-z]|%/' or p<1 %}
{% set p=1 %}
{% endif %}
{% if p>page_max %}
{% set p=page_max %}
{% endif %}
{% set st=p*per-per %}
 {% for id in data|slice(0,total)|slice(st,per) %}
{% set link = 'top_'~id|trim %}
{% set ten = get(link,'title') %}
<div class="menu"><a id="mi" href="/threads/{{id|trim}}">{{ten}}</a></div>
{% endfor %}
{% if page_max>per %}
{% set page_max=per %} 
 {% endif %} 
 {{ paging('search.php?id='~get_get('id')~'&p',p,page_max) }}
<style>.main-wrapper{width: 100%!important;}
.post{display:none;!important;}</style>
{{block('footer')}}
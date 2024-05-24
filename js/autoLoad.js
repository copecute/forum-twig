$('body').on("click", 'a#mi', function(mi) {
mi.preventDefault();
url = $(this).attr('href');
copecute(url, false);});
var state = {name: location.href, page: document.title};
window.history.pushState(state, document.title, location.href);
$(window).on("popstate", function(){
if(history.state){
copecute(history.state.name, true);}});
function copecute(link,pop){
$("copecute").append('');
$.get(link,"", function(data_html){
var title = data_html.split('<title>')[1].split('</title>')[0];
var body = data_html.split('<copecute>')[1].split('</copecute>')[0];
$("title").text(title);
$("copecute").html(body);
if(pop != true){
var state = {name: link, page: title};
window.history.pushState(state, title, link);}
$('html,body').animate({scrollTop:0},200);});}
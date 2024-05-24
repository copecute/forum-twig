function GET(callback){
var xhttp = new XMLHttpRequest() || ActiveXObject();
    xhttp.onreadystatechange = function () {
        
        if (this.readyState == 4 && this.status == 200) {
            
            callback(this.responseText)
        }
    }
    xhttp.open('GET','tag.txt',true);
    xhttp.send();
}
function autocomplete(inp, arr) {
 var currentFocus;
 var fix,inra;
inp.addEventListener("input", function(e) {
  var sp = this.value.split("@");
  if(/@/i.test(this.value)){
     fix = sp[1];
    if(sp.length >= 3){
      
      fix = sp[sp.length-1]
    }
    
          
  var a, b, i, val = fix;
     closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
     a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
     this.parentNode.appendChild(a);
    for (i = 0; i < arr.length; i++) {
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
        b = document.createElement("DIV");
         b.innerHTML = "<strong style='color:#FF7D7C'>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
        b.addEventListener("click", function(e) {
          
                     var t = inp.value.slice(0,inp.value.length-sp[sp.length-1].length-1)
           inp.value = t+"@"+this.getElementsByTagName("input")[0].value+" ";
         
             closeAllLists();
          });
          a.appendChild(b);
        }
      }
    
  }
  });
/*inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
       currentFocus++;
       addActive(x);
      } else if (e.keyCode == 38) { //up
      currentFocus--;
      addActive(x);
      } else if (e.keyCode == 13) {
        e.preventDefault();
        if (currentFocus > -1) {
       if (x) x[currentFocus].click();
        }
      }
  });*/
  function addActive(x) {
  if (!x) return false;
 removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
  x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
  for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
      x[i].parentNode.removeChild(x[i]);
    }
  }
}
document.addEventListener("click", function (e) {
    closeAllLists(e.target);
});
}
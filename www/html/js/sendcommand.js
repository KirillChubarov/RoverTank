$(document).ready(function() {
    /* button click detection start
     $(":button").click(function(event){
    var a= new XMLHttpRequest();
    a.open("GET", "/php/marsohod1.php?q=" + event.target.id, true);
    a.onreadystatechange=function(){
        if(a.readyState==4){ 
        if(a.status ==200){
            var myObj = JSON.parse(a.responseText);
            document.getElementById("sn").innerHTML = myObj[0];
        } else alert ("http error"); } }
    a.send();
    });   
    /* button click detection end */

    /* keyboard press detection start */
    $("body").on("keydown", function(event) {
      if ( this.className === 'hold' ) { return false; }
           this.className = 'hold';

        var a= new XMLHttpRequest();
        a.open("GET", "/php/marsohod1.php?q=" + event.keyCode, true);
        a.onreadystatechange=function(){
            if(a.readyState==4){ 
            if(a.status==200){
                var myObj = JSON.parse(a.responseText);
                document.getElementById("sn").innerHTML = myObj[0];
            } else alert ("http error"); } }
        a.send();
        //alert(event.keyCode + ' 1 ');
    });
     /* keyboard press detection end */
});

$("body").on("keyup", function(event) {
        this.className = '';
});
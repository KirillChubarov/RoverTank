<html>
    <head>
        <title>Марсоход</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <img src="http://buran.club:45001/stream/video.mjpeg" alt="image">
        <div></div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> <!-- Желательно это хранить локально, чтобы работало без интернета -->

        <script type="text/javascript">

             $(document).ready(function() {
             $('#forward').click(function(){
             var a= new XMLHttpRequest();
             a.open("GET", "forward.php");
             a.onreadystatechange=function(){
             if(a.readyState==4){ 
             if(a.status ==200){
              } else alert ("http error"); } }
             a.send();
             });
             });

             $(document).ready(function() {
             $('#backward').click(function(){
             var a= new XMLHttpRequest();
             a.open("GET", "backward.php");
             a.onreadystatechange=function(){
             if(a.readyState==4){ 
             if(a.status ==200){
              } else alert ("http error"); } }
             a.send();
             });
             });

             $(document).ready(function() {
             $('#left').click(function(){
             var a= new XMLHttpRequest();
             a.open("GET", "left.php");
             a.onreadystatechange=function(){
             if(a.readyState==4){ 
             if(a.status ==200){
              } else alert ("http error"); } }
             a.send();
             });
             });

             $(document).ready(function() {
             $('#right').click(function(){
             var a= new XMLHttpRequest();
             a.open("GET", "right.php");
             a.onreadystatechange=function(){
             if(a.readyState==4){ 
             if(a.status ==200){
              } else alert ("http error"); } }
             a.send();
             });
             });


             $(document).ready(function() {
             $('#forward_step').click(function(){
             var a= new XMLHttpRequest();
             a.open("GET", "forward_step.php");
             a.onreadystatechange=function(){
             if(a.readyState==4){ 
             if(a.status ==200){
              } else alert ("http error"); } }
             a.send();
             });
             });

             $(document).ready(function() {
             $('#backward_step').click(function(){
             var a= new XMLHttpRequest();
             a.open("GET", "backward_step.php");
             a.onreadystatechange=function(){
             if(a.readyState==4){ 
             if(a.status ==200){
              } else alert ("http error"); } }
             a.send();
             });
             });

             $(document).ready(function() {
             $('#left_step').click(function(){
             var a= new XMLHttpRequest();
             a.open("GET", "left_step.php");
             a.onreadystatechange=function(){
             if(a.readyState==4){ 
             if(a.status ==200){
              } else alert ("http error"); } }
             a.send();
             });
             });

             $(document).ready(function() {
             $('#right_step').click(function(){
             var a= new XMLHttpRequest();
             a.open("GET", "right_step.php");
             a.onreadystatechange=function(){
             if(a.readyState==4){ 
             if(a.status ==200){
              } else alert ("http error"); } }
             a.send();
             });
             });


             $(document).ready(function()
             { $('#stop').click(function(){
             var a= new XMLHttpRequest();
             a.open("GET", "stop.php");
             a.onreadystatechange=function(){
             if(a.readyState==4){
             if(a.status ==200){
              } else alert ("http error"); } }
             a.send();
             });
             });

       </script>

       <button id="forward_step" type="button"> Шаг Вперед </button>
       <button id="backward_step" type="button"> Шаг Назад </button>
       <button id="left_step" type="button"> Шаг Влево </button>
       <button id="right_step" type="button"> Шаг Вправо </button>

       <div></div>

       <button id="forward" type="button"> Вперед </button>
       <button id="backward" type="button"> Назад </button>
       <button id="left" type="button"> Влево </button>
       <button id="right" type="button"> Вправо </button>
       <button id="stop" type="button"> Стоп </button>

    </body>
</html>


<?php echo $display_message;?>
<table width="320" border="0">
  <tr>
    <td><div align="center"><a href="/cake/top/top/">トップに戻る</a> / <a href="/cake/quest/datalist/<?php echo $member_quest_id;?>">捜査に戻る</a></div></td>
  </tr>
</table>
<!--[if IE]><script type="text/javascript" src="http://bank.blamestitch.com/js/excanvas_r3/excanvas.compiled.js"></script><![endif]-->
<div style="text-align:center;">
<canvas id="testCanvas" width="320" height="320" style="border:0px solid #CCC;"></canvas>
</div>
<script type="text/javascript">
//制御
var timerID;
var cW=320;
var cH=320;
var back_X=0;
var back_Y=0;
var human_X=-50;
var human_Y=0;
window.onload = function(){
  setTimer();
}
//フレームレート
function setTimer(){
  clearInterval(timerID);
  timerID = setInterval("setMove()", 100);
}
//制御
function setMove(){
  back_X-=5;
  //if(back_X<-2000){
  //  back_X=0;
  //}
  human_X+=1;
  if(human_X>=80){
    human_X = 100;
  }
  draw();
}
var i=0;
//描画
function draw(){
  //Canvas
  var canvas=document.getElementById('testCanvas');
  if (!canvas||!canvas.getContext) return false;
  var ctx = canvas.getContext('2d');
  //refresh
  //ctx.clearRect(0,0,cW,cH);
  //images
  back_img = new Image();
  back_img.src =  "http://bank.blamestitch.com/img/movie/quest_sucsess/back.png?142";
  pika_img = new Image();
  pika_img.src =  "http://bank.blamestitch.com/img/movie/quest_sucsess/pika.png?1442";
  human_img = new Image();
  human_img.src = "http://bank.blamestitch.com/img/movie/quest_sucsess/human.png?1421";
  char_img = new Image();
  char_img.src =  "http://bank.blamestitch.com/img/movie/quest_sucsess/char.png?1442";

  ctx.drawImage(back_img, back_X, back_Y);
  if(i%5==0){
  ctx.drawImage(pika_img, 0, 0);
  }
  ctx.drawImage(human_img, human_X, human_Y);
  i+=1;
  //if(i%10==0){
    //ctx.drawImage(char_img, 0, 100);
  //}else{
    ctx.drawImage(char_img, 0, 0);
  //}

  //文字表示（２行 19文字まで）
  ctx.font = "18px 'ＭＳ Ｐゴシック'";
  ctx.fillStyle = "White";
  ctx.fillText("<?php echo $display_message_1;?>",10,250);
  ctx.fillText("<?php echo $display_message_2;?>",10,270);
}
</script>
<table width="320" border="0">
  <tr>
    <td><div align="center"><a href="/cake/top/top/">トップに戻る</a> / <a href="/cake/quest/datalist/<?php echo $member_quest_id;?>">捜査に戻る</a></div></td>
  </tr>
</table>

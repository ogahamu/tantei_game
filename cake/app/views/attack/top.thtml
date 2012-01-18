<style type="text/css">
<!--
body {
  background-color: #000000;
}
-->
</style>
<!--[if IE]>
<script type="text/javascript" src="./libs/excanvas_r3/excanvas.compiled.js"></script>
<![endif]-->
<a href="/cake/help/page4/">Q.解き方</a>
<div style="text-align:center;">
<canvas id="canvas" width="320" height="480" style="background-color: #000000"></canvas>
</div>
<a href="/cake/help/page4/">Q.解き方</a>
<script type="text/javascript">
//制御
var cW=320;
var cH=480;
var objX=100;
var objY=100;
var maxHouseNum=9;
//画像
var imgW=47;
var imgH=125;
//マウス座標
var mouseX;
var mouseY;
var mouseSphere=25;
//得点
var score=0;
var lv=1;
var past_second=0;
//残り回数
var max_challenge_count=<?php echo $max_challenge_count; ?>;
var challenge_count=0;
var result_char='';
//ページ遷移
var page_move_flag = 0;
/*描画の準備*/
var canvas = document.getElementById("canvas");
var ctx = canvas.getContext("2d");
var enemies = new Array(maxHouseNum);
var movie_y = -400;
enemies[0] = new initEnemy(50,50,<?php echo $num_0;?>);
enemies[1] = new initEnemy(130,50,<?php echo $num_1;?>);
enemies[2] = new initEnemy(210,50,<?php echo $num_2;?>);
enemies[3] = new initEnemy(50,185,<?php echo $num_3;?>);
enemies[4] = new initEnemy(130,185,<?php echo $num_4;?>);
enemies[5] = new initEnemy(210,185,<?php echo $num_5;?>);
enemies[6] = new initEnemy(50,320,<?php echo $num_6;?>);
enemies[7] = new initEnemy(130,320,<?php echo $num_7;?>);
enemies[8] = new initEnemy(210,320,<?php echo $num_8;?>);
/*各フレームレートで実行する*/
setInterval("draw()", 100);
setInterval("score_check()", 100);
function score_check(){
  if(score >= 3){
    result_char = 'win';
    load_win_movie();
  }
  if(challenge_count >= max_challenge_count){
    result_char = 'lose';
    load_lose_movie();
  }
}
/*的１個ずつの状態を保つメソッド（配列に入れて使用する）*/
function initEnemy(x,y,genre_id){
  this.genre_id = genre_id;
  this.x = x;
  this.y = y;
  this.img_count = 1;
  this.a_img_count =1;
  this.b_img_count =1;
  this.appear_flag=1;
  this.delete_flag=1;
  this.hit_flag=0;
  this.dont_kill_flag=0;
  this.section_flag=0;
}

/*的の同時出現数を調整する*/
function draw(){
  //ctx.clearRect(0,0,cW,cH);
  //敵１人ずつの動きをシュミレート
  for(var i=0;i<maxHouseNum;i++){
    move(enemies[i]);
  }
  /*得点の表示*/
  ctx.clearRect(0,0,320,50);
  ctx.font = "16px 'ＭＳ Ｐゴシック'";
  ctx.fillStyle = "Red";
  ctx.fillText("残り回数 "+Math.ceil(max_challenge_count-challenge_count)+"回",50,20);
  ctx.fillText("手掛かり "+score+"/3",50,35);
  //ctx.fillText("集めた証拠の数:  " + max_challenge_count,50,25);
  //ctx.fillText("得点:  " + score,5,20);
  //ctx.fillText("挑戦数:  " + challenge_count,5,32,10);
}

/*制御の本体*/
function move(initEnemy){
  if(initEnemy.delete_flag==1 && initEnemy.hit_flag==0){
    moveEnemy(initEnemy);
  }else if(initEnemy.hit_flag==1 && initEnemy.genre_id == 0){
    missEnemy(initEnemy);
  }else if(initEnemy.hit_flag==1 && initEnemy.genre_id > 0){
    hitEnemy(initEnemy);
  }
}

/*カード_デフォルト*/
function moveEnemy(initEnemy){
  enemy_5 = new Image();
  enemy_5.src = "/img/game/1-1.png";
  ctx.drawImage(enemy_5, initEnemy.x, initEnemy.y);
}


/*的＿敵（停止中）*/
function deleteEnemy(initEnemy){
  enemy_1 = new Image();
  enemy_1.src = "/img/game/1-1.png";
  ctx.drawImage(enemy_1,initEnemy.x,initEnemy.y);
  //初期化
  initEnemy.a_img_count=1;
  initEnemy.b_img_count=1;
  initEnemy.img_count=1;
  initEnemy.hit_flag=0;
  challenge_count+=1;
}

/*結果_成功*/
function load_win_movie(){
  result_a_1 = new Image();
  result_a_1.src = "http://bank.blamestitch.com/cake/app/webroot/img/attack_result.gif";
  ctx.drawImage(result_a_1,0,movie_y);
  movie_y+=50;
  if(movie_y>=50){
    movie_y = 0;
    if(page_move_flag==0){
      page_move_flag = 1;
      location.href='http://bank.blamestitch.com/cake/attack/win/<?php echo $quest_id; ?>/#header-menu/';
    }
  }
}
/*結果_失敗*/
function load_lose_movie(){
  result_a_1 = new Image();
  result_a_1.src = "http://bank.blamestitch.com/cake/app/webroot/img/attack_result.gif";
  ctx.drawImage(result_a_1,0,movie_y);
  movie_y+=50;
  if(movie_y>=50){
    movie_y = 0;
    if(page_move_flag==0){
      page_move_flag = 1;
      location.href='http://bank.blamestitch.com/cake/attack/lose/<?php echo $quest_id; ?>/#header-menu/';
    }
  }
}
/*カード_ヒット_ミス*/
function missEnemy(initEnemy){
  enemy_b_1 = new Image();
  enemy_b_1.src = "/img/game/1-2.png";
  enemy_b_2 = new Image();
  enemy_b_2.src = "/img/game/1-3.png";
  enemy_b_3 = new Image();
  enemy_b_3.src = "/img/game/1-4.png";
  enemy_b_4 = new Image();
  enemy_b_4.src = "/img/game/1-4.png";
  enemy_b_5 = new Image();
  enemy_b_5.src = "/img/game/1-4.png";
  movie_img = eval("enemy_b_" + initEnemy.b_img_count);
  ctx.drawImage(movie_img,initEnemy.x,initEnemy.y);
  initEnemy.b_img_count+=1;
  if(initEnemy.b_img_count>5){initEnemy.b_img_count=5;}
  if(initEnemy.b_img_count>5){initEnemy.b_img_count=5;}
  if(initEnemy.b_img_count == 2 && initEnemy.dont_kill_flag == 1){
    //score-=1;
  }else if(initEnemy.b_img_count == 2 && initEnemy.dont_kill_flag == 0){
    //score+=1;
    challenge_count+=1;
  }
}


/*カード_ヒット１*/
function hitEnemy(initEnemy){
  enemy_a_1 = new Image();
  enemy_a_1.src = "/img/game/2-2.png";
  enemy_a_2 = new Image();
  enemy_a_2.src = "/img/game/2-3.png";
  enemy_a_3 = new Image();
  enemy_a_3.src = "/img/game/2-4.png";
  enemy_a_4 = new Image();
  enemy_a_4.src = "/img/game/2-5.png";
  enemy_a_5 = new Image();
  enemy_a_5.src = "/img/game/2-5.png";
  movie_img = eval("enemy_a_" + initEnemy.a_img_count);
  ctx.drawImage(movie_img,initEnemy.x,initEnemy.y);
  initEnemy.a_img_count+=1;
  if(initEnemy.a_img_count>5){initEnemy.a_img_count=5;}
  if(initEnemy.a_img_count == 2 && initEnemy.dont_kill_flag == 1){
    //score-=1;
  }else if(initEnemy.a_img_count == 2 && initEnemy.dont_kill_flag == 0){
    score+=1;
    challenge_count+=1;
  }
}
//マウス座標
canvas.onmousedown = mouseDownListner;
function mouseDownListner(e) {
  var hit_value;
  //マウス座標の取得
  adjustXY(e);
  hit_value = hitJudgement();
}
/*当たり判定 当たり:Trueを返す 外れ:Falseを返す*/
function hitJudgement(){
  for(var i=0;i<maxHouseNum;i++){
    if(enemies[i].delete_flag==1){
      enemy_x = enemies[i].x;
      enemy_y = enemies[i].y;
      var judgeValue = true;
      if(enemy_x + imgW/2 -mouseSphere < mouseX){
      }else{
        judgeValue = false;
      }
      if(enemy_x + imgW/2 +mouseSphere > mouseX){
      }else{
        judgeValue = false;
      }
      if(enemy_y + imgH/2 -mouseSphere < mouseY){
      }else{
        judgeValue = false;
      }
      if(enemy_y+ imgH/2 +mouseSphere > mouseY){
      }else{
        judgeValue = false;
      }
      if(judgeValue == true){
        //当たり！
        enemies[i].hit_flag = 1;
      }
    }
  }
  return false;
}

//呼びだし時にマウス座標を返す関数
function adjustXY(e) {
  var rect = e.target.getBoundingClientRect();
  mouseX = e.clientX - rect.left;
  mouseY = e.clientY - rect.top;
}
//回転運動を検知
$(document).ready(function(){
  var agent = navigator.userAgent;
    if(agent.search(/iPhone/) != -1){
    /*iphone*/
    window.onorientationchange = function(){
      var iR = Math.abs(window.orientation);
      (iR==90)? alert('90do kaiten'):null
    }
  }else{
    /*android*/
    window.onresize = function(){
      (iR==90)?	alert('90do kaiten'):null
    }
  }
});
</script>
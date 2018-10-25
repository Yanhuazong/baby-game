<?php
	echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>");
	session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; UTF-8" />
    <title>Baby game</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Dear baby</title>
    <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="CanvasInput-master/CanvasInput.js"></script>
</script>
    <style>
        body {
        background: #dddddd;
        width:100%;
        height:100%;
        }

        canvas {
        display:block;
        margin:auto;
        background: #ffffff;
        cursor: pointer;
        }
    </style>
</head>

<body onload="startGame()">

<?php
if(empty($_SESSION["login"]))
{
    echo 'Please <a href="login.php">login</a> first!';
}
else

{
    echo '<div class="display">Welcome '.$_SESSION["login"].'&nbsp;&nbsp;&nbsp;&nbsp;<a class="link" href="logout.php">Logout</a></div>';

if(!empty($_SESSION["babyname"]))
{
    echo '<div class="displayname">Baby Name: '.$_SESSION["babyname"].'</div>';
}

?>
<div class="displayname" style="padding-top:10px;background-color:white;text-align:right;font-size:15px;color:grey;width:770px;border-left: 10px solid #dcefee;border-right: 10px solid #dcefee;">
<form class="example" id="search" method="post" action="doSearch.php" style="max-width:300px;margin-left:auto;margin-right:15px;">
<input type="text" placeholder="Put a name here to find a playdate..." name="babysearch" id="babysearch">
<button class="button" type="submit"><i class="fa fa-search"></i></button>
</form>

</div>
<canvas id='canvas' width='800' height='500'>
      Canvas not supported
</canvas>
<?php
include("includes/openDbconn.php");
$sql="SELECT * FROM data WHERE user1='".$_SESSION["login"]."' OR user2='".$_SESSION["login"]."' AND Babyname='".$_SESSION["babyname"]."'";
$result=mysqli_query($db, $sql);
$row = mysqli_fetch_array($result);
if($row["user1"]!=$row["user2"])
    {
        if($row["user1"]==$_SESSION["login"])
        echo '<div class="display">Joint caregiver <span>'.$row["user2"].'</span></div>';
        else
        echo '<div class="display">Joint caregiver <span>'.$row["user1"].'</span></div>';
    }
else
    {
?>
<div class="display">
<form action="doRegister2.php" method="post">
    <ul id="register2">
            <li> <label title="UserID" for="UserID">Username <span>*</span></label> <input type="text" name="UserID" id="UserID" size="15" maxlength="30" /></li>
            <li> <label title="Passwd" for="Passwd">Password <span>*</span></label> <input type="text" name="Passwd" id="Passwd" size="15" maxlength="30" /></li>
            <li> <label title="PasswdConfirm" for="PasswdConfirm">Confirm Password <span>*</span></label> <input type="text" name="PasswdConfirm" id="PasswdConfirm" size="15" maxlength="30" /></li>
    </ul>
    <div id="errorMsgregister"><?php if(!empty($_SESSION["errorMessage"])){echo($_SESSION["errorMessage"]);unset($_SESSION["errorMessage"]);} ?></div>
    <input id="SubmitBtnregister3" name="SubmitBtn" type="submit" value="Add a caregiver" />
</form>
<div>

<script type="text/javascript"><!--
	document.getElementById("UserID").focus();
-->	</script>

<?php
    }    
?>

<script>
// Create the canvas
var canvas = document.getElementById("canvas");
var context = canvas.getContext("2d");
//button parameters
var  bX=30,
    bY=70,
    bW=80,
    bH=30,
    d=60,
    d1=25,
    pX=670,
    pY=30,
    pW=100,
    pH=10;

//guest baby
//idle image
var nimageReady=new Array();
var nimages=new Array();
var nimagesName=["larm","rarm","lleg","rleg","diaper","body", "head", "loeye","roeye","mouth","leyeb","reyeb","hair"];
for(var i=0;i<13;i++)
{
    nimageReady[i]=false;
    nimages[i]=new Image();
}

//move image
var nmimageReady=new Array();
var nmimages=new Array();
var nmimagesName=["larmup","rarmup","lleg","rleg","diaper","body", "head", "loeye","roeye","mouth","leyeb","reyeb","hair"];
for(var i=0;i<13;i++)
{
    nmimageReady[i]=false;
    nmimages[i]=new Image();
}

//happy image
var nhimageReady=new Array();
var nhimages=new Array();
var nhimagesName=["larmup","rarmup","llegup","rlegup","diaper","body", "head", "lseye","rseye","smouth","leyeb","reyeb","hair"];
for(var i=0;i<13;i++)
{
    nhimageReady[i]=false;
    nhimages[i]=new Image();
}

//baby
//idle image
var imageReady=new Array();
var images=new Array();
var imagesName=["larm","rarm","lleg","rleg","diaper","body", "head", "loeye","roeye","mouth","leyeb","reyeb","hair"];
for(var i=0;i<13;i++)
{
    imageReady[i]=false;
    images[i]=new Image();
}

//move image
var mimageReady=new Array();
var mimages=new Array();
var mimagesName=["larmup","rarmup","lleg","rleg","diaper","body", "head", "loeye","roeye","mouth","leyeb","reyeb","hair"];
for(var i=0;i<13;i++)
{
    mimageReady[i]=false;
    mimages[i]=new Image();
}

//happy image
var himageReady=new Array();
var himages=new Array();
var himagesName=["larmup","rarmup","llegup","rlegup","diaper","body", "head", "lseye","rseye","smouth","leyeb","reyeb","hair"];
for(var i=0;i<13;i++)
{
    himageReady[i]=false;
    himages[i]=new Image();
}

//sad baby with wet diaper
var swimageReady=new Array();
var swimages=new Array();
var swimagesName=["larm","rarm","lleg","rleg","wetdiaper","body", "head", "lseye","rseye","sadmouth","leyeb","reyeb","hair"];
for(var i=0;i<13;i++)
{
    swimageReady[i]=false;
    swimages[i]=new Image();
}

//sad baby
var simageReady=new Array();
var simages=new Array();
var simagesName=["larm","rarm","lleg","rleg","diaper","body", "head", "lseye","rseye","sadmouth","leyeb","reyeb","hair"];
for(var i=0;i<13;i++)
{
    simageReady[i]=false;
    simages[i]=new Image();
}

//hungrey sad baby
var hsimageReady=new Array();
var hsimages=new Array();
var hsimagesName=["larm","rarm","lleg","rleg","diaper","body", "head", "lheye","rheye","hmouth","leyeb","reyeb","hair"];
for(var i=0;i<13;i++)
{
    hsimageReady[i]=false;
    hsimages[i]=new Image();
}

//hungrey wet baby
var hwimageReady=new Array();
var hwimages=new Array();
var hwimagesName=["larm","rarm","lleg","rleg","wetdiaper","body", "head", "lheye","rheye","hmouth","leyeb","reyeb","hair"];
for(var i=0;i<13;i++)
{
    hwimageReady[i]=false;
    hwimages[i]=new Image();
}

// Bottle image
var bottleReady = false;
var bottleImage = new Image();
bottleImage.onload = function () {
	bottleReady = true;
};
bottleImage.src = 'image/bottle.png';
// diaper image
var diaperReady = false;
var diaperImage = new Image();
diaperImage.onload = function () {
	diaperReady = true;
};
diaperImage.src = 'image/diaper.png';
// toybox image
var boxReady = false;
var boxImage = new Image();
boxImage.onload = function () {
	boxReady = true;
};
boxImage.src = 'image/toybox.png';
// toy1 image
var toy1Ready = false;
var toy1Image = new Image();
toy1Image.onload = function () {
	toy1Ready = true;
};
toy1Image.src = 'image/toy1.png';
// toy2 image
var toy2Ready = false;
var toy2Image = new Image();
toy2Image.onload = function () {
	toy2Ready = true;
};
toy2Image.src = 'image/toy2.png';
// toy3 image
var toy3Ready = false;
var toy3Image = new Image();
toy3Image.onload = function () {
	toy3Ready = true;
};
toy3Image.src = 'image/toy3.png';
// crib image
var cribReady = false;
var cribImage = new Image();
cribImage.onload = function () {
	cribReady = true;
};
cribImage.src = 'image/crib.png';

//objects
var baby={
    x:150,
    y:155
};
var drawbaby;
var healthBar;
var happinessBar;
var comfortBar;
var milkButton;
var playButton;
var diaperButton;

function progressbar(x,y,width,width1,height,speed,type)
{
    this.x=x;
    this.y=y;
    this.width=width;
    this.width1=width1;
    this.height=height;
    this.type=type;
    this.speed=speed;

    this.update=function(){
    context.font="12px Arial";
    context.fillStyle="dimgrey";
    context.fillText(this.type,this.x-80,this.y+10);
    context.strokeStyle = "grey";
    context.strokeRect(this.x,this.y,this.width,this.height);
    context.fillStyle="green";
    context.fillRect(this.x,this.y,this.width1,this.height);

    if(this.width1<0.01)
        {
            this.width1=0;
        }
        else{
            this.width1-=this.speed;
        }
    }

}

function buttons(x,y,width,height,color,type)
{
    this.x=x;
    this.y=y;
    this.width=width;
    this.height=height;
    this.color=color;
    this.type=type;
    this.update = function() {
        context.fillStyle=this.color;
        context.fillRect(this.x,this.y,this.width,this.height);
        context.font="15px Arial";
        context.fillStyle="white";
        context.fillText(this.type,this.x+10,this.y+20);
    }
}

// Draw buttons

function makebuttons()
{
    milkButton=new buttons(bX,bY,bW,bH,"green","MILK");
    playButton=new buttons(bX,bY+2*d,bW,bH,"blue","PLAY");
    diaperButton=new buttons(bX,bY+d,bW,bH,"orange","DIAPER");
}


function clear(){
    context.clearRect(0, 0, canvas.width, canvas.height);
}

//mouse event click button
function windowToCanvas(canvas, x, y) {
   var bbox = canvas.getBoundingClientRect();
    return { 
        x: x - bbox.left * (canvas.width  / bbox.width),
        y: y - bbox.top  * (canvas.height / bbox.height)
        };
}
var happy=false;
var wet=false;
var hungry=false;
var hungryandwet=false;
var sad=false;
var bottle=false;
var bottleXHome=100;
var bottleYHome=70;
var bottleX=bottleXHome,bottleY=bottleYHome,bottleW=50,bottleH=50;
var diaper=false;
var diaperXHome=120;
var diaperYHome=140;
var diaperX=diaperXHome,diaperY=diaperYHome,diaperW=90,diaperH=40;
var toybox=false;
var toyboxXHome=20;
var toyboxYHome=230;
var toyboxX=toyboxXHome,toyboxY=toyboxYHome,toyboxW=105,toyboxH=160;
var toy1=false;
var toy1XHome=150;
var toy1YHome=160;
var toy1X=toy1XHome,toy1Y=toy1YHome,toy1W=120,toy1H=60;
var toy2=false;
var toy2XHome=150;
var toy2YHome=210;
var toy2X=toy2XHome,toy2Y=toy2YHome,toy2W=120,toy2H=90;
var toy3=false;
var toy3XHome=150;
var toy3YHome=260;
var toy3X=toy3XHome,toy3Y=toy3YHome,toy3W=120,toy3H=80;
var loeyeXHome=baby.x+197;
var loeyeX=0;
var nloeyeX=0;
var roeyeX=0;
var nroeyeX=0;
var oeyeY=0;
var toyleft=false;
var toyright=false;
var toyup=false;
var toydown=false;
canvas.onclick = function (e) {
   var loc = windowToCanvas(canvas, e.clientX, e.clientY);

   //click milk button
    if(loc.x>milkButton.x&&loc.x<milkButton.x+milkButton.width&&loc.y>milkButton.y&&loc.y<milkButton.y+milkButton.height)
        {
            bottle=true;
        }
    //click play button
    if(loc.x>playButton.x&&loc.x<playButton.x+playButton.width&&loc.y>playButton.y&&loc.y<playButton.y+playButton.height)
        {
            toybox=!toybox;
        }
    //click diaper button
    if(loc.x>diaperButton.x&&loc.x<diaperButton.x+diaperButton.width&&loc.y>diaperButton.y&&loc.y<diaperButton.y+diaperButton.height)
        {
            diaper=true;
        }
    //click toy1
    if(loc.x>toyboxX-toy1W/2&&loc.x<toyboxX+toy1W/2&&loc.y>toyboxY&&loc.y<toyboxY+toyboxH/3)
        {
            toy1=true;
        }
    //click toy2
    if(loc.x>toyboxX-toy1W/2&&loc.x<toyboxX+toy1W/2&&loc.y>toyboxY+toyboxH/3&&loc.y<toyboxY+toyboxH*2/3)
        {
            toy2=true;
        }
    //click toy3
    if(loc.x>toyboxX-toy1W/2&&loc.x<toyboxX+toy1W/2&&loc.y>toyboxY+2*toyboxH/3&&loc.y<toyboxY+toyboxH)
        {
            toy3=true;
        }
}
function land()
        {
            happy = false;
        }
canvas.onmousemove=function(e)
       {
            var loc = windowToCanvas(canvas, e.clientX, e.clientY);
    //        console.log(loc.x,loc.y);
            //get bottle
            if(bottle)
            {
                if(bottleX-bottleW/2< loc.x &&bottleX + bottleW/2 > loc.x &&
                bottleY-bottleH/2 < loc.y &&bottleY + bottleH/2 > loc.y)
                {
                    bottleX=loc.x;
                    bottleY=loc.y;
                }
            }
            //bottle disappear at mouth
            if(bottleX>baby.x+176&&bottleX<baby.x+210&&bottleY>baby.y&&bottleY<baby.y+50)
            {
                bottle=false;
                bottleX=bottleXHome;
                bottleY=bottleYHome;
                happymove();
                healthBar.width1+=50;

                if (healthBar.width1>pW)
                {
                    healthBar.width1=pW;
                }
            }
            //get diaper
            if(diaper)
            {
                if(diaperX-diaperW/2< loc.x &&diaperX + diaperW/2 > loc.x &&
                diaperY-diaperH/2 < loc.y &&diaperY + diaperH/2 > loc.y)
                {
                    diaperX=loc.x;
                    diaperY=loc.y;
                }
            }
            //diaper disappear
            if(diaperX>baby.x+176&&diaperX<baby.x+210&&diaperY>baby.y+75&&diaperY<baby.y+125)
            {
                diaper=false;
                diaperX=diaperXHome;
                diaperY=diaperYHome;
                happymove();
                comfortBar.width1+=50;

                if (comfortBar.width1>pW)
                {
                    comfortBar.width1=pW;
                }
            }
            //move toy1
            if(toy1)
            {
                if(loc.x>toy1X-toy1W/2&&loc.x<toy1X+toy1W/2&&loc.y>toy1Y-toy1H/2&&loc.y<toy1Y+toy1H/2)
                {
                    toy1X=loc.x;
                    toy1Y=loc.y;
                if(!wet&&!hungry&&!hungryandwet)
                {
                    if (happinessBar.width1<pW/4)
                    {
                        happinessBar.width1=pW/4;
                    }

                    else if (happinessBar.width1>pW)
                    {
                        happinessBar.width1=pW;
                    }
                    else happinessBar.width1+=0.1;
                    }
                    if(happinessBar.width1>pW/2&&comfortBar.width1>pW/4&&healthBar.width1>pW/4)
                    {
                        happymove();
                    }

                }
                if (toy1X>baby.x&&toy1X<baby.x+130)
                {
                     toyleft=true;

                }
                if (toy1X>baby.x+130&&toy1X<baby.x+210&&toy1Y<baby.y-50&&toy1Y>0)
                {
                    toyup=true;
                }
                if (toy1X>baby.x+130&&toy1X<baby.x+210&&toy1Y>baby.y-50&&toy1Y<baby.y+100)
                {
                    toydown=true;
                }
                if (toy1X>baby.x+210&&toy1X<baby.x+500)
                {
                    toyright=true;
                }

            }
            if(toy1X>toyboxX&&loc.x<toyboxX+0.2*toyboxW&&loc.y>toyboxY&&loc.y<toyboxY+toyboxH)
            {
                toy1=false;
            }

        //move toy2
        if(toy2)
            {
                if(loc.x>toy2X-toy2W/2&&loc.x<toy2X+toy2W/2&&loc.y>toy2Y-toy2H/2&&loc.y<toy2Y+toy2H/2)
                {
                    toy2X=loc.x;
                    toy2Y=loc.y;
                if(!wet&&!hungry&&!hungryandwet)
                {
                if (happinessBar.width1<pW/4)
                {
                    happinessBar.width1=pW/4;
                }

                else if (happinessBar.width1>pW)
                {
                    happinessBar.width1=pW;
                }
                else happinessBar.width1+=0.1;
                }
                if(happinessBar.width1>pW/2&&comfortBar.width1>pW/4&&healthBar.width1>pW/4)
                {
                    if (!happy)
                    {
                        happy = true;
                        setTimeout(land, 150);
                    }
                }

                }
                if (toy2X>baby.x&&toy2X<baby.x+130)
                {
                     toyleft=true;

                }
                if (toy2X>baby.x+130&&toy2X<baby.x+210&&toy2Y<baby.y-50&&toy2Y>0)
                {
                    toyup=true;
                }
                if (toy2X>baby.x+130&&toy2X<baby.x+210&&toy2Y>baby.y-50&&toy2Y<baby.y+100)
                {
                    toydown=true;
                }
                if (toy2X>baby.x+210&&toy2X<baby.x+500)
                {
                    toyright=true;
                }

            }
            if(toy2X>toyboxX&&loc.x<toyboxX+0.2*toyboxW&&loc.y>toyboxY&&loc.y<toyboxY+toyboxH)
            {
                toy2=false;
            }

             //move toy3
        if(toy3)
            {
                if(loc.x>toy3X-toy3W/2&&loc.x<toy3X+toy3W/2&&loc.y>toy3Y-toy3H/2&&loc.y<toy3Y+toy3H/2)
                {
                    toy3X=loc.x;
                    toy3Y=loc.y;

                if(!wet&&!hungry&&!hungryandwet)
                {
                if (happinessBar.width1<pW/4)
                {
                    happinessBar.width1=pW/4;
                }

                else if (happinessBar.width1>pW)
                {
                    happinessBar.width1=pW;
                }
                else happinessBar.width1+=0.1;
                }
                if(happinessBar.width1>pW/2&&comfortBar.width1>pW/4&&healthBar.width1>pW/4)
                {
                    if (!happy)
                    {
                        happy = true;
                        setTimeout(land, 150);
                    }
                }

                }
                if (toy3X>baby.x&&toy3X<baby.x+130)
                {
                     toyleft=true;

                }
                if (toy3X>baby.x+130&&toy3X<baby.x+210&&toy3Y<baby.y-50&&toy3Y>0)
                {
                    toyup=true;
                }
                if (toy3X>baby.x+130&&toy3X<baby.x+210&&toy3Y>baby.y-50&&toy3Y<baby.y+100)
                {
                    toydown=true;
                }
                if (toy3X>baby.x+210&&toy3X<baby.x+500)
                {
                    toyright=true;
                }

            }
            if(toy3X>toyboxX&&loc.x<toyboxX+0.2*toyboxW&&loc.y>toyboxY&&loc.y<toyboxY+toyboxH)
            {
                toy3=false;
            }
        }
function happymove()
{
    if (!happy)
        {
            happy = true;
            setTimeout(land, 500);
        }
}
function moveeye()
{
    if(toyleft)
    {

         loeyeX=-1;
         roeyeX=-1;
         toyleft=false;
     }
    if(toyup)
    {
        oeyeY=-1;
         toyup=false;
    }
    if(toydown)
    {
          oeyeY=+1;
         toydown=false;
    }
    if(toyright||newbaby)
    {
        loeyeX=+1;
         roeyeX=+1;
         toyright=false;
    }
  

}

function drawtoy1()
{
    if(toy1)
    {
    context.drawImage(toy1Image, toy1X, toy1Y,toy1W,toy1H);
    }
}
function drawtoy2()
{
    if(toy2)
    {
    context.drawImage(toy2Image, toy2X, toy2Y,toy2W,toy2H);
    }
}
function drawtoy3()
{
    if(toy3)
    {
    context.drawImage(toy3Image, toy3X, toy3Y,toy3W,toy3H);
    }
}
function drawtoybox()
{
    if(toybox)
    {
    context.drawImage(boxImage, toyboxX, toyboxY,toyboxW,toyboxH);
    }
}
function drawbottle()
{
    if(bottle)
    {
    context.drawImage(bottleImage, bottleX, bottleY,bottleW,bottleH);
    }
}
function drawdiaper()
{
    if(diaper)
    {
    context.drawImage(diaperImage, diaperX, diaperY,diaperW,diaperH);
    }
}
function drawEllipse(centerX, centerY, width, height) {

  context.beginPath();

  context.moveTo(centerX, centerY - height/2);

  context.bezierCurveTo(
    centerX + width/2, centerY - height/2,
    centerX + width/2, centerY + height/2,
    centerX, centerY + height/2);

  context.bezierCurveTo(
    centerX - width/2, centerY + height/2,
    centerX - width/2, centerY - height/2,
    centerX, centerY - height/2);

  context.fillStyle = "#1a0d00";
  context.fill();
  context.closePath();
}

var maxEyeHeight = 12;
var curEyeHeight = maxEyeHeight;
var eyeOpenTime = 0;
var timeBtwBlinks = 8000;
var blinkUpdateTime = 200;

function blink() {

  curEyeHeight -= 1;
  if (curEyeHeight <= 0)
    {
        eyeOpenTime = 0;
        curEyeHeight = maxEyeHeight;
    } else
    {
        setTimeout(blink, 10);
    }
}

var messagelocx=400,messagelocy=100;
function drawbaby(x,y)
{
    this.x=x;
    this.y=y;
    this.update=function()
    {
        eyeOpenTime += blinkUpdateTime;
        if(eyeOpenTime >= timeBtwBlinks)
        {
            blink();
        }
        //draw happy baby
        if(happy)
        {
            // var himagesName=["larmup","rarmup","llegup","rlegup","diaper","body", "head", "loeye","roeye","mouth","leyeb","reyeb"];
            var himageWidth=[110,110,110,110,90,90,80,14,14,30,20,20,80];
            var himageHeight=[140,140,120,120,40,100,80,12,12,15,5,5,80];
            var himageX=[this.x-80,this.x+60,this.x-72,this.x+55,this.x,this.x,this.x+4,this.x+20,this.x+52,this.x+29,this.x+18,this.x+50,this.x+2];
            var himageY=[this.y-40,this.y-40,this.y+77,this.y+77,this.y+92,this.y,this.y-70,this.y-36,this.y-36,this.y-10,this.y-48,this.y-48,this.y-71];
            for(var i=0;i<13;i++)
            {
                if(himageReady[i]=true)
                {
                    context.drawImage(himages[i], himageX[i], himageY[i],himageWidth[i],himageHeight[i]);
                }
            }
        }
        //draw hungry baby
        else if(hungry){
        // var swimagesName=["larm","rarm","lleg","rleg","wetdiaper","body", "head", "lseye","rseye","sadmouth","leyeb","reyeb"];
            var hsimageWidth=[80,80,50,50,90,90,80,14,14,20,20,20,80];
            var hsimageHeight=[100,100,120,120,40,100,80,12,12,10,5,5,80];
            var hsimageX=[this.x-60,this.x+70,this.x-25,this.x+65,this.x,this.x,this.x+4,this.x+20,this.x+52,this.x+34,this.x+18,this.x+50,this.x+2];
            var hsimageY=[this.y,this.y,this.y+105,this.y+105,this.y+92,this.y,this.y-70,this.y-36,this.y-36,this.y-10,this.y-48,this.y-48,this.y-71];
            for(var i=0;i<13;i++)
            {
                if(hsimageReady[i]=true)
                {
                    context.drawImage(hsimages[i], hsimageX[i], hsimageY[i],hsimageWidth[i],hsimageHeight[i]);
                  //  console.log("hungry");
                }
            }
            context.font="15px Arial";
            context.fillStyle="#fcfcfc";
            context.fillRect(messagelocx-10,messagelocy-20,100,30);

            context.fillStyle="#db8c1e";
            context.fillText("I'm hungry!",messagelocx,messagelocy);
        }
        else if(hungryandwet){
        // var swimagesName=["larm","rarm","lleg","rleg","wetdiaper","body", "head", "lseye","rseye","sadmouth","leyeb","reyeb"];
            var hwimageWidth=[80,80,50,50,90,90,80,14,14,20,20,20,80];
            var hwimageHeight=[100,100,120,120,40,100,80,12,12,10,5,5,80];
            var hwimageX=[this.x-60,this.x+70,this.x-25,this.x+65,this.x,this.x,this.x+4,this.x+20,this.x+52,this.x+34,this.x+18,this.x+50,this.x+2];
            var hwimageY=[this.y,this.y,this.y+105,this.y+105,this.y+92,this.y,this.y-70,this.y-36,this.y-36,this.y-10,this.y-48,this.y-48,this.y-71];
            for(var i=0;i<13;i++)
            {
                if(hwimageReady[i]=true)
                {
                    context.drawImage(hwimages[i], hwimageX[i], hwimageY[i],hwimageWidth[i],hwimageHeight[i]);
                }
            }
            context.fillStyle="#fcfcfc";
            context.fillRect(messagelocx-10,messagelocy-20,150,30);

            context.font="15px Arial";
            context.fillStyle="#db8c1e";
            context.fillText("I'm hungry and wet!",messagelocx,messagelocy);
        }
        //draw sad baby
        else if(sad){
        // var swimagesName=["larm","rarm","lleg","rleg","wetdiaper","body", "head", "lseye","rseye","sadmouth","leyeb","reyeb"];
            var simageWidth=[80,80,50,50,90,90,80,14,14,30,20,20,80];
            var simageHeight=[100,100,120,120,40,100,80,12,12,15,5,5,80];
            var simageX=[this.x-60,this.x+70,this.x-25,this.x+65,this.x,this.x,this.x+4,this.x+20,this.x+52,this.x+29,this.x+18,this.x+50,this.x+2];
            var simageY=[this.y,this.y,this.y+105,this.y+105,this.y+92,this.y,this.y-70,this.y-36,this.y-36,this.y-10,this.y-48,this.y-48,this.y-71];
            for(var i=0;i<13;i++)
            {
                if(simageReady[i]=true)
                {
                    context.drawImage(simages[i], simageX[i], simageY[i],simageWidth[i],simageHeight[i]);
                }
            }
            context.fillStyle="#fcfcfc";
            context.fillRect(messagelocx-10,messagelocy-20,100,30);

            context.font="15px Arial";
            context.fillStyle="#db8c1e";
            context.fillText("I'm bored!",messagelocx,messagelocy);
        }
        //draw sad baby with wet diaper
        else if(wet){
        // var swimagesName=["larm","rarm","lleg","rleg","wetdiaper","body", "head", "lseye","rseye","sadmouth","leyeb","reyeb"];
            var swimageWidth=[80,80,50,50,90,90,80,14,14,30,20,20,80];
            var swimageHeight=[100,100,120,120,40,100,80,12,12,15,5,5,80];
            var swimageX=[this.x-60,this.x+70,this.x-25,this.x+65,this.x,this.x,this.x+4,this.x+20,this.x+52,this.x+29,this.x+18,this.x+50,this.x+2];
            var swimageY=[this.y,this.y,this.y+105,this.y+105,this.y+92,this.y,this.y-70,this.y-36,this.y-36,this.y-10,this.y-48,this.y-48,this.y-71];
            for(var i=0;i<13;i++)
            {
                if(swimageReady[i]=true)
                {
                    context.drawImage(swimages[i], swimageX[i], swimageY[i],swimageWidth[i],swimageHeight[i]);

                }
            }
            context.fillStyle="#fcfcfc";
            context.fillRect(messagelocx-10,messagelocy-20,100,30);

            context.font="15px Arial";
            context.fillStyle="#db8c1e";
            context.fillText("I'm wet!",messagelocx,messagelocy);
        }
        else if(move)
        {
        //draw idle baby

//mimagesName=["larmup","rarmup","llegup","rlegup","diaper","body", "head", "loeye","roeye","mouth","leyeb","reyeb"];
            var mimageWidth=[110,110,50,50,90,90,80,14,14,30,20,20,80];
            var mimageHeight=[140,140,120,120,40,100,80,curEyeHeight,curEyeHeight,15,5,5,80];
            var mimageX=[this.x-80,this.x+60,this.x-25,this.x+65,this.x,this.x,this.x+4,this.x+21+loeyeX,this.x+53+roeyeX,this.x+29,this.x+18,this.x+50,this.x+2];
            var mimageY=[this.y-40,this.y-40,this.y+105,this.y+105,this.y+92,this.y,this.y-70,this.y-36+oeyeY,this.y-36+oeyeY,this.y-10,this.y-48,this.y-48,this.y-71];
            for(var i=0;i<13;i++)
            {
                if(mimageReady[i]=true)
                {
                    context.drawImage(mimages[i], mimageX[i], mimageY[i],mimageWidth[i],mimageHeight[i]);
                }
            }

    }
    else
    {
        // var imagesName=["larm","rarm","lleg","rleg","diaper","body", "head", "loeye","roeye","mouth","leyeb","reyeb","hair"];
            var imageWidth=[80,80,50,50,90,90,80,14,14,30,20,20,80];
            var imageHeight=[100,100,120,120,40,100,80,curEyeHeight,curEyeHeight,15,5,5,80];
            var imageX=[this.x-60,this.x+70,this.x-25,this.x+65,this.x,this.x,this.x+4,this.x+21+loeyeX,this.x+53+roeyeX,this.x+29,this.x+18,this.x+50,this.x+2];
            var imageY=[this.y,this.y,this.y+105,this.y+105,this.y+92,this.y,this.y-70,this.y-36+oeyeY,this.y-36+oeyeY,this.y-10,this.y-48,this.y-48,this.y-71];
            for(var i=0;i<13;i++)
            {
                if(imageReady[i]=true)
                {
                    context.drawImage(images[i], imageX[i], imageY[i],imageWidth[i],imageHeight[i]);
                }
            }
    }


 //       }

    }
}

function drawnewbaby(x,y)
{
    this.x=x;
    this.y=y;
    this.update=function()
    {
        if(newbaby)
        {
        eyeOpenTime += blinkUpdateTime;
        if(eyeOpenTime >= timeBtwBlinks)
        {
            blink();
        }
        //  togglemove();
        //draw happy baby

        if(move)
        {
        //draw idle baby
        //mimagesName=["larmup","rarmup","llegup","rlegup","diaper","body", "head", "loeye","roeye","mouth","leyeb","reyeb"];
            var nmimageWidth=[110,110,50,50,90,90,80,14,14,30,20,20,80];
            var nmimageHeight=[140,140,120,120,40,100,80,curEyeHeight,curEyeHeight,15,5,5,80];
            var nmimageX=[this.x-80,this.x+60,this.x-25,this.x+65,this.x,this.x,this.x+4,this.x+21+nloeyeX,this.x+53+nroeyeX,this.x+29,this.x+18,this.x+50,this.x+2];
            var nmimageY=[this.y-40,this.y-40,this.y+105,this.y+105,this.y+92,this.y,this.y-70,this.y-36+oeyeY,this.y-36+oeyeY,this.y-10,this.y-48,this.y-48,this.y-71];
            for(var i=0;i<13;i++)
            {
                if(nmimageReady[i]=true)
                {
                    context.drawImage(nmimages[i], nmimageX[i], nmimageY[i],nmimageWidth[i],nmimageHeight[i]);
                }
            }

    }
    else
    {
        // var imagesName=["larm","rarm","lleg","rleg","diaper","body", "head", "loeye","roeye","mouth","leyeb","reyeb","hair"];
            var nimageWidth=[80,80,50,50,90,90,80,14,14,30,20,20,80];
            var nimageHeight=[100,100,120,120,40,100,80,curEyeHeight,curEyeHeight,15,5,5,80];
            var nimageX=[this.x-60,this.x+70,this.x-25,this.x+65,this.x,this.x,this.x+4,this.x+21+nloeyeX,this.x+53+nroeyeX,this.x+29,this.x+18,this.x+50,this.x+2];
            var nimageY=[this.y,this.y,this.y+105,this.y+105,this.y+92,this.y,this.y-70,this.y-36+oeyeY,this.y-36+oeyeY,this.y-10,this.y-48,this.y-48,this.y-71];
            for(var i=0;i<13;i++)
            {
                if(nimageReady[i]=true)
                {
                    context.drawImage(nimages[i], nimageX[i], nimageY[i],nimageWidth[i],nimageHeight[i]);
                }
            }
    }
    }

    }
}


var move=false;
var count=0;
function togglemove()
{
  count++;
  if(count>=100)
  {
    move=true;
    setTimeout(moveback,100);
    count=0;
  }

}
function moveback()
{
    move=false;
}
function drawcrib()
{
if(cribReady=true)
    {
        context.drawImage(cribImage, 160, 20,400,450);
    }
}
function drawroom()
{
    context.fillStyle="#dcefee";
    context.fillRect(0,0,800,500);
    context.fillStyle="white";
    context.fillRect(10,0,780,490);
}


var interval = 6000;  // 1000 = 1 second

function doAjax() {
    $.ajax({
            type: 'POST',
            url: 'senddata.php',
            data: {
                health:healthBar.width1,
                happiness:happinessBar.width1,
                comfort:comfortBar.width1
                },
 
            complete: function (data) {
                    // Schedule the next
                    setTimeout(doAjax, interval);
            }
    });
}


var playdate=false;;
function greet(x,y,type)
	{
		this.x=x;
		this.y=y;
		this.type=type;
		this.update=function()
		{
			context.fillStyle="Green";
            context.fillText(this.type,this.x,this.y);
		}
	}
var count1=0;
var count2=0;
var count3=0;
var count4=0;
function startGame()
{
	
   $(function ()
  {
    $.ajax({
      url: 'getdata.php',                 
      data: "",                
      dataType: 'json',                       
      success: function(data)        
      {
        var health = data[0];              
        var happiness = data[1];
        var comfort = data[2];
        var babytype=data[3];

        healthBar=new progressbar(pX,pY,pW,health,pH,0.04,"HEALTH");
        happinessBar=new progressbar(pX,pY+d1,pW,happiness,pH,0.1,"HAPPINESS");
        comfortBar=new progressbar(pX,pY+d1+d1,pW,comfort,pH,0.02,"COMFORT");
        //idle image

			for(var i=0;i<13;i++)
			{
				images[i].onload=function()
				{
				 imageReady[i]=true;
				}
				images[i].src=babytype+"/" +imagesName[i]+ ".png";
			}

			//happy image

			for(var i=0;i<13;i++)
			{
				himages[i].onload=function()
				{
				 himageReady[i]=true;
				}
				himages[i].src=babytype+"/" +himagesName[i]+ ".png";
			}
			//move image

			for(var i=0;i<13;i++)
			{
				mimages[i].onload=function()
				{
				 mimageReady[i]=true;
				}
				mimages[i].src=babytype+"/" +mimagesName[i]+ ".png";
			}

			//sad baby with wet diaper

			for(var i=0;i<13;i++)
			{
				swimages[i].onload=function()
				{
				 swimageReady[i]=true;
				}
				swimages[i].src=babytype+"/" +swimagesName[i]+ ".png";
			}
			//sad baby

			for(var i=0;i<13;i++)
			{
				simages[i].onload=function()
				{
				 simageReady[i]=true;
				}
				simages[i].src=babytype+"/" +simagesName[i]+ ".png";
			}
			//hungrey sad baby

			for(var i=0;i<13;i++)
			{
				hsimages[i].onload=function()
				{
				 hsimageReady[i]=true;
				}
				hsimages[i].src=babytype+"/" +hsimagesName[i]+ ".png";
			}
			//hungrey wet baby

			for(var i=0;i<13;i++)
			{
				hwimages[i].onload=function()
				{
				 hwimageReady[i]=true;
				}
				hwimages[i].src=babytype+"/" +hwimagesName[i]+ ".png";

			}
            
	  }
    });

    });
    $(".button").on("click", function(e){
        if(nomessage)
        {
            nomessage=false;   
        }

	e.preventDefault();
	$.ajax({
   	type:'POST',
	url: 'doSearch.php',
  	data: $('input#babysearch').serialize(),

      success: function(data)
		{
		var babytype = jQuery.parseJSON(data);
       // console.log(babytype);
			 //idle image
	    if(babytype=="n")
		{
          nobaby=true;
          nomessage=true;
          issame=false;
		//	console.log("nobaby");
		}
        else if(babytype=="s")
		{
          nobaby=true;
          nomessage=true;
          issame=true;
		//	console.log("nobaby");
		}
        else
		{	
			newbaby=true;
			sayhello=true;
			happymove();

			for(var i=0;i<13;i++)
			{
				nimages[i].onload=function()
				{
				 nimageReady[i]=true;
				}
				nimages[i].src=babytype+"/" +nimagesName[i]+ ".png";
			}


			//move image

			for(var i=0;i<13;i++)
			{
				nmimages[i].onload=function()
				{
				 nmimageReady[i]=true;
				}
				nmimages[i].src=babytype+"/" +nmimagesName[i]+ ".png";
			}
            setTimeout(saybyebye, 5000);
            setTimeout(newbabygo, 6000);
			
		}
		},
		error:function(exception)
        {
        console.log("search error");
    	 }
		
	});
		
    });
    hellogreet=new greet(600,130,"Hello");
    byegreet=new greet(600,130,"Bye");
    message=new nobabymessage(500,10,"This baby doesn't exit!");
    message1=new nobabymessage(500,10,"This baby is already here!");
    makebuttons();
    drawbaby=new drawbaby(baby.x+176,baby.y+25);
    drawnewbaby=new drawnewbaby(baby.x+480,baby.y+25);
    setInterval(updateGame,50);

    setTimeout(doAjax, interval);
}
var nobaby=false;
var newbaby=false;
var saybye=false;
var nomessage=false;
var issame=false;
function nobabymessage(x,y,type)
{
		this.x=x;
		this.y=y;
	this.type=type;

		this.update=function()
		{
            if(nobaby&&nomessage)
            {
			context.fillStyle="#db8c1e";
            context.fillText(this.type,this.x,this.y);
            count4++;
            if(count4>100)
            {
                count4=0;
                if(nomessage)
                nomessage=false;
            }
		    }
	    }
}

function newbabygo()
{
 newbaby=false;

}

function saybyebye()
{
 
 saybye=true;
}

var hellogreet;
var byegreet;
var sayhello=false;
function togglehappy()
{
    count3++;
    if(count3>=50)
    {
       
        happymove();
        count3=0;
        console.log("happy");
    }
}


function updateGame()
{
    clear();
 	
    drawroom();
    drawcrib();
    drawbaby.update();
    drawnewbaby.update();
    healthBar.update();
    if(sayhello)
    {
        hellogreet.update();
        count2++;
        if(count2>=100)
            {
                sayhello=false;
                count2=0;
            }
    }
    if(saybye)
    {
        byegreet.update();
        count1++;
        if(count1>=10)
            {
                saybye=false;
                count1=0;
            }
    }
	if(newbaby)
    {
      //  console.log("newbaby");
         if(!wet&&!hungry&&!hungryandwet)
        {
            if (happinessBar.width1<pW/2)
            {
                happinessBar.width1=pW/2;
            }

            else if (happinessBar.width1>pW)
            {
                happinessBar.width1=pW;
            }
            else happinessBar.width1+=0.1;
        }
    
        if(happinessBar.width1>pW/4&&comfortBar.width1>pW/4&&healthBar.width1>pW/4)
        {
            togglehappy();
           
        }
    }
    happinessBar.update();
    comfortBar.update();
    drawbottle();
    drawdiaper();
    drawtoybox();
    drawtoy1();
    drawtoy2();
    drawtoy3();
    moveeye();
    if(!issame)
    {
        message.update();
    }
    
    if(issame)
    {
    message1.update();
    }
    togglemove();
    milkButton.update();
    playButton.update();
    diaperButton.update();
    canvas.onclick;
    canvas.onmousemove;
    if (comfortBar.width1<pW/4&&healthBar.width1>pW/4&&happinessBar.width1>pW/4)
    {
        wet=true;
        hungry=false;
        hungryandwet=false;
        sad=false;
    }

    else if (comfortBar.width1>pW/4&&healthBar.width1<pW/4&&happinessBar.width1>pW/4)
    {
        wet=false;
        hungry=true;
        hungryandwet=false;
        sad=false;
    }
    else if (comfortBar.width1>pW/4&&healthBar.width1>pW/4&&happinessBar.width1<pW/4)
    {
        wet=false;
        hungry=false;
        hungryandwet=false;
        sad=true;
    }
    else if (comfortBar.width1<pW/4&&healthBar.width1<pW/4&&happinessBar.width1>pW/4)
    {
        wet=false;
        hungry=false;
        hungryandwet=true;
        sad=false;
    }
    else if (comfortBar.width1<pW/4&&healthBar.width1>pW/4&&happinessBar.width1<pW/4)
    {
        wet=true;
        hungry=false;
        hungryandwet=false;
        sad=false;
    }
    else if (comfortBar.width1>pW/4&&healthBar.width1<pW/4&&happinessBar.width1<pW/4)
    {
        wet=false;
        hungry=true;
        hungryandwet=false;
        sad=false;
    }
    else if(comfortBar.width1<pW/4&&healthBar.width1<pW/4&&happinessBar.width1<pW/4)
    {
        wet=false;
        hungry=false;
        hungryandwet=true;
        sad=false;
    }
    else
    {
        wet=false;
        hungry=false;
        hungryandwet=false;
        sad=false;

    }

}

</script>
<?php
include("includes/closeDbConn.php");
}
?>
</body>
</html>
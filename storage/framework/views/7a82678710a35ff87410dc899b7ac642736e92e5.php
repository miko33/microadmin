<style>

  #div1 {
    margin-top: 25px;
    border: 2px solid #9bb8e8;
    padding: 10px;
    border-radius: 10px;
  }
 .pic  {
  width: 750px;
  height: 400px
}

.create{
  float: right;
}

/* template1 */

.slide-window {
  /*border:1px solid black;*/
  width:750px;
  margin: 0 auto;
  height:auto;
 /* background-color:red;*/
  overflow:hidden;
  position:relative;
}

.nav {
	display:block;
	position:relative;
	cursor:pointer;
}

.info-bar {
  position:absolute;
  bottom:0;
  color: white;
  height:10%;
  font-size: 130%;
  background-color: rgba(0,0,0,0.5);
  width:100%;
}

 #rightNav,
#leftNav {
	top: calc(50% - 26px);
  position: absolute;
	width:20px;
	height:53px;
	background-image:url(https://www.nhm.ac.uk/etc/designs/nhmwww/img/arrows/slider-arrow.png);
	background-repeat:no-repeat;
	z-index:10;/*What does this do?*/
}

#rightNav {
	right:0;
  -webkit-transform: scaleX(-1);
}

#leftNav {
	left:0;
}

.slide-holder {
  width:300%;
  background-color: blue;
  margin-left:0%;
  transition: margin-left 1s;

}

.slide {
  width:33.33%;
  height:auto;
  float:left;
}


/* template2 */

.info-bar1 {
  position:absolute;
  bottom:0;
  color: white;
  height:10%;
  font-size: 130%;
  background-color: rgba(0,0,0,0.5);
  width:100%;
}

 #rightNav1,
#leftNav1 {
	top: calc(50% - 26px);
  position: absolute;
	width:20px;
	height:53px;
	background-image:url(https://www.nhm.ac.uk/etc/designs/nhmwww/img/arrows/slider-arrow.png);
	background-repeat:no-repeat;
	z-index:999;/*What does this do?*/
}

#rightNav1 {
	right:0;
  -webkit-transform: scaleX(-1);
}

#leftNav1 {
	left:0;
}

.slide-holder1 {
  width:300%;
  background-color: blue;
  margin-left:0%;
  transition: margin-left 1s;

}

.slide1 {
  width:33.33%;
  height:auto;
  float:left;
}

/* template3 */
</style>

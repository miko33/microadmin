$( document ).ready(function() {
$('#leftNav').click(moveSlideLeft).click(setMarginWidth);
$('#rightNav').click(moveSlideRight).click(setMarginWidth);


var slidePosition=0;

function setMarginWidth(){
var slideHolderMargin=-100*slidePosition;
$('.slide-holder').css("margin-left", slideHolderMargin +'%');
}

function moveSlideRight() {
  if(slidePosition==1) {
    slidePosition=0}
  else {
    slidePosition++;
  }
}

  function moveSlideLeft() {
  if(slidePosition==0) {
    slidePosition=1}
    else {
      slidePosition=slidePosition-1;
  }
  }
  });

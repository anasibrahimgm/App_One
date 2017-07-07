$(function(){

  var value = $('.myUl').width();
  value /= 2;
  $('.myUl li').width(value);
  var value2 = $('.myUl li').width();
  //$("#registerA").width(value2);
  //$("#loginA").width(value2-30);

  var x =  ( $('.myTabsRow').width() - $('.myTabs').outerWidth() ) / 2;
  x += 'px';
  $('.myTabs').css({
    'marginLeft': x ,
  });
  // we need to keep track of window width

  var y =  ( $('.navContainer').width() - $('.navContainer').css('paddingRight') * 2 - $('.navA').outerWidth() ) / 2; //must be 940 - 106.sth
  y += 'px';
  var z = $('.navContainer').css('paddingRight');
  //we need to get the number part out of it!

  $('.navA').css({
    'marginLeft': y ,
  });
});

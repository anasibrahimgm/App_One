$(function () {
  margins();

  var value = $('.myUl').width();
  value /= 2;
  $('.myUl li').width(value);
  var value2 = $('.myUl li').width();
  //$("#registerA").width(value2);
  //$("#loginA").width(value2-30);

  function margins () {
    var x =  $('.myTabsRow').width() - $('.myTabs').width();
    x /= 2;
    x += 'px';

    $('.myTabs').css({
      'marginLeft': x ,
      'marginRight': x ,
    });

    var y =  $('.navContainer').width() - $('.navA').width();
    y /= 2;
    y += 'px';

    $('.navA').css({
      'marginLeft': y ,
      'marginRight': y ,
    });
  }

  $(window).resize(function () {//on window width change
    margins();
  });

    var x = $('.basicInfo-left').width() - 10;
    x += 'px';
    $('.basicInfo-left-edit').css({
      'height': x,
      'width': x,
    });

    var imgUrl = $('#profile-img-edit').attr('src');
    imgUrl = "url(" + imgUrl + ")";

  $('.basicInfo-left-edit').css({
    'backgroundImage': imgUrl,
  });

});

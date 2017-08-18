$(function () {
  margins();
  modalPadding();

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

  function modalPadding() {
    //window.console.log('window Height: ' + $(window).height());
    //window.console.log('modal-dialog Height: ' + $('.modal-dialog').height());

    var window_height = $(window).height();
    var modalDialog_height = $('.modal-dialog').height();

    var modal_padding = (window_height - modalDialog_height)/2

    if (modal_padding >= 100)
      modal_padding += 'px';
    else
      modal_padding = '100px';

    $('.modal-dialog').css({
      'marginTop': 0,
      'marginBottom':0,
      'paddingTop': modal_padding,
    });
  }

  $(window).resize(function () {//on window width change
    margins();
    modalPadding();
  });

    var x = $('.basicInfo-left').width() - 10;
    x += 'px';
    $('.basicInfo-left-edit').css({
      'height': x,
      'width': x,
    });

});

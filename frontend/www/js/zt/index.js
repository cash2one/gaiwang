// @author 黄锦东 2015-11-17
(function ($, window) {
  // 节流函数，可以避免频繁的事件响应，如滚动条滚动事件
  function throttle(method, context, time) {
    clearTimeout(method.tId);
    method.tId = setTimeout(function () {
      method.call(context);
    }, time);
  }

  // 简易悬浮菜单插件
  $.fn.sidebar = function (delay) {
    var _self = $(this),
      win = $(window),
      links = _self.find('a'),
      ids = getIds(links) || [],
      positions = getPositions(ids) || [];

    win.scroll(function () {
      throttle(showSidebar, window, delay);
    });

    function getIds(links) {
      return $.map(links, function (link, key) {
        return $(link).attr('href');
      });
    }

    function getPositions(ids) {
      return $.map(ids, function (id, key) {
        return $(id).offset().top;
      });
    }

    function showSidebar() {
      if (win.scrollTop() >= positions[0]) {
        _self.fadeIn(delay);
      } else {
        _self.fadeOut(delay);
      }
    }
  };

  /*
   * @author 黄锦东 2015/11/18
   * @description 手风琴插件
   * @param {object} option {
   *  itemClassName: item类名
   *  delay: 延时 小于mouseSpeed才能避免闪动
   *  width_closed: 关闭的项目的宽度
   *  width_opened: 打开的项目的宽度
   * }
   */
  $.fn.accordion = function (options) {
    var items = $(this).children('.' + options.itemClassName),
      current_item = 0,
      last_item = 0,
      timer = null,
      mouseSpeed = 300,
      defaults = {
        delay: mouseSpeed,
        width_closed: 86,
        width_opened: 186
      },
      sets = $.extend(defaults, options);

    if (sets.delay > mouseSpeed) {
      sets.delay = mouseSpeed;
    }

    items.each(function (i) {
      var _self = $(this);
      _self.mouseenter(function () {
        clearTimeout(timer);
        timer = setTimeout(function () {
          last_item = current_item;
          current_item = i;

          handleOut();

          handleIn(_self);
        }, mouseSpeed);
      });
    });

    function handleOut() {
      last_item !== current_item && items.eq(last_item).animate({
        width: sets.width_closed
      }, sets.delay);
    }

    function handleIn(self) {
      self.animate({
        width: sets.width_opened
      }, sets.delay);
    }

    (function init() {
      items.eq(last_item).css({
        width: sets.width_opened
      });
    }());
  };
}(jQuery, window));

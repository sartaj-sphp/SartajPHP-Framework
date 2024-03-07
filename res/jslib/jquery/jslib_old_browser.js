function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw new Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw new Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); Object.defineProperty(subClass, "prototype", { writable: false }); if (superClass) _setPrototypeOf(subClass, superClass); }
function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf ? Object.setPrototypeOf.bind() : function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }
function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }
function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } else if (call !== void 0) { throw new TypeError("Derived constructors may only return object or undefined"); } return _assertThisInitialized(self); }
function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }
function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }
function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf.bind() : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }
function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }
/*
 * All rights are reserved by SartajPHP. for more info contact on sartajphp.com
 * 
 */
function makeFirstUpper(str) {
  str = str.toLowerCase().replace(/\b[a-z]/g, function (letter) {
    return letter.toUpperCase();
  });
  return str;
}
function parseNumber(variable) {
  if (jQuery.type(variable) !== "undefined" && jQuery.type(variable) !== "null") {
    if (variable.length !== 'undefined') {
      if (variable.length > 0) {
        var f1 = parseFloat(variable, 10);
        if (f1 !== "NaN") {
          parseFloat(variable, 10);
        } else {
          return 0.0;
        }
      } else {
        return parseFloat(variable, 10);
      }
    } else if (jQuery.isPlainObject(variable)) {
      if (Object.keys(variable).length > 0) {
        return Object.keys(variable).length;
      } else {
        return 0.0;
      }
    } else if (jQuery.type(variable) === "number") {
      return variable;
    } else if (jQuery.type(variable) === "boolean") {
      if (variable) return 1;
      return 0.0;
    } else if (jQuery.type(variable) === "object" && Object.keys(variable).length > 0) {
      return Object.keys(variable).length;
    } else {
      return 0.0;
    }
  } else {
    return 0.0;
  }
}
function callOnceTimeFirstCall(fun, time) {
  var now = Date.now();
  var nt = fun.lascalltime || now;
  if (nt > now) return false;
  fun.lascalltime = now + time;
  return true;
}
function callOnceTimeLastCall(fun, time, callback, args) {
  var nt = fun.lascalltimer || 0;
  clearTimeout(nt);
  fun.lascalltimer = setTimeout(function () {
    callback.apply(fun, args);
  }, time);
}
function restrictNumeric() {
  $(".numeric").keypress(function (event) {
    // Backspace, tab, enter, end, home, left, right
    // We don't support the del key in Opera because del == . == 46.
    var controlKeys = [8, 9, 13, 35, 36, 37, 39];
    // IE doesn't support indexOf
    var isControlKey = controlKeys.join(",").match(new RegExp(event.which));
    // Some browsers just don't raise events for control keys. Easy.
    // e.g. Safari backspace.
    if (!event.which ||
    // Control keys in most browsers. e.g. Firefox tab is 0
    49 <= event.which && event.which <= 57 ||
    // Always 1 through 9
    48 == event.which && $(this).attr("value") ||
    // No 0 first digit
    isControlKey) {
      // Opera assigns values for control keys.
      return;
    } else {
      event.preventDefault();
    }
  });
}
$(document).ready(function () {
  $.fn.getSelectionRange = function () {
    var e = this.jquery ? this[0] : this;
    return ( /* mozilla / dom 3.0 */
    'selectionStart' in e && function () {
      var l = e.selectionEnd - e.selectionStart;
      return {
        start: e.selectionStart,
        end: e.selectionEnd,
        length: l,
        text: e.value.substr(e.selectionStart, l)
      };
    } || /* exploder */
    document.selection && function () {
      e.focus();
      var r = document.selection.createRange();
      if (r == null) {
        return {
          start: 0,
          end: e.value.length,
          length: 0
        };
      }
      var re = e.createTextRange();
      var rc = re.duplicate();
      re.moveToBookmark(r.getBookmark());
      rc.setEndPoint('EndToStart', re);
      return {
        start: rc.text.length,
        end: rc.text.length + r.text.length,
        length: r.text.length,
        text: r.text
      };
    } || /* browser not supported */
    function () {
      return {
        start: 0,
        end: e.value.length,
        length: 0
      };
    })();
  };
  $.fn.insertAtCaret = function (text) {
    var e = this.jquery ? this[0] : this;
    return ( /* mozilla / dom 3.0 */
    'selectionStart' in e && function () {
      e.value = e.value.substr(0, e.selectionStart) + text + e.value.substr(e.selectionEnd, e.value.length);
      return this;
    } || /* exploder */
    document.selection && function () {
      e.focus();
      document.selection.createRange().text = text;
      return this;
    } || /* browser not supported */
    function () {
      e.value += text;
      return this;
    })();
  };
  $.fn.selectRange = function (start, end) {
    return this.each(function () {
      if (this.setSelectionRange) {
        this.focus();
        this.setSelectionRange(start, end);
      } else if (this.createTextRange) {
        var range = this.createTextRange();
        range.collapse(true);
        range.moveEnd('character', end);
        range.moveStart('character', start);
        range.select();
      }
    });
  };
});

/*
jQuery.fn.testFn = function(options){
    var defaults = {
            validateOPtions1 : '',
            validateOPtions2 : ''
        };
var settings = $.extend({}, defaults, options);
this.each(function(){
        var className = $(this).attr('class');
        $(this).html(className);
    });    
};


// global funvtion start here
jQuery(function(options){
    // [0] gets the first object in array, which is your selected element, you can also use .get(0) in jQuery
    $("#test")[0].addProduct = function(info){
        alert("ID: " + this.id + " - Param: " + info);
    };


    $("#test")[0].addProduct("productid");
});
*/
jQuery.fn.center = function () {
  this.css("position", "absolute");
  this.css("top", Math.max(0, ($(window).height() - $(this).outerHeight()) / 2 + $(window).scrollTop()) + "px");
  this.css("left", Math.max(0, ($(window).width() - $(this).outerWidth()) / 2 + $(window).scrollLeft()) + "px");
  return this;
};
jQuery.fn.centerHorizontal = function () {
  this.css("position", "absolute");
  this.css("left", Math.max(0, ($(window).width() - $(this).outerWidth()) / 2) + "px");
  return this;
};
function getPosition(mouseEvent, obj) {
  var offs = $(obj).offset();
  var left = mouseEvent.clientX - offs.left;
  var top = mouseEvent.clientY - offs.top;
  return [left, top];
}
// start global function
function ucwords(str) {
  str = str.toLowerCase().replace(/\b[a-z]/g, function (letter) {
    return letter.toUpperCase();
  });
  return str;
}
function isset2(variable) {
  if (jQuery.type(variable) !== "undefined" && jQuery.type(variable) !== "null") {
    return true;
  } else {
    return false;
  }
}
function is_array(variable) {
  if (jQuery.type(variable) === "object" && variable.length) {
    return true;
  } else {
    return false;
  }
}
function is_object(variable) {
  if (jQuery.isPlainObject(variable)) {
    return true;
  } else if (jQuery.type(variable) === "object") {
    return true;
  } else {
    return false;
  }
}
function isset(variable) {
  if (jQuery.type(variable) !== "undefined" && jQuery.type(variable) !== "null") {
    if (variable.length !== 'undefined') {
      if (variable.length > 0) {
        return true;
      } else {
        return false;
      }
    } else if (jQuery.isPlainObject(variable)) {
      if (Object.keys(variable).length > 0) {
        return true;
      } else {
        return false;
      }
    } else if (jQuery.type(variable) === "number") {
      return true;
    } else if (jQuery.type(variable) === "boolean") {
      return true;
    } else if (jQuery.type(variable) === "object" && Object.keys(variable).length > 0) {
      return true;
    } else {
      return false;
    }
  } else {
    return false;
  }
}
function get_browser() {
  var browsercap = {};
  browsercap['appName'] = navigator.appName;
  var b_version = navigator.appVersion;
  browsercap['version'] = parseFloat(b_version);
  return browsercap;
}
function getAppPath(ctrl) {
  var loc = new String(window.location);
  var url = "";
  var hosturl = "";
  if (loc.charAt(loc.length - 1) == '/') {
    hosturl = loc;
    url = loc + 'index';
  } else {
    var sploc = loc;
    var lastslashindex = sploc.lastIndexOf('/') + 1;
    var firstqueryindex = sploc.indexOf('?');
    if (firstqueryindex < 0) {
      firstqueryindex = loc.length;
    }
    hosturl = sploc.substr(0, lastslashindex);
    var fileurl = sploc.substr(lastslashindex, firstqueryindex - lastslashindex);
    firstqueryindex = fileurl.indexOf('-');
    if (firstqueryindex < 0) {
      firstqueryindex = fileurl.indexOf('.');
    }
    var sartajPHPctrl = fileurl.substr(0, firstqueryindex);
    url = hosturl + sartajPHPctrl;
  }
  if (isset(ctrl)) {
    url = hosturl + ctrl;
  }
  return url;
}
function getSartajPHPAppURL(ctrl) {
  var loc = new String(window.location);
  var url = "";
  var hosturl = "";
  if (loc.charAt(loc.length - 1) == '/') {
    hosturl = loc;
    url = loc + 'index';
  } else {
    var sploc = loc;
    var lastslashindex = sploc.lastIndexOf('/') + 1;
    var firstqueryindex = sploc.indexOf('?');
    if (firstqueryindex < 0) {
      firstqueryindex = loc.length;
    }
    hosturl = sploc.substr(0, lastslashindex);
    var fileurl = sploc.substr(lastslashindex, firstqueryindex - lastslashindex);
    firstqueryindex = fileurl.indexOf('-');
    if (firstqueryindex < 0) {
      firstqueryindex = fileurl.indexOf('.');
    }
    var sartajPHPctrl = fileurl.substr(0, firstqueryindex);
    url = hosturl + sartajPHPctrl;
  }
  if (isset(ctrl)) {
    url = hosturl + ctrl;
  }
  return url;
}
$.fn.getClickedElement = function () {
  var obj = this;
  $("*", document.body).click(function (event) {
    event.stopPropagation();
    var domElement = $(this).get(0);
    $(obj).text("Clicked on - " + domElement.nodeName);
  });
};
function pasteHtmlAtCaret(html, selectPastedContent) {
  var sel, range;
  if (window.getSelection) {
    // IE9 and non-IE
    sel = window.getSelection();
    if (sel.getRangeAt && sel.rangeCount) {
      range = sel.getRangeAt(0);
      range.deleteContents();

      // Range.createContextualFragment() would be useful here but is
      // only relatively recently standardized and is not supported in
      // some browsers (IE9, for one)
      var el = document.createElement("div");
      el.innerHTML = html;
      var frag = document.createDocumentFragment(),
        node,
        lastNode;
      while (node = el.firstChild) {
        lastNode = frag.appendChild(node);
      }
      var firstNode = frag.firstChild;
      range.insertNode(frag);

      // Preserve the selection
      if (lastNode) {
        range = range.cloneRange();
        range.setStartAfter(lastNode);
        if (selectPastedContent) {
          range.setStartBefore(firstNode);
        } else {
          range.collapse(true);
        }
        sel.removeAllRanges();
        sel.addRange(range);
      }
    }
  } else if ((sel = document.selection) && sel.type != "Control") {
    // IE < 9
    var originalRange = sel.createRange();
    originalRange.collapse(true);
    sel.createRange().pasteHTML(html);
    if (selectPastedContent) {
      range = sel.createRange();
      range.setEndPoint("StartToStart", originalRange);
      range.select();
    }
  }
}
function setValue(obj, val) {
  var type = $(obj).prop("tagName");
  switch (type) {
    case 'INPUT':
      {
        $(obj).val(val);
        break;
      }
    case 'TEXTAREA':
      {
        $(obj).html(val);
        break;
      }
    case 'SELECT':
      {
        obj.options[obj.selectedIndex].value = val;
        break;
      }
    case 'DIV':
      {
        $(obj).html(val);
        break;
      }
    default:
      {
        $(obj).html(val);
      }
  }
}
function getValue(obj) {
  var type = $(obj).prop("tagName");
  switch (type) {
    case 'INPUT':
      {
        return $(obj).val();
        break;
      }
    case 'TEXTAREA':
      {
        return $(obj).html();
        break;
      }
    case 'SELECT':
      {
        return obj.options[obj.selectedIndex].value;
        break;
      }
    case 'DIV':
      {
        return $(obj).html();
        break;
      }
    default:
      {
        return $(obj).html();
      }
  }
}
function selectByValue(obj, val) {
  $(obj).children('option').removeAttr('selected');
  $(obj).find('option[value="' + val + '"]').prop("selected", true);
}
function selectByText(obj, val) {
  $(obj).children('option').removeAttr('selected');
  $(obj).find('option:contains("' + val + '")').prop("selected", true);
}
function toggleFullScreen() {
  if (!document.fullscreenElement &&
  // alternative standard method
  !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
    // current working methods
    if (document.documentElement.requestFullscreen) {
      document.documentElement.requestFullscreen();
    } else if (document.documentElement.msRequestFullscreen) {
      document.documentElement.msRequestFullscreen();
    } else if (document.documentElement.mozRequestFullScreen) {
      document.documentElement.mozRequestFullScreen();
    } else if (document.documentElement.webkitRequestFullscreen) {
      document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
    }
  } else {
    if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.msExitFullscreen) {
      document.msExitFullscreen();
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
    } else if (document.webkitExitFullscreen) {
      document.webkitExitFullscreen();
    }
  }
}
function format_date(date) {
  month = date.getMonth();
  month = month + 1; //javascript date goes from 0 to 11
  if (month < 10) month = "0" + month; //adding the prefix

  year = date.getFullYear();
  day = date.getDate();
  hour = date.getHours();
  minutes = date.getMinutes();
  seconds = date.getSeconds();
  return month + "-" + day + "-" + year + " " + hour + ":" + minutes + ":" + seconds;
}
var Base64 = {
  _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
  encode: function encode(r) {
    var e,
      t,
      o,
      a,
      h,
      d,
      C,
      c = "",
      f = 0;
    for (r = Base64._utf8_encode(r); f < r.length;) e = r.charCodeAt(f++), t = r.charCodeAt(f++), o = r.charCodeAt(f++), a = e >> 2, h = (3 & e) << 4 | t >> 4, d = (15 & t) << 2 | o >> 6, C = 63 & o, isNaN(t) ? d = C = 64 : isNaN(o) && (C = 64), c = c + this._keyStr.charAt(a) + this._keyStr.charAt(h) + this._keyStr.charAt(d) + this._keyStr.charAt(C);
    return c;
  },
  decode: function decode(r) {
    var e,
      t,
      o,
      a,
      h,
      d,
      C,
      c = "",
      f = 0;
    for (r = r.replace(/[^A-Za-z0-9\+\/\=]/g, ""); f < r.length;) a = this._keyStr.indexOf(r.charAt(f++)), h = this._keyStr.indexOf(r.charAt(f++)), d = this._keyStr.indexOf(r.charAt(f++)), C = this._keyStr.indexOf(r.charAt(f++)), e = a << 2 | h >> 4, t = (15 & h) << 4 | d >> 2, o = (3 & d) << 6 | C, c += String.fromCharCode(e), 64 != d && (c += String.fromCharCode(t)), 64 != C && (c += String.fromCharCode(o));
    return Base64._utf8_decode(c);
  },
  _utf8_encode: function _utf8_encode(r) {
    r = r.replace(/\r\n/g, "\n");
    for (var e = "", t = 0; t < r.length; t++) {
      var o = r.charCodeAt(t);
      o < 128 ? e += String.fromCharCode(o) : o > 127 && o < 2048 ? (e += String.fromCharCode(o >> 6 | 192), e += String.fromCharCode(63 & o | 128)) : (e += String.fromCharCode(o >> 12 | 224), e += String.fromCharCode(o >> 6 & 63 | 128), e += String.fromCharCode(63 & o | 128));
    }
    return e;
  },
  _utf8_decode: function _utf8_decode(r) {
    for (var e = "", t = 0, o = c1 = c2 = 0; t < r.length;) (o = r.charCodeAt(t)) < 128 ? (e += String.fromCharCode(o), t++) : o > 191 && o < 224 ? (e += String.fromCharCode((31 & o) << 6 | 63 & (c2 = r.charCodeAt(t + 1))), t += 2) : (e += String.fromCharCode((15 & o) << 12 | (63 & (c2 = r.charCodeAt(t + 1))) << 6 | 63 & (c3 = r.charCodeAt(t + 2))), t += 3);
    return e;
  }
};
function checkOnlineStatus() {
  return _checkOnlineStatus.apply(this, arguments);
}
function _checkOnlineStatus() {
  _checkOnlineStatus = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
    var online;
    return _regeneratorRuntime().wrap(function _callee$(_context) {
      while (1) switch (_context.prev = _context.next) {
        case 0:
          _context.prev = 0;
          _context.next = 3;
          return fetch("/favicon.ico");
        case 3:
          online = _context.sent;
          return _context.abrupt("return", online.status >= 200 && online.status < 300);
        case 7:
          _context.prev = 7;
          _context.t0 = _context["catch"](0);
          return _context.abrupt("return", false);
        case 10:
        case "end":
          return _context.stop();
      }
    }, _callee, null, [[0, 7]]);
  }));
  return _checkOnlineStatus.apply(this, arguments);
}
var getMethods = function getMethods(obj) {
  var properties = new Set();
  var currentObj = obj;
  do {
    Object.getOwnPropertyNames(currentObj).map(function (item) {
      return properties.add(item);
    });
  } while (currentObj = Object.getPrototypeOf(currentObj));
  return _toConsumableArray(properties.keys()).filter(function (item) {
    return typeof obj[item] === 'function';
  });
};
//sjslib code
var SuperClass = /*#__PURE__*/function () {
  "use strict";

  function SuperClass() {
    _classCallCheck(this, SuperClass);
    this.self2 = this;
  }
  _createClass(SuperClass, [{
    key: "myself",
    get: function get() {
      return this.self2;
    }
  }]);
  return SuperClass;
}();
;
var Debug = /*#__PURE__*/function (_SuperClass) {
  "use strict";

  _inherits(Debug, _SuperClass);
  var _super = _createSuper(Debug);
  function Debug() {
    _classCallCheck(this, Debug);
    return _super.call(this);
  }
  _createClass(Debug, [{
    key: "printerr",
    value: function printerr(msg) {
      var str1 = this.filterMsg(msg);
      if (str1.length > 2) {
        console.log("SNode Err:- " + str1);
      }
    }
  }, {
    key: "printwarn",
    value: function printwarn(msg) {
      var str1 = this.filterMsg(msg);
      if (str1.length > 2) {
        console.log("SNode Warn:- " + str1);
      }
    }
  }, {
    key: "println",
    value: function println(msg) {
      var str1 = this.filterMsg(msg);
      if (str1.length > 2) {
        console.log("SNode:- " + str1);
      }
    }
  }, {
    key: "print_r",
    value: function print_r(msga) {
      var myself = this.myself;
      msga.forEach(function (msg) {
        console.log("SNodeA:- " + myself.filterMsg(msg));
      });
    }
  }, {
    key: "filterMsg",
    value: function filterMsg(msg) {
      if (msg != undefined) {
        if (_typeof(msg) === 'object') {
          if (typeof msg.toString === 'function') {
            return msg.toString();
          } else {
            return this.objToString(msg);
          }
        } else {
          return msg;
        }
      }
      return "";
    }
  }, {
    key: "objToString",
    value: function objToString(obj) {
      //console.dir(obj, { depth: null });
      return JSON.stringify(obj);
    }
  }, {
    key: "objToString2",
    value: function objToString2(obj) {
      var str = '';
      for (var p in obj) {
        if (obj.hasOwnProperty(p)) {
          str += p + '::' + obj[p] + '\n';
        }
      }
      return str;
    }
  }]);
  return Debug;
}(SuperClass);
var debug = new Debug();
function println(msg) {
  debug.println(msg);
}
var SphpClass = /*#__PURE__*/function (_SuperClass2) {
  "use strict";

  _inherits(SphpClass, _SuperClass2);
  var _super2 = _createSuper(SphpClass);
  function SphpClass() {
    var _this;
    _classCallCheck(this, SphpClass);
    _this = _super2.call(this);
    _this.debug = debug;
    _this.serverPathi = window.location;
    _this.onstart();
    return _this;
  }
  _createClass(SphpClass, [{
    key: "ServerPath",
    get: function get() {
      return this.serverPathi;
    }
  }, {
    key: "onstart",
    value: function onstart() {}
  }]);
  return SphpClass;
}(SuperClass);
;
var Router = /*#__PURE__*/function (_SphpClass) {
  "use strict";

  _inherits(Router, _SphpClass);
  var _super3 = _createSuper(Router);
  function Router() {
    var _this2;
    _classCallCheck(this, Router);
    _this2 = _super3.call(this);
    _this2.lstregapps = {};
    return _this2;
  }
  _createClass(Router, [{
    key: "registerApp",
    value: function registerApp(ctrl, path) {
      this.lstregapps[ctrl] = path;
    }
  }, {
    key: "ListRegApps",
    get: function get() {
      return this.lstregapps;
    }
  }]);
  return Router;
}(SphpClass);
var router = new Router();
function registerApp(ctrl, path) {
  router.registerApp(ctrl, path);
}
var StQueue = /*#__PURE__*/function (_SphpClass2) {
  "use strict";

  _inherits(StQueue, _SphpClass2);
  var _super4 = _createSuper(StQueue);
  function StQueue() {
    _classCallCheck(this, StQueue);
    return _super4.apply(this, arguments);
  }
  _createClass(StQueue, [{
    key: "onstart",
    value: function onstart() {
      this.lst = [];
    }
  }, {
    key: "addInQueue",
    value: function addInQueue(promise) {
      this.lst.push(promise);
    }
  }, {
    key: "wait",
    value: function wait(callback, fail) {
      Promise.all(this.lst).then(callback)["catch"](fail);
    }
  }]);
  return StQueue;
}(SphpClass);
var BasicApp = /*#__PURE__*/function (_SphpClass3) {
  "use strict";

  _inherits(BasicApp, _SphpClass3);
  var _super5 = _createSuper(BasicApp);
  function BasicApp() {
    _classCallCheck(this, BasicApp);
    return _super5.apply(this, arguments);
  }
  _createClass(BasicApp, [{
    key: "page_new",
    value: function page_new() {}
  }, {
    key: "getQueue",
    value: function getQueue() {
      return new StQueue();
    }
  }]);
  return BasicApp;
}(SphpClass);
var CompApp = /*#__PURE__*/function (_SphpClass4) {
  "use strict";

  _inherits(CompApp, _SphpClass4);
  var _super6 = _createSuper(CompApp);
  function CompApp() {
    var _this3;
    _classCallCheck(this, CompApp);
    _this3 = _super6.call(this);
    var myself = _assertThisInitialized(_this3);
    _this3.state = {};
    var textNode = $("body")[0];
    if (textNode.addEventListener) {
      textNode.addEventListener('DOMNodeInserted', function (e) {
        myself._onupdate(e);
      }, false);
      textNode.addEventListener('DOMNodeInsertedIntoDocument', function (e) {
        myself._onupdate(e);
      }, false);
      //textNode.addEventListener ('DOMNodeRemoved', function(e){myself._onupdate(e)}, false);
      //textNode.addEventListener ('DOMNodeRemovedFromDocument', function(e){myself._onupdate(e)}, false);
    }

    myself._setupEventHnadlers();
    return _this3;
  }
  _createClass(CompApp, [{
    key: "_onupdate",
    value: function _onupdate(e) {
      //debug.println("node insert");
      //console.log(e);
      //myself._setupEventHnadlers();
    }
  }, {
    key: "_setupEventHnadlers",
    value: function _setupEventHnadlers() {
      var myself = this;
      var fun1 = getMethods(this);
      $.each(fun1, function (index, funname) {
        var fun2 = funname.split("_");
        if (fun2[0] === "comp") {
          var compselector = fun2[2];
          var compevent = fun2[3];
          if (fun2[1] == "class") {
            compselector = "." + compselector;
          } else if (fun2[1] == "id") {
            compselector = "#" + compselector;
          }
          $(compselector).on(compevent, function (e) {
            myself[funname](e);
          });
        }
      });
      //debug.println("node removed document");
    }
  }, {
    key: "setState",
    value: function setState(val) {
      var myself = this;
      this.state = $.extend(myself.state, val);
    }
  }, {
    key: "lcomp_class_headerbar_click",
    value: function lcomp_class_headerbar_click(e) {
      var str = 'hello, <b id="bd1" data-text="red">my name is</b> jQuery.';
      var html = $.parseHTML(str);
      $.each(html, function (i, el) {
        if (el.nodeName !== "#text") {
          //console.log("<li>" + el.nodeName + "</li>");
          sconsole.dir(el.attributes);
        }
      });
    }
  }, {
    key: "page_new",
    value: function page_new() {}
  }, {
    key: "getQueue",
    value: function getQueue() {
      return new StQueue();
    }
  }]);
  return CompApp;
}(SphpClass);
var StartEngine = /*#__PURE__*/function () {
  "use strict";

  function StartEngine() {
    _classCallCheck(this, StartEngine);
    this.projectDir = window.location;
    this.lstappsobj = {};
    this.debug = debug;
  }
  _createClass(StartEngine, [{
    key: "serverPath",
    get: function get() {
      return this.projectDir;
    }
  }, {
    key: "getEventTrigger",
    value: function getEventTrigger(evt, evtp, ctrl) {
      var obj2 = this.getApp(ctrl);
      var fcall = 'page_event_' + evt;
      try {
        return obj2[fcall](evtp);
      } catch (e) {
        this.debug.println(ctrl + " Application doesn't have event handler " + evt + " or error " + e);
      }
    }
  }, {
    key: "getAppTrigger",
    value: function getAppTrigger(ctrl) {
      var obj2 = this.getApp(ctrl);
      return obj2.page_new();
    }
  }, {
    key: "getApp",
    value: function getApp(ctrl) {
      if (this.lstappsobj[ctrl]) {
        return this.lstappsobj[ctrl];
      } else {
        var obj1 = router.ListRegApps[ctrl];
        this.lstappsobj[ctrl] = new obj1();
        return this.lstappsobj[ctrl];
      }
    }
  }, {
    key: "getEventPara",
    value: function getEventPara(event, ui, aname) {
      return {
        obj: $(event.target),
        evt: aname,
        event: event,
        ui: ui
      };
    }
  }]);
  return StartEngine;
}();
var sphp_api = new StartEngine();
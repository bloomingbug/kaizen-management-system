import {
  Fragment,
  createBaseVNode,
  createElementBlock,
  normalizeClass,
  openBlock,
  renderList,
  resolveDirective,
  withDirectives,
  withModifiers
} from "./chunk-YZFR4XBS.js";
import "./chunk-DFKQJ226.js";

// node_modules/vue-simple-context-menu/dist/vue-simple-context-menu.esm.js
var commonjsGlobal = typeof globalThis !== "undefined" ? globalThis : typeof window !== "undefined" ? window : typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : {};
function createCommonjsModule(fn, module) {
  return module = { exports: {} }, fn(module, module.exports), module.exports;
}
var vClickOutside_umd = createCommonjsModule(function(module, exports) {
  !function(e, n) {
    module.exports = n();
  }(commonjsGlobal, function() {
    var e = "__v-click-outside", n = "undefined" != typeof window, t = "undefined" != typeof navigator, r = n && ("ontouchstart" in window || t && navigator.msMaxTouchPoints > 0) ? ["touchstart"] : ["click"], i = function(e2) {
      var n2 = e2.event, t2 = e2.handler;
      (0, e2.middleware)(n2) && t2(n2);
    }, a = function(n2, t2) {
      var a2 = function(e2) {
        var n3 = "function" == typeof e2;
        if (!n3 && "object" != typeof e2) {
          throw new Error("v-click-outside: Binding value must be a function or an object");
        }
        return { handler: n3 ? e2 : e2.handler, middleware: e2.middleware || function(e3) {
          return e3;
        }, events: e2.events || r, isActive: !(false === e2.isActive), detectIframe: !(false === e2.detectIframe), capture: Boolean(e2.capture) };
      }(t2.value), o2 = a2.handler, d2 = a2.middleware, c = a2.detectIframe, u = a2.capture;
      if (a2.isActive) {
        if (n2[e] = a2.events.map(function(e2) {
          return { event: e2, srcTarget: document.documentElement, handler: function(e3) {
            return function(e4) {
              var n3 = e4.el, t3 = e4.event, r2 = e4.handler, a3 = e4.middleware, o3 = t3.path || t3.composedPath && t3.composedPath();
              (o3 ? o3.indexOf(n3) < 0 : !n3.contains(t3.target)) && i({ event: t3, handler: r2, middleware: a3 });
            }({ el: n2, event: e3, handler: o2, middleware: d2 });
          }, capture: u };
        }), c) {
          var l = { event: "blur", srcTarget: window, handler: function(e2) {
            return function(e3) {
              var n3 = e3.el, t3 = e3.event, r2 = e3.handler, a3 = e3.middleware;
              setTimeout(function() {
                var e4 = document.activeElement;
                e4 && "IFRAME" === e4.tagName && !n3.contains(e4) && i({ event: t3, handler: r2, middleware: a3 });
              }, 0);
            }({ el: n2, event: e2, handler: o2, middleware: d2 });
          }, capture: u };
          n2[e] = [].concat(n2[e], [l]);
        }
        n2[e].forEach(function(t3) {
          var r2 = t3.event, i2 = t3.srcTarget, a3 = t3.handler;
          return setTimeout(function() {
            n2[e] && i2.addEventListener(r2, a3, u);
          }, 0);
        });
      }
    }, o = function(n2) {
      (n2[e] || []).forEach(function(e2) {
        return e2.srcTarget.removeEventListener(e2.event, e2.handler, e2.capture);
      }), delete n2[e];
    }, d = n ? { beforeMount: a, updated: function(e2, n2) {
      var t2 = n2.value, r2 = n2.oldValue;
      JSON.stringify(t2) !== JSON.stringify(r2) && (o(e2), a(e2, { value: t2 }));
    }, unmounted: o } : {};
    return { install: function(e2) {
      e2.directive("click-outside", d);
    }, directive: d };
  });
});
var script = {
  name: "VueSimpleContextMenu",
  props: {
    elementId: {
      type: String,
      required: true
    },
    options: {
      type: Array,
      required: true
    }
  },
  emits: ["menu-closed", "option-clicked"],
  directives: {
    "click-outside": vClickOutside_umd.directive
  },
  data: function data() {
    return {
      item: null,
      menuHeight: null,
      menuWidth: null
    };
  },
  methods: {
    showMenu: function showMenu(event, item) {
      this.item = item;
      var menu = document.getElementById(this.elementId);
      if (!menu) {
        return;
      }
      if (!this.menuWidth || !this.menuHeight) {
        menu.style.visibility = "hidden";
        menu.style.display = "block";
        this.menuWidth = menu.offsetWidth;
        this.menuHeight = menu.offsetHeight;
        menu.removeAttribute("style");
      }
      if (this.menuWidth + event.pageX >= window.innerWidth) {
        menu.style.left = event.pageX - this.menuWidth + 2 + "px";
      } else {
        menu.style.left = event.pageX - 2 + "px";
      }
      if (this.menuHeight + event.pageY >= window.innerHeight) {
        menu.style.top = event.pageY - this.menuHeight + 2 + "px";
      } else {
        menu.style.top = event.pageY - 2 + "px";
      }
      menu.classList.add("vue-simple-context-menu--active");
    },
    hideContextMenu: function hideContextMenu() {
      var element = document.getElementById(this.elementId);
      if (element) {
        element.classList.remove("vue-simple-context-menu--active");
        this.$emit("menu-closed");
      }
    },
    onClickOutside: function onClickOutside() {
      this.hideContextMenu();
    },
    optionClicked: function optionClicked(option) {
      this.hideContextMenu();
      this.$emit("option-clicked", {
        item: this.item,
        option
      });
    },
    onEscKeyRelease: function onEscKeyRelease(event) {
      if (event.keyCode === 27) {
        this.hideContextMenu();
      }
    }
  },
  mounted: function mounted() {
    document.body.addEventListener("keyup", this.onEscKeyRelease);
  },
  beforeUnmount: function beforeUnmount() {
    document.removeEventListener("keyup", this.onEscKeyRelease);
  }
};
var _hoisted_1 = ["id"];
var _hoisted_2 = ["onClick"];
var _hoisted_3 = ["innerHTML"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _directive_click_outside = resolveDirective("click-outside");
  return openBlock(), createElementBlock("div", null, [
    withDirectives((openBlock(), createElementBlock("ul", {
      id: $props.elementId,
      class: "vue-simple-context-menu"
    }, [
      (openBlock(true), createElementBlock(
        Fragment,
        null,
        renderList($props.options, function(option, index) {
          return openBlock(), createElementBlock("li", {
            key: index,
            onClick: withModifiers(function($event) {
              return $options.optionClicked(option);
            }, ["stop"]),
            class: normalizeClass(["vue-simple-context-menu__item", [option.class, option.type === "divider" ? "vue-simple-context-menu__divider" : ""]])
          }, [
            createBaseVNode("span", {
              innerHTML: option.name
            }, null, 8, _hoisted_3)
          ], 10, _hoisted_2);
        }),
        128
        /* KEYED_FRAGMENT */
      ))
    ], 8, _hoisted_1)), [
      [_directive_click_outside, $options.onClickOutside]
    ])
  ]);
}
script.render = render;
script.__file = "src/vue-simple-context-menu.vue";
function install(app) {
  if (install.installed) {
    return;
  }
  install.installed = true;
  app.component("VueSimpleContextMenu", script);
}
var plugin = { install };
var GlobalVue = null;
if (typeof window !== "undefined") {
  GlobalVue = window.Vue;
} else if (typeof global !== "undefined") {
  GlobalVue = global.Vue;
}
if (GlobalVue) {
  GlobalVue.use(plugin);
}
var vue_simple_context_menu_esm_default = script;
export {
  vue_simple_context_menu_esm_default as default,
  install
};
//# sourceMappingURL=vue-simple-context-menu.js.map

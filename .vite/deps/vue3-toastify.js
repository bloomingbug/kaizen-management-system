import {
  Fragment,
  cloneVNode,
  computed,
  createApp,
  createVNode,
  defineComponent,
  h,
  isVNode,
  mergeProps,
  nextTick,
  onMounted,
  onUnmounted,
  reactive,
  ref,
  toRaw,
  watchEffect
} from "./chunk-YZFR4XBS.js";
import "./chunk-DFKQJ226.js";

// node_modules/vue3-toastify/dist/esm/index.js
var __defProp = Object.defineProperty;
var __defProps = Object.defineProperties;
var __getOwnPropDescs = Object.getOwnPropertyDescriptors;
var __getOwnPropSymbols = Object.getOwnPropertySymbols;
var __hasOwnProp = Object.prototype.hasOwnProperty;
var __propIsEnum = Object.prototype.propertyIsEnumerable;
var __defNormalProp = (obj, key, value) => key in obj ? __defProp(obj, key, { enumerable: true, configurable: true, writable: true, value }) : obj[key] = value;
var __spreadValues = (a, b) => {
  for (var prop in b || (b = {}))
    if (__hasOwnProp.call(b, prop))
      __defNormalProp(a, prop, b[prop]);
  if (__getOwnPropSymbols)
    for (var prop of __getOwnPropSymbols(b)) {
      if (__propIsEnum.call(b, prop))
        __defNormalProp(a, prop, b[prop]);
    }
  return a;
};
var __spreadProps = (a, b) => __defProps(a, __getOwnPropDescs(b));
var __objRest = (source, exclude) => {
  var target = {};
  for (var prop in source)
    if (__hasOwnProp.call(source, prop) && exclude.indexOf(prop) < 0)
      target[prop] = source[prop];
  if (source != null && __getOwnPropSymbols)
    for (var prop of __getOwnPropSymbols(source)) {
      if (exclude.indexOf(prop) < 0 && __propIsEnum.call(source, prop))
        target[prop] = source[prop];
    }
  return target;
};
var POSITION = {
  TOP_LEFT: "top-left",
  TOP_RIGHT: "top-right",
  TOP_CENTER: "top-center",
  BOTTOM_LEFT: "bottom-left",
  BOTTOM_RIGHT: "bottom-right",
  BOTTOM_CENTER: "bottom-center"
};
var THEME = {
  LIGHT: "light",
  DARK: "dark",
  COLORED: "colored",
  AUTO: "auto"
};
var TYPE = {
  INFO: "info",
  SUCCESS: "success",
  WARNING: "warning",
  ERROR: "error",
  DEFAULT: "default"
};
var TRANSITIONS = {
  BOUNCE: "bounce",
  SLIDE: "slide",
  FLIP: "flip",
  ZOOM: "zoom"
};
var defaultOptions = {
  dangerouslyHTMLString: false,
  multiple: true,
  position: POSITION.TOP_RIGHT,
  autoClose: 5e3,
  transition: "bounce",
  hideProgressBar: false,
  pauseOnHover: true,
  pauseOnFocusLoss: true,
  closeOnClick: true,
  className: "",
  bodyClassName: "",
  style: {},
  progressClassName: "",
  progressStyle: {},
  role: "alert",
  theme: "light"
};
var defaultToastContainerOptions = {
  rtl: false,
  newestOnTop: false,
  toastClassName: ""
};
var defaultGlobalOptions = __spreadValues(__spreadValues({}, defaultOptions), defaultToastContainerOptions);
var defaultToastOptions = __spreadProps(__spreadValues({}, defaultOptions), {
  data: {},
  type: TYPE.DEFAULT,
  icon: false
});
var Default = function(Default2) {
  Default2[Default2["COLLAPSE_DURATION"] = 300] = "COLLAPSE_DURATION";
  Default2[Default2["DEBOUNCE_DURATION"] = 50] = "DEBOUNCE_DURATION";
  Default2["CSS_NAMESPACE"] = "Toastify";
  return Default2;
}({});
var SyntheticEvent = function(SyntheticEvent2) {
  SyntheticEvent2["ENTRANCE_ANIMATION_END"] = "d";
  return SyntheticEvent2;
}({});
var Bounce = {
  enter: `${Default.CSS_NAMESPACE}--animate ${Default.CSS_NAMESPACE}__bounce-enter`,
  exit: `${Default.CSS_NAMESPACE}--animate ${Default.CSS_NAMESPACE}__bounce-exit`,
  appendPosition: true
};
var Slide = {
  enter: `${Default.CSS_NAMESPACE}--animate ${Default.CSS_NAMESPACE}__slide-enter`,
  exit: `${Default.CSS_NAMESPACE}--animate ${Default.CSS_NAMESPACE}__slide-exit`,
  appendPosition: true
};
var Zoom = {
  enter: `${Default.CSS_NAMESPACE}--animate ${Default.CSS_NAMESPACE}__zoom-enter`,
  exit: `${Default.CSS_NAMESPACE}--animate ${Default.CSS_NAMESPACE}__zoom-exit`
};
var Flip = {
  enter: `${Default.CSS_NAMESPACE}--animate ${Default.CSS_NAMESPACE}__flip-enter`,
  exit: `${Default.CSS_NAMESPACE}--animate ${Default.CSS_NAMESPACE}__flip-exit`
};
function getDefaultTransition(type) {
  let result = Bounce;
  if (!type || typeof type === "string") {
    switch (type) {
      case "flip":
        result = Flip;
        break;
      case "zoom":
        result = Zoom;
        break;
      case "slide":
        result = Slide;
        break;
      default:
        break;
    }
  } else {
    result = type;
  }
  return result;
}
function getContainerId(options) {
  return options.containerId || String(options.position);
}
var UnmountTag = "will-unmount";
function toastContainerInScreen() {
  let position = arguments.length > 0 && arguments[0] !== void 0 ? arguments[0] : POSITION.TOP_RIGHT;
  return !!document.querySelector(`.${Default.CSS_NAMESPACE}__toast-container--${position}`);
}
function getToastPosClassName() {
  let position = arguments.length > 0 && arguments[0] !== void 0 ? arguments[0] : POSITION.TOP_RIGHT;
  return `${Default.CSS_NAMESPACE}__toast-container--${position}`;
}
function getContainerClassName(position, className) {
  let rtl = arguments.length > 2 && arguments[2] !== void 0 ? arguments[2] : false;
  const defaultClassName = [`${Default.CSS_NAMESPACE}__toast-container`, `${Default.CSS_NAMESPACE}__toast-container--${position}`, rtl ? `${Default.CSS_NAMESPACE}__toast-container--rtl` : null].filter(Boolean).join(" ");
  return isFn(className) ? className({
    position,
    rtl,
    defaultClassName
  }) : `${defaultClassName} ${className || ""}`;
}
function generateRenderRoot(options) {
  var _a;
  const {
    position,
    containerClassName,
    rtl = false,
    style = {}
  } = options;
  const rootClass = Default.CSS_NAMESPACE;
  const toastPosClassName = getToastPosClassName(position);
  const root = document.querySelector(`.${rootClass}`);
  const willRenderRoot = document.querySelector(`.${toastPosClassName}`);
  const existRenderRoot = !!willRenderRoot && !((_a = willRenderRoot.className) == null ? void 0 : _a.includes(UnmountTag));
  const container = root || document.createElement("div");
  const renderRoot = document.createElement("div");
  renderRoot.className = getContainerClassName(position, containerClassName, rtl);
  renderRoot.dataset.testid = `${Default.CSS_NAMESPACE}__toast-container--${position}`;
  renderRoot.id = getContainerId(options);
  for (const name in style) {
    if (Object.prototype.hasOwnProperty.call(style, name)) {
      const val = style[name];
      renderRoot.style[name] = val;
    }
  }
  if (!root) {
    container.className = Default.CSS_NAMESPACE;
    document.body.appendChild(container);
  }
  if (!existRenderRoot) {
    container.appendChild(renderRoot);
  }
  return renderRoot;
}
function unmountComponent(evt) {
  var _a, _b, _c;
  const containerId = typeof evt === "string" ? evt : ((_a = evt.currentTarget) == null ? void 0 : _a.id) || ((_b = evt.target) == null ? void 0 : _b.id);
  const target = document.getElementById(containerId);
  if (target) {
    target.removeEventListener("animationend", unmountComponent, false);
  }
  try {
    containerInstances[containerId].unmount();
    (_c = document.getElementById(containerId)) == null ? void 0 : _c.remove();
    delete containerInstances[containerId];
    delete toastContainers[containerId];
  } catch (error) {
  }
}
var containerInstances = reactive({});
function cacheRenderInstance(app, id) {
  const container = document.getElementById(String(id));
  if (container) {
    containerInstances[container.id] = app;
  }
}
function removeContainer(containerId) {
  let withExitAnimation = arguments.length > 1 && arguments[1] !== void 0 ? arguments[1] : true;
  const id = String(containerId);
  if (!containerInstances[id])
    return;
  const target = document.getElementById(id);
  if (target) {
    target.classList.add(UnmountTag);
  }
  if (withExitAnimation) {
    resolveNodesAnimation(containerId);
    if (target) {
      target.addEventListener("animationend", unmountComponent, false);
    }
  } else {
    unmountComponent(id);
  }
  queue.items = queue.items.filter((v) => v.containerId !== containerId);
}
function clearContainers(withExitAnimation) {
  for (const id in containerInstances) {
    removeContainer(id, withExitAnimation);
  }
  queue.items = [];
}
function addExitAnimateToNode(item, clasback) {
  const node = document.getElementById(item.toastId);
  if (node) {
    let v = item;
    v = __spreadValues(__spreadValues({}, v), getDefaultTransition(v.transition));
    const exitClassName = v.appendPosition ? `${v.exit}--${v.position}` : v.exit;
    node.className += ` ${exitClassName}`;
    if (clasback) {
      clasback(node);
    }
  }
}
function resolveNodesAnimation(containerId) {
  for (const id in toastContainers) {
    if (id === containerId) {
      for (const item of toastContainers[id] || []) {
        addExitAnimateToNode(item);
      }
    }
  }
}
function getContainerIdByToastId(id) {
  const all = getAllToast();
  const toast2 = all.find((v) => v.toastId === id);
  return toast2 == null ? void 0 : toast2.containerId;
}
function getContainerById(containerId) {
  return document.getElementById(containerId);
}
function needWaitingForUnmount(options) {
  const container = getContainerById(options.containerId);
  return container && container.classList.contains(UnmountTag);
}
function getCallbackProps(opts) {
  var _a;
  const result = isVNode(opts.content) ? toRaw(opts.content.props) : null;
  return result != null ? result : toRaw((_a = opts.data) != null ? _a : {});
}
function existQueueItem(containerId) {
  if (!containerId) {
    return queue.items.length > 0;
  } else {
    const items = queue.items.filter((v) => v.containerId === containerId);
    return items.length > 0;
  }
}
function appendFromQueue() {
  if (queue.items.length > 0) {
    const append = queue.items.shift();
    doAppend(append == null ? void 0 : append.toastContent, append == null ? void 0 : append.toastProps);
  }
}
var toastContainers = reactive({});
var queue = reactive({
  items: []
});
function getAllToast() {
  const rawMap = toRaw(toastContainers);
  return Object.values(rawMap).reduce((t, v) => [...t, ...v], []);
}
function getToast(toastId) {
  const toasts = getAllToast();
  return toasts.find((v) => v.toastId === toastId);
}
function doAppend(content) {
  let options = arguments.length > 1 && arguments[1] !== void 0 ? arguments[1] : {};
  if (needWaitingForUnmount(options)) {
    const container = getContainerById(options.containerId);
    if (container) {
      container.addEventListener("animationend", resolveAppend.bind(null, content, options), false);
    }
  } else {
    resolveAppend(content, options);
  }
}
function resolveAppend(content) {
  let options = arguments.length > 1 && arguments[1] !== void 0 ? arguments[1] : {};
  const container = getContainerById(options.containerId);
  if (container) {
    container.removeEventListener("animationend", resolveAppend.bind(null, content, options), false);
  }
  const sameContainerToasts = toastContainers[options.containerId] || [];
  const hasSameContainer = sameContainerToasts.length > 0;
  if (!hasSameContainer && !toastContainerInScreen(options.position)) {
    const rootDom = generateRenderRoot(options);
    const app = createApp(toastify_container_default, options);
    app.mount(rootDom);
    cacheRenderInstance(app, rootDom.id);
  }
  if (hasSameContainer) {
    options.position = sameContainerToasts[0].position;
  }
  nextTick(() => {
    if (options.updateId) {
      ToastActions.update(options);
    } else {
      ToastActions.add(content, options);
    }
  });
}
var ToastActions = {
  /**
   * add a toast
   * @param _ ..
   * @param opts toast props
   */
  add(_, opts) {
    const {
      containerId = ""
    } = opts;
    if (containerId) {
      toastContainers[containerId] = toastContainers[containerId] || [];
      if (!toastContainers[containerId].find((v) => v.toastId === opts.toastId)) {
        setTimeout(() => {
          var _a, _b;
          if (opts.newestOnTop) {
            (_a = toastContainers[containerId]) == null ? void 0 : _a.unshift(opts);
          } else {
            (_b = toastContainers[containerId]) == null ? void 0 : _b.push(opts);
          }
          if (opts.onOpen) {
            opts.onOpen(getCallbackProps(opts));
          }
        }, opts.delay || 0);
      }
    }
  },
  /**
   * remove a toast
   * @param id toastId
   */
  remove(id) {
    if (id) {
      const containerId = getContainerIdByToastId(id);
      if (containerId) {
        const toasts = toastContainers[containerId];
        let item = toasts.find((v) => v.toastId === id);
        toastContainers[containerId] = toasts.filter((v) => v.toastId !== id);
        if (!toastContainers[containerId].length && !existQueueItem(containerId)) {
          removeContainer(containerId, false);
        }
        appendFromQueue();
        nextTick(() => {
          if (item == null ? void 0 : item.onClose) {
            item.onClose(getCallbackProps(item));
            item = void 0;
          }
        });
      }
    }
  },
  /**
   * update the toast
   * @param opts toast props
   */
  update() {
    let opts = arguments.length > 0 && arguments[0] !== void 0 ? arguments[0] : {};
    const {
      containerId = ""
    } = opts;
    if (containerId && opts.updateId) {
      toastContainers[containerId] = toastContainers[containerId] || [];
      const item = toastContainers[containerId].find((v) => v.toastId === opts.toastId);
      if (item) {
        setTimeout(() => {
          for (const optName in opts) {
            if (Object.prototype.hasOwnProperty.call(opts, optName)) {
              const value = opts[optName];
              item[optName] = value;
            }
          }
        }, opts.delay || 0);
      }
    }
  },
  /**
   * clear all toasts in container.
   * @param containerId container id
   */
  clear(containerId) {
    let withExitAnimation = arguments.length > 1 && arguments[1] !== void 0 ? arguments[1] : true;
    if (!containerId) {
      clearContainers(withExitAnimation);
    } else {
      removeContainer(containerId, withExitAnimation);
    }
  },
  dismissCallback(evt) {
    var _a;
    const toastId = (_a = evt.currentTarget) == null ? void 0 : _a.id;
    const node = document.getElementById(toastId);
    if (node) {
      node.removeEventListener("animationend", ToastActions.dismissCallback, false);
      setTimeout(() => {
        ToastActions.remove(toastId);
      });
    }
  },
  dismiss(toastId) {
    if (toastId) {
      const allToasts = getAllToast();
      for (const item of allToasts) {
        if (item.toastId === toastId) {
          addExitAnimateToNode(item, (node) => {
            node.addEventListener("animationend", ToastActions.dismissCallback, false);
          });
          break;
        }
      }
    }
  }
};
var globalOptions = reactive({});
function generateToastId() {
  return Math.random().toString(36).substring(2, 9);
}
function isNum(v) {
  return typeof v === "number" && !isNaN(v);
}
function isStr(v) {
  return typeof v === "string";
}
function isFn(v) {
  return typeof v === "function";
}
function mergeOptions() {
  for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
    args[_key] = arguments[_key];
  }
  return mergeProps(...args);
}
function isComponent(content) {
  return typeof content === "object" && (!!(content == null ? void 0 : content.render) || !!(content == null ? void 0 : content.setup) || typeof (content == null ? void 0 : content.type) === "object");
}
function saveGlobalOptions() {
  let options = arguments.length > 0 && arguments[0] !== void 0 ? arguments[0] : {};
  globalOptions[`${Default.CSS_NAMESPACE}-default-options`] = options;
}
function getGlobalOptions() {
  return globalOptions[`${Default.CSS_NAMESPACE}-default-options`] || defaultGlobalOptions;
}
function getSystemTheme() {
  return document.documentElement.classList.contains("dark") ? "dark" : "light";
}
var AnimationStep = function(AnimationStep2) {
  AnimationStep2[AnimationStep2["Enter"] = 0] = "Enter";
  AnimationStep2[AnimationStep2["Exit"] = 1] = "Exit";
  return AnimationStep2;
}({});
var props = {
  containerId: {
    type: [String, Number],
    required: false,
    default: ""
  },
  dangerouslyHTMLString: {
    type: Boolean,
    required: false,
    default: false
  },
  multiple: {
    type: Boolean,
    required: false,
    default: true
  },
  limit: {
    type: Number,
    required: false,
    default: void 0
  },
  position: {
    type: String,
    required: false,
    default: POSITION.TOP_LEFT
  },
  bodyClassName: {
    type: String,
    required: false,
    default: ""
  },
  autoClose: {
    type: [Number, Boolean],
    required: false,
    default: false
  },
  closeButton: {
    type: [Boolean, Function, Object],
    required: false,
    default: void 0
  },
  transition: {
    type: [String, Object],
    required: false,
    default: "bounce"
  },
  hideProgressBar: {
    type: Boolean,
    required: false,
    default: false
  },
  pauseOnHover: {
    type: Boolean,
    required: false,
    default: true
  },
  pauseOnFocusLoss: {
    type: Boolean,
    required: false,
    default: true
  },
  closeOnClick: {
    type: Boolean,
    required: false,
    default: true
  },
  progress: {
    type: Number,
    required: false,
    default: void 0
  },
  progressClassName: {
    type: String,
    required: false,
    default: ""
  },
  toastStyle: {
    type: Object,
    required: false,
    default() {
      return {};
    }
  },
  progressStyle: {
    type: Object,
    required: false,
    default() {
      return {};
    }
  },
  role: {
    type: String,
    required: false,
    default: "alert"
  },
  theme: {
    type: String,
    required: false,
    default: THEME.AUTO
  },
  content: {
    type: [String, Object, Function],
    required: false,
    default: ""
  },
  toastId: {
    type: [String, Number],
    required: false,
    default: ""
  },
  data: {
    type: [Object, String],
    required: false,
    default() {
      return {};
    }
  },
  type: {
    type: String,
    required: false,
    default: TYPE.DEFAULT
  },
  icon: {
    type: [Boolean, String, Number, Object, Function],
    required: false,
    default: void 0
  },
  delay: {
    type: Number,
    required: false,
    default: void 0
  },
  onOpen: {
    type: Function,
    required: false,
    default: void 0
  },
  onClose: {
    type: Function,
    required: false,
    default: void 0
  },
  onClick: {
    type: Function,
    required: false,
    default: void 0
  },
  isLoading: {
    type: Boolean,
    required: false,
    default: void 0
  },
  rtl: {
    type: Boolean,
    required: false,
    default: false
  },
  toastClassName: {
    type: String,
    required: false,
    default: ""
  },
  updateId: {
    type: [String, Number],
    required: false,
    default: ""
  }
};
var prop_default = props;
var props2 = {
  autoClose: {
    type: [Number, Boolean],
    required: true
  },
  isRunning: {
    type: Boolean,
    required: false,
    default: void 0
  },
  type: {
    type: String,
    required: false,
    default: TYPE.DEFAULT
  },
  theme: {
    type: String,
    required: false,
    default: THEME.AUTO
  },
  hide: {
    type: Boolean,
    required: false,
    default: void 0
  },
  className: {
    type: [String, Function],
    required: false,
    default: ""
  },
  controlledProgress: {
    type: Boolean,
    required: false,
    default: void 0
  },
  rtl: {
    type: Boolean,
    required: false,
    default: void 0
  },
  isIn: {
    type: Boolean,
    required: false,
    default: void 0
  },
  progress: {
    type: Number,
    required: false,
    default: void 0
  },
  closeToast: {
    type: Function,
    required: false,
    default: void 0
  }
};
var ProgressBar = defineComponent({
  name: "ProgressBar",
  props: props2,
  // @ts-ignore
  setup(props3, _ref) {
    let {
      attrs
    } = _ref;
    const nodeRef = ref();
    const ariaHidden = computed(() => props3.hide ? "true" : "false");
    const style = computed(() => __spreadProps(__spreadValues({}, attrs.style || {}), {
      animationDuration: `${props3.autoClose === true ? 5e3 : props3.autoClose}ms`,
      animationPlayState: props3.isRunning ? "running" : "paused",
      opacity: props3.hide ? 0 : 1,
      transform: props3.controlledProgress ? `scaleX(${props3.progress})` : "none"
    }));
    const defaultClassName = computed(() => [`${Default.CSS_NAMESPACE}__progress-bar`, props3.controlledProgress ? `${Default.CSS_NAMESPACE}__progress-bar--controlled` : `${Default.CSS_NAMESPACE}__progress-bar--animated`, `${Default.CSS_NAMESPACE}__progress-bar-theme--${props3.theme}`, `${Default.CSS_NAMESPACE}__progress-bar--${props3.type}`, props3.rtl ? `${Default.CSS_NAMESPACE}__progress-bar--rtl` : null].filter(Boolean).join(" "));
    const classNames = computed(() => `${defaultClassName.value} ${(attrs == null ? void 0 : attrs.class) || ""}`);
    const removeEventListener = () => {
      if (nodeRef.value) {
        nodeRef.value.onanimationend = null;
        nodeRef.value.ontransitionend = null;
      }
    };
    const eventCallback = () => {
      if (props3.isIn && props3.closeToast && props3.autoClose !== false) {
        props3.closeToast();
        removeEventListener();
      }
    };
    const animationendEventHandler = computed(() => props3.controlledProgress ? null : eventCallback);
    const transitionendEventHandler = computed(() => !props3.controlledProgress ? null : eventCallback);
    watchEffect(() => {
      if (nodeRef.value) {
        removeEventListener();
        nodeRef.value.onanimationend = animationendEventHandler.value;
        nodeRef.value.ontransitionend = transitionendEventHandler.value;
      }
    });
    return () => createVNode("div", {
      "ref": nodeRef,
      "role": "progressbar",
      "aria-hidden": ariaHidden.value,
      "aria-label": "notification timer",
      "class": classNames.value,
      "style": style.value
    }, null);
  }
});
var ProgressBar_default = ProgressBar;
var CloseButton = defineComponent({
  name: "CloseButton",
  inheritAttrs: false,
  props: {
    theme: {
      type: String,
      required: false,
      default: THEME.AUTO
    },
    type: {
      type: String,
      required: false,
      default: THEME.LIGHT
    },
    ariaLabel: {
      type: String,
      required: false,
      default: "close"
    },
    closeToast: {
      type: Function,
      required: false,
      default: void 0
    }
  },
  setup(props3) {
    return () => createVNode("button", {
      "class": `${Default.CSS_NAMESPACE}__close-button ${Default.CSS_NAMESPACE}__close-button--${props3.theme}`,
      "type": "button",
      "onClick": (e) => {
        e.stopPropagation();
        if (props3.closeToast)
          props3.closeToast(e);
      },
      "aria-label": props3.ariaLabel
    }, [createVNode("svg", {
      "aria-hidden": "true",
      "viewBox": "0 0 14 16"
    }, [createVNode("path", {
      "fill-rule": "evenodd",
      "d": "M7.71 8.23l3.75 3.75-1.48 1.48-3.75-3.75-3.75 3.75L1 11.98l3.75-3.75L1 4.48 2.48 3l3.75 3.75L9.98 3l1.48 1.48-3.75 3.75z"
    }, null)])]);
  }
});
var Svg = (_ref) => {
  let _a = _ref, {
    theme,
    type,
    path
  } = _a, rest = __objRest(_a, [
    "theme",
    "type",
    "path"
  ]);
  return createVNode("svg", mergeProps({
    "viewBox": "0 0 24 24",
    "width": "100%",
    "height": "100%",
    "fill": theme === "colored" ? "currentColor" : `var(--toastify-icon-color-${type})`
  }, rest), [createVNode("path", {
    "d": path
  }, null)]);
};
function Warning(props3) {
  return createVNode(Svg, mergeProps(props3, {
    "path": "M23.32 17.191L15.438 2.184C14.728.833 13.416 0 11.996 0c-1.42 0-2.733.833-3.443 2.184L.533 17.448a4.744 4.744 0 000 4.368C1.243 23.167 2.555 24 3.975 24h16.05C22.22 24 24 22.044 24 19.632c0-.904-.251-1.746-.68-2.44zm-9.622 1.46c0 1.033-.724 1.823-1.698 1.823s-1.698-.79-1.698-1.822v-.043c0-1.028.724-1.822 1.698-1.822s1.698.79 1.698 1.822v.043zm.039-12.285l-.84 8.06c-.057.581-.408.943-.897.943-.49 0-.84-.367-.896-.942l-.84-8.065c-.057-.624.25-1.095.779-1.095h1.91c.528.005.84.476.784 1.1z"
  }), null);
}
function Info(props3) {
  return createVNode(Svg, mergeProps(props3, {
    "path": "M12 0a12 12 0 1012 12A12.013 12.013 0 0012 0zm.25 5a1.5 1.5 0 11-1.5 1.5 1.5 1.5 0 011.5-1.5zm2.25 13.5h-4a1 1 0 010-2h.75a.25.25 0 00.25-.25v-4.5a.25.25 0 00-.25-.25h-.75a1 1 0 010-2h1a2 2 0 012 2v4.75a.25.25 0 00.25.25h.75a1 1 0 110 2z"
  }), null);
}
function Success(props3) {
  return createVNode(Svg, mergeProps(props3, {
    "path": "M12 0a12 12 0 1012 12A12.014 12.014 0 0012 0zm6.927 8.2l-6.845 9.289a1.011 1.011 0 01-1.43.188l-4.888-3.908a1 1 0 111.25-1.562l4.076 3.261 6.227-8.451a1 1 0 111.61 1.183z"
  }), null);
}
function Error2(props3) {
  return createVNode(Svg, mergeProps(props3, {
    "path": "M11.983 0a12.206 12.206 0 00-8.51 3.653A11.8 11.8 0 000 12.207 11.779 11.779 0 0011.8 24h.214A12.111 12.111 0 0024 11.791 11.766 11.766 0 0011.983 0zM10.5 16.542a1.476 1.476 0 011.449-1.53h.027a1.527 1.527 0 011.523 1.47 1.475 1.475 0 01-1.449 1.53h-.027a1.529 1.529 0 01-1.523-1.47zM11 12.5v-6a1 1 0 012 0v6a1 1 0 11-2 0z"
  }), null);
}
function Spinner() {
  return createVNode("div", {
    "class": `${Default.CSS_NAMESPACE}__spinner`
  }, null);
}
var Icons = {
  info: Info,
  warning: Warning,
  success: Success,
  error: Error2,
  spinner: Spinner
};
var maybeIcon = (type) => type in Icons;
function getIcon(_ref2) {
  let {
    theme,
    type,
    isLoading,
    icon
  } = _ref2;
  let Icon;
  const iconProps = {
    theme,
    type
  };
  if (isLoading) {
    Icon = Icons.spinner();
  } else if (icon === false) {
    Icon = void 0;
  } else if (isComponent(icon)) {
    Icon = toRaw(icon);
  } else if (isFn(icon)) {
    const iconCreator = icon;
    Icon = iconCreator(iconProps);
  } else if (isVNode(icon)) {
    Icon = cloneVNode(icon, iconProps);
  } else if (isStr(icon) || isNum(icon)) {
    Icon = icon;
  } else if (maybeIcon(type)) {
    Icon = Icons[type](iconProps);
  }
  return Icon;
}
var NullCallback = () => {
};
function collapseToast(node, done) {
  let duration = arguments.length > 2 && arguments[2] !== void 0 ? arguments[2] : Default.COLLAPSE_DURATION;
  const {
    scrollHeight,
    style
  } = node;
  const delay = duration;
  requestAnimationFrame(() => {
    style.minHeight = "initial";
    style.height = scrollHeight + "px";
    style.transition = `all ${delay}ms`;
    requestAnimationFrame(() => {
      style.height = "0";
      style.padding = "0";
      style.margin = "0";
      setTimeout(done, delay);
    });
  });
}
function useCssTransition(props3) {
  const isRunning = ref(false);
  const isIn = ref(false);
  const preventExitTransition = ref(false);
  const animationStep = ref(AnimationStep.Enter);
  const options = reactive(__spreadProps(__spreadValues({}, props3), {
    appendPosition: props3.appendPosition || false,
    collapse: typeof props3.collapse === "undefined" ? true : props3.collapse,
    collapseDuration: props3.collapseDuration || Default.COLLAPSE_DURATION
  }));
  const doneHandler = options.done || NullCallback;
  const enterClassName = computed(() => options.appendPosition ? `${options.enter}--${options.position}` : options.enter);
  const exitClassName = computed(() => options.appendPosition ? `${options.exit}--${options.position}` : options.exit);
  const eventHandlers = computed(() => props3.pauseOnHover ? {
    onMouseenter: pauseToast,
    onMouseleave: playToast
  } : {});
  function onEnterHandler() {
    const classToToken = enterClassName.value.split(" ");
    getTargetNode().addEventListener(SyntheticEvent.ENTRANCE_ANIMATION_END, playToast, {
      once: true
    });
    const onEntered = (e) => {
      const node = getTargetNode();
      if (e.target !== node)
        return;
      node.dispatchEvent(new Event(SyntheticEvent.ENTRANCE_ANIMATION_END));
      node.removeEventListener("animationend", onEntered);
      node.removeEventListener("animationcancel", onEntered);
      if (animationStep.value === AnimationStep.Enter && e.type !== "animationcancel") {
        node.classList.remove(...classToToken);
      }
    };
    const onEnter = () => {
      const node = getTargetNode();
      node.classList.add(...classToToken);
      node.addEventListener("animationend", onEntered);
      node.addEventListener("animationcancel", onEntered);
    };
    if (props3.pauseOnFocusLoss) {
      bindFocusEvents();
    }
    onEnter();
  }
  function onExitHandler() {
    if (!getTargetNode())
      return;
    const onExited = () => {
      const node = getTargetNode();
      node.removeEventListener("animationend", onExited);
      if (options.collapse) {
        collapseToast(node, doneHandler, options.collapseDuration);
      } else {
        doneHandler();
      }
    };
    const onExit = () => {
      const node = getTargetNode();
      animationStep.value = AnimationStep.Exit;
      if (node) {
        node.className += ` ${exitClassName.value}`;
        node.addEventListener("animationend", onExited);
      }
    };
    if (!isIn.value) {
      if (preventExitTransition.value) {
        onExited();
      } else {
        setTimeout(onExit);
      }
    }
  }
  function getTargetNode() {
    return props3.toastRef.value;
  }
  function bindFocusEvents() {
    if (!document.hasFocus())
      pauseToast();
    window.addEventListener("focus", playToast);
    window.addEventListener("blur", pauseToast);
  }
  function unbindFocusEvents() {
    window.removeEventListener("focus", playToast);
    window.removeEventListener("blur", pauseToast);
  }
  function playToast() {
    if (!props3.loading.value || props3.isLoading === void 0) {
      isRunning.value = true;
    }
  }
  function pauseToast() {
    isRunning.value = false;
  }
  function hideToast(e) {
    if (e) {
      e.stopPropagation();
      e.preventDefault();
    }
    isIn.value = false;
  }
  watchEffect(onExitHandler);
  watchEffect(() => {
    const all = getAllToast();
    isIn.value = all.findIndex((v) => v.toastId === options.toastId) > -1;
  });
  watchEffect(() => {
    if (props3.isLoading !== void 0) {
      if (props3.loading.value) {
        pauseToast();
      } else {
        playToast();
      }
    }
  });
  onMounted(onEnterHandler);
  onUnmounted(() => {
    if (props3.pauseOnFocusLoss) {
      unbindFocusEvents();
    }
  });
  return {
    isIn,
    isRunning,
    hideToast,
    eventHandlers
  };
}
var ToastItem = defineComponent({
  name: "ToastItem",
  inheritAttrs: false,
  props: prop_default,
  // @ts-ignore
  setup(item) {
    const toastRef = ref();
    const loading = computed(() => !!item.isLoading);
    const isProgressControlled = computed(() => item.progress !== void 0 && item.progress !== null);
    const toastIcon = computed(() => getIcon(item));
    const className = computed(() => [`${Default.CSS_NAMESPACE}__toast`, `${Default.CSS_NAMESPACE}__toast-theme--${item.theme}`, `${Default.CSS_NAMESPACE}__toast--${item.type}`, item.rtl ? `${Default.CSS_NAMESPACE}__toast--rtl` : void 0, item.toastClassName || ""].filter(Boolean).join(" "));
    const {
      isRunning,
      isIn,
      hideToast,
      eventHandlers
    } = useCssTransition(__spreadValues(__spreadValues({
      toastRef,
      loading,
      done: () => {
        ToastActions.remove(item.toastId);
      }
    }, getDefaultTransition(item.transition)), item));
    return () => createVNode("div", mergeProps({
      "id": item.toastId,
      "class": className.value,
      "style": item.toastStyle || {},
      "ref": toastRef,
      "data-testid": `toast-item-${item.toastId}`,
      "onClick": (e) => {
        if (item.closeOnClick) {
          hideToast();
        }
        if (item.onClick) {
          item.onClick(e);
        }
      }
    }, eventHandlers.value), [createVNode("div", {
      "role": item.role,
      "data-testid": "toast-body",
      "class": `${Default.CSS_NAMESPACE}__toast-body ${item.bodyClassName || ""}`
    }, [toastIcon.value != null && createVNode("div", {
      "data-testid": `toast-icon-${item.type}`,
      "class": [`${Default.CSS_NAMESPACE}__toast-icon`, !item.isLoading ? `${Default.CSS_NAMESPACE}--animate-icon ${Default.CSS_NAMESPACE}__zoom-enter` : ""].join(" ")
    }, [isComponent(toastIcon.value) ? h(toRaw(toastIcon.value), {
      theme: item.theme,
      type: item.type
    }) : isFn(toastIcon.value) ? toastIcon.value({
      theme: item.theme,
      type: item.type
    }) : toastIcon.value]), createVNode("div", {
      "data-testid": "toast-content"
    }, [isComponent(item.content) ? h(toRaw(item.content), {
      toastProps: toRaw(item),
      closeToast: hideToast,
      data: item.data
    }) : isFn(item.content) ? item.content({
      toastProps: toRaw(item),
      closeToast: hideToast,
      data: item.data
    }) : item.dangerouslyHTMLString ? h("div", {
      innerHTML: item.content
    }) : item.content])]), (item.closeButton === void 0 || item.closeButton === true) && createVNode(CloseButton, {
      "theme": item.theme,
      "closeToast": (e) => {
        e.stopPropagation();
        e.preventDefault();
        hideToast();
      }
    }, null), isComponent(item.closeButton) ? h(toRaw(item.closeButton), {
      closeToast: hideToast,
      type: item.type,
      theme: item.theme
    }) : isFn(item.closeButton) ? item.closeButton({
      closeToast: hideToast,
      type: item.type,
      theme: item.theme
    }) : null, createVNode(ProgressBar_default, {
      "className": item.progressClassName,
      "style": item.progressStyle,
      "rtl": item.rtl,
      "theme": item.theme,
      "isIn": isIn.value,
      "type": item.type,
      "hide": item.hideProgressBar,
      "isRunning": isRunning.value,
      "autoClose": item.autoClose,
      "controlledProgress": isProgressControlled.value,
      "progress": item.progress,
      "closeToast": item.isLoading ? void 0 : hideToast
    }, null)]);
  }
});
var ToastItem_default = ToastItem;
var ToastifyContainer = defineComponent({
  name: "ToastifyContainer",
  inheritAttrs: false,
  props: prop_default,
  // @ts-ignore
  setup(_props) {
    const containerId = computed(() => _props.containerId);
    const allToasts = computed(() => toastContainers[containerId.value] || []);
    const toasts = computed(() => allToasts.value.filter((v) => v.position === _props.position));
    return () => createVNode(Fragment, null, [toasts.value.map((item) => {
      const {
        toastId = ""
      } = item;
      return createVNode(ToastItem_default, mergeProps({
        "key": toastId
      }, item), null);
    })]);
  }
});
var toastify_container_default = ToastifyContainer;
var inThrottle = false;
function getAllActiveToast() {
  const result = [];
  const items = getAllToast();
  items.forEach((v) => {
    const container = document.getElementById(v.containerId);
    if (container && !container.classList.contains(UnmountTag)) {
      result.push(v);
    }
  });
  return result;
}
function watingForQueue(limit) {
  const displayedCount = getAllActiveToast().length;
  const limitCount = limit != null ? limit : 0;
  return limitCount > 0 && displayedCount + queue.items.length >= limitCount;
}
function resolveQueue(options) {
  if (watingForQueue(options.limit) && !options.updateId) {
    queue.items.push({
      toastId: options.toastId,
      containerId: options.containerId,
      toastContent: options.content,
      toastProps: options
    });
  }
}
function openToast(content, type) {
  let options = arguments.length > 2 && arguments[2] !== void 0 ? arguments[2] : {};
  if (inThrottle)
    return;
  options = mergeOptions(getGlobalOptions(), type, options);
  if (!options.toastId || typeof options.toastId !== "string" && typeof options.toastId !== "number") {
    options.toastId = generateToastId();
  }
  options = __spreadProps(__spreadValues({}, options), {
    content,
    containerId: options.containerId || String(options.position)
  });
  const progress = Number(options == null ? void 0 : options.progress);
  if (progress < 0) {
    options.progress = 0;
  }
  if (progress > 1) {
    options.progress = 1;
  }
  if (options.theme === "auto") {
    options.theme = getSystemTheme();
  }
  resolveQueue(options);
  if (!options.multiple) {
    inThrottle = true;
    toast.clearAll(void 0, false);
    setTimeout(() => {
      doAppend(content, options);
    }, 0);
    setTimeout(() => {
      inThrottle = false;
    }, 390);
  } else if (!queue.items.length) {
    doAppend(content, options);
  }
  return options.toastId;
}
var toast = (content, options) => openToast(content, TYPE.DEFAULT, options);
toast.info = (content, options) => openToast(content, TYPE.DEFAULT, __spreadProps(__spreadValues({}, options), {
  type: TYPE.INFO
}));
toast.error = (content, options) => openToast(content, TYPE.DEFAULT, __spreadProps(__spreadValues({}, options), {
  type: TYPE.ERROR
}));
toast.warning = (content, options) => openToast(content, TYPE.DEFAULT, __spreadProps(__spreadValues({}, options), {
  type: TYPE.WARNING
}));
toast.warn = toast.warning;
toast.success = (content, options) => openToast(content, TYPE.DEFAULT, __spreadProps(__spreadValues({}, options), {
  type: TYPE.SUCCESS
}));
toast.loading = (content, options) => openToast(content, TYPE.DEFAULT, mergeOptions(options, {
  isLoading: true,
  autoClose: false,
  closeOnClick: false,
  closeButton: false,
  draggable: false
}));
toast.dark = (content, options) => openToast(content, TYPE.DEFAULT, mergeOptions(options, {
  theme: THEME.DARK
}));
toast.remove = (toastId) => {
  if (toastId) {
    ToastActions.dismiss(toastId);
  } else {
    ToastActions.clear();
  }
};
toast.clearAll = (containerId, withExitAnimation) => {
  ToastActions.clear(containerId, withExitAnimation);
};
toast.isActive = (toastId) => {
  let isToastActive = false;
  const all = getAllActiveToast();
  isToastActive = all.findIndex((v) => v.toastId === toastId) > -1;
  return isToastActive;
};
toast.update = function(toastId) {
  let options = arguments.length > 1 && arguments[1] !== void 0 ? arguments[1] : {};
  setTimeout(() => {
    const item = getToast(toastId);
    if (item) {
      const oldOptions = toRaw(item);
      const {
        content: oldContent
      } = oldOptions;
      const nextOptions = __spreadProps(__spreadValues(__spreadValues({}, oldOptions), options), {
        toastId: options.toastId || toastId,
        updateId: generateToastId()
      });
      const content = nextOptions.render || oldContent;
      delete nextOptions.render;
      openToast(content, nextOptions.type, nextOptions);
    }
  }, 0);
};
toast.done = (id) => {
  toast.update(id, {
    isLoading: false,
    progress: 1
  });
};
toast.promise = handlePromise;
function handlePromise(promise, _ref, options) {
  let {
    pending,
    error,
    success
  } = _ref;
  let id;
  if (pending) {
    id = isStr(pending) ? toast.loading(pending, options) : toast.loading(pending.render, __spreadValues(__spreadValues({}, options), pending));
  }
  const resetParams = {
    isLoading: void 0,
    autoClose: null,
    closeOnClick: null,
    closeButton: null,
    draggable: null,
    delay: 100
  };
  const resolver = (type, input, result) => {
    if (input == null) {
      toast.remove(id);
      return;
    }
    const baseParams = __spreadProps(__spreadValues(__spreadValues({
      type
    }, resetParams), options), {
      data: result
    });
    const params = isStr(input) ? {
      render: input
    } : input;
    if (id) {
      toast.update(id, __spreadProps(__spreadValues(__spreadValues({}, baseParams), params), {
        isLoading: false,
        autoClose: true
      }));
    } else {
      toast(params.render, __spreadProps(__spreadValues(__spreadValues({}, baseParams), params), {
        isLoading: false,
        autoClose: true
      }));
    }
    return result;
  };
  const p = isFn(promise) ? promise() : promise;
  p.then((result) => resolver("success", success, result)).catch((err) => resolver("error", error, err));
  return p;
}
toast.POSITION = POSITION;
toast.THEME = THEME;
toast.TYPE = TYPE;
toast.TRANSITIONS = TRANSITIONS;
var toast_default = toast;
var Vue3Toastify = {
  install(_) {
    let options = arguments.length > 1 && arguments[1] !== void 0 ? arguments[1] : {};
    updateGlobalOptions(options);
  }
};
if (typeof window !== "undefined") {
  window.Vue3Toastify = Vue3Toastify;
}
function updateGlobalOptions() {
  let options = arguments.length > 0 && arguments[0] !== void 0 ? arguments[0] : {};
  const globalOptions2 = mergeOptions(defaultGlobalOptions, options);
  saveGlobalOptions(globalOptions2);
}
var src_default = Vue3Toastify;
export {
  AnimationStep,
  Bounce,
  Flip,
  Slide,
  ToastActions,
  toastify_container_default as ToastifyContainer,
  Zoom,
  addExitAnimateToNode,
  appendFromQueue,
  cacheRenderInstance,
  clearContainers,
  containerInstances,
  src_default as default,
  doAppend,
  getAllToast,
  getToast,
  globalOptions,
  queue,
  removeContainer,
  toast_default as toast,
  toastContainers,
  updateGlobalOptions,
  useCssTransition
};
//# sourceMappingURL=vue3-toastify.js.map

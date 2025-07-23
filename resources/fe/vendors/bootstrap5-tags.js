(function () {
    // #region config

    const DEFAULTS = {
        items: [],
        allowNew: false,
        showAllSuggestions: false,
        badgeStyle: "primary",
        allowClear: false,
        clearEnd: false,
        selected: [],
        regex: "",
        separator: [],
        max: 0,
        clearLabel: "Clear",
        searchLabel: "Type a value",
        showDropIcon: true,
        keepOpen: false,
        allowSame: false,
        baseClass: "",
        placeholder: "",
        addOnBlur: false,
        showDisabled: false,
        hideNativeValidation: false,
        suggestionsThreshold: -1,
        maximumItems: 0,
        autoselectFirst: true,
        updateOnSelect: false,
        highlightTyped: false,
        highlightClass: "",
        fullWidth: true,
        fixed: false,
        fuzzy: false,
        startsWith: false,
        singleBadge: false,
        activeClasses: ["bg-primary", "text-white"],
        labelField: "label",
        valueField: "value",
        searchFields: ["label"],
        queryParam: "query",
        server: "",
        serverMethod: "GET",
        serverParams: {},
        serverDataKey: "data",
        fetchOptions: {},
        liveServer: false,
        noCache: true,
        allowHtml: false,
        debounceTime: 300,
        notFoundMessage: "",
        inputFilter: (str) => str,
        sanitizer: (str) => sanitize(str),
        onRenderItem: (item, label, inst) => {
            if (inst.config("allowHtml")) {
                return label;
            }
            return inst.config("sanitizer")(label);
        },
        onSelectItem: (item, inst) => {},
        onClearItem: (value, inst) => {},
        onCreateItem: (option, inst) => {},
        onBlur: (event, inst) => {},
        onDataLoaded: (src, inst) => {},
        onFocus: (event, inst) => {},
        onCanAdd: (text, data, inst) => {},
        confirmClear: (item, inst) => Promise.resolve(),
        confirmAdd: (item, inst) => Promise.resolve(),
        onServerResponse: (response, inst) => {
            return response.json();
        },
        onServerError: (e, signal, inst) => {
            if (e.name === "AbortError" || signal.aborted) {
                return;
            }
            console.error(e);
        },
    };

    // #endregion

    // #region constants

    const CLASS_PREFIX = "tags-";
    const LOADING_CLASS = "is-loading";
    const ACTIVE_CLASS = "is-active";
    const INVALID_CLASS = "is-invalid";
    const MAX_REACHED_CLASS = "is-max-reached";
    const SHOW_CLASS = "show";
    const VALUE_ATTRIBUTE = "data-value";
    const NEXT = "next";
    const PREV = "prev";
    const FOCUS_CLASS = "form-control-focus";
    const PLACEHOLDER_CLASS = "form-placeholder-shown";
    const DISABLED_CLASS = "form-control-disabled";
    const INSTANCE_MAP = new WeakMap();
    let counter = 0;
    let tooltip = window.bootstrap && window.bootstrap.Tooltip;

    // #endregion

    // #region functions

    function debounce(func, timeout = 300) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => {
                func.apply(this, args);
            }, timeout);
        };
    }

    function calcTextWidth(text, size = null) {
        const span = ce("span");
        document.body.appendChild(span);
        span.style.fontSize = size || "inherit";
        span.style.height = "auto";
        span.style.width = "auto";
        span.style.position = "absolute";
        span.style.whiteSpace = "no-wrap";
        span.innerHTML = sanitize(text);
        const width = Math.ceil(span.clientWidth);
        document.body.removeChild(span);
        return width;
    }

    function sanitize(text) {
        return text.replace(/[\x26\x0A\<>'"]/g, function (r) {
            return "&#" + r.charCodeAt(0) + ";";
        });
    }

    function removeDiacritics(str) {
        return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    }

    function normalize(str) {
        if (!str) {
            return "";
        }
        return removeDiacritics(str.toString()).toLowerCase();
    }

    function fuzzyMatch(str, lookup) {
        if (str.indexOf(lookup) >= 0) {
            return true;
        }
        let pos = 0;
        for (let i = 0; i < lookup.length; i++) {
            const c = lookup[i];
            if (c == " ") continue;
            pos = str.indexOf(c, pos) + 1;
            if (pos <= 0) {
                return false;
            }
        }
        return true;
    }

    function hideItem(item) {
        item.style.display = "none";
        attrs(item, {
            "aria-hidden": "true",
        });
    }

    function showItem(item) {
        item.style.display = "list-item";
        attrs(item, {
            "aria-hidden": "false",
        });
    }

    function attrs(el, attrs) {
        for (const [k, v] of Object.entries(attrs)) {
            el.setAttribute(k, v);
        }
    }

    function rmAttr(el, attr) {
        if (el.hasAttribute(attr)) {
            el.removeAttribute(attr);
        }
    }

    function parseBool(value) {
        return (
            ["true", "false", "1", "0", true, false].includes(value) &&
            !!JSON.parse(value)
        );
    }

    function ce(tagName) {
        return document.createElement(tagName);
    }

    function splitMulti(str, tokens) {
        let tempChar = tokens[0];
        for (let i = 1; i < tokens.length; i++) {
            str = str.split(tokens[i]).join(tempChar);
        }
        return str.split(tempChar);
    }

    function nested(str, obj = "window") {
        return str.split(".").reduce((r, p) => r[p], obj);
    }

    // #endregion

    class Tags {
        constructor(el, config = {}) {
            if (!(el instanceof HTMLElement)) {
                console.error("Invalid element", el);
                return;
            }
            INSTANCE_MAP.set(el, this);
            counter++;
            this._selectElement = el;

            this._configure(config);

            this._isMouse = false;
            this._keyboardNavigation = false;
            this._searchFunc = debounce(() => {
                this._loadFromServer(true);
            }, this._config.debounceTime);
            this._fireEvents = true;

            this._configureParent();

            this._holderElement = ce("div");
            this._containerElement = ce("div");
            this._dropElement = ce("ul");
            this._searchInput = ce("input");
            this._holderElement.appendChild(this._containerElement);

            this._selectElement.parentElement.insertBefore(
                this._holderElement,
                this._selectElement
            );

            this._configureHolderElement();
            this._configureContainerElement();
            this._configureSelectElement();
            this._configureSearchInput();
            this._configureDropElement();
            this.resetState();

            this.handleEvent = (ev) => {
                this._handleEvent(ev);
            };

            if (this._config.fixed) {
                document.addEventListener("scroll", this, true);
                window.addEventListener("resize", this);
            }

            ["focus", "blur", "input", "keydown", "paste"].forEach((type) => {
                this._searchInput.addEventListener(type, this);
            });
            ["mousemove", "mouseleave"].forEach((type) => {
                this._dropElement.addEventListener(type, this);
            });

            this.loadData(true);
        }

        static init(selector = "select[multiple]", opts = {}, reset = false) {
            let list = document.querySelectorAll(selector);
            for (let i = 0; i < list.length; i++) {
                const inst = Tags.getInstance(list[i]);
                if (inst && !reset) {
                    continue;
                }
                if (inst) {
                    inst.dispose();
                }
                new Tags(list[i], opts);
            }
        }

        static getInstance(el) {
            if (INSTANCE_MAP.has(el)) {
                return INSTANCE_MAP.get(el);
            }
        }

        dispose() {
            ["focus", "blur", "input", "keydown", "paste"].forEach((type) => {
                this._searchInput.removeEventListener(type, this);
            });
            ["mousemove", "mouseleave"].forEach((type) => {
                this._dropElement.removeEventListener(type, this);
            });

            if (this._config.fixed) {
                document.removeEventListener("scroll", this, true);
                window.removeEventListener("resize", this);
            }

            this._selectElement.style.display = "block";
            this._holderElement.parentElement.removeChild(this._holderElement);
            if (this.parentForm) {
                this.parentForm.removeEventListener("reset", this);
            }

            INSTANCE_MAP.delete(this._selectElement);
        }

        handleEvent(event) {
            this._handleEvent(event);
        }

        _handleEvent(event) {
            const debounced = ["scroll", "resize"];
            if (debounced.includes(event.type)) {
                if (this._timer) window.cancelAnimationFrame(this._timer);
                this._timer = window.requestAnimationFrame(() => {
                    this[`on${event.type}`](event);
                });
            } else {
                this[`on${event.type}`](event);
            }
        }

        _configure(config = {}) {
            this._config = Object.assign({}, DEFAULTS, {
                showDropIcon: this._findOption() ? true : false,
            });

            const json = this._selectElement.dataset.config
                ? JSON.parse(this._selectElement.dataset.config)
                : {};
            const o = { ...config, ...json, ...this._selectElement.dataset };

            for (const [key, defaultValue] of Object.entries(DEFAULTS)) {
                if (key == "config" || o[key] === void 0) {
                    continue;
                }
                const value = o[key];
                switch (typeof defaultValue) {
                    case "number":
                        this._config[key] = parseInt(value);
                        break;
                    case "boolean":
                        this._config[key] = parseBool(value);
                        break;
                    case "string":
                        this._config[key] = value.toString();
                        break;
                    case "object":
                        this._config[key] = value;
                        if (typeof value === "string") {
                            if (["{", "["].includes(value[0])) {
                                this._config[key] = JSON.parse(value);
                            } else {
                                this._config[key] = value.split(value.includes("|") ? "|" : ",");
                            }
                        }
                        break;
                    case "function":
                        this._config[key] =
                            typeof value === "string"
                                ? value.split(".").reduce((r, p) => r[p], window)
                                : value;
                        if (!this._config[key]) {
                            console.error("Invalid function", value);
                        }
                        break;
                    default:
                        this._config[key] = value;
                        break;
                }
            }

            if (!this._config.placeholder) {
                this._config.placeholder = this._getPlaceholder();
            }
            if (this._config.suggestionsThreshold == -1) {
                this._config.suggestionsThreshold = this._config.liveServer ? 1 : 0;
            }
        }

        config(k = null) {
            return k ? this._config[k] : this._config;
        }

        setConfig(k, v) {
            this._config[k] = v;
        }

        _configureParent() {
            this.overflowParent = null;
            this.parentForm = this._selectElement.parentElement;
            while (this.parentForm) {
                if (this.parentForm.style.overflow === "hidden") {
                    this.overflowParent = this.parentForm;
                }
                this.parentForm = this.parentForm.parentElement;
                if (this.parentForm && this.parentForm.nodeName == "FORM") {
                    break;
                }
            }
            if (this.parentForm) {
                this.parentForm.addEventListener("reset", this);
            }
        }

        _getPlaceholder() {
            if (this._selectElement.hasAttribute("placeholder")) {
                return this._selectElement.getAttribute("placeholder");
            }
            if (this._selectElement.dataset.placeholder) {
                return this._selectElement.dataset.placeholder;
            }
            let firstOption = this._selectElement.querySelector("option");
            if (!firstOption || !this._config.autoselectFirst) {
                return "";
            }
            rmAttr(firstOption, "selected");
            firstOption.selected = false;
            return !firstOption.value ? firstOption.textContent : "";
        }

        _configureSelectElement() {
            const selectEl = this._selectElement;

            if (this._config.hideNativeValidation) {
                selectEl.style.position = "absolute";
                selectEl.style.left = "-9999px";
            } else {
                selectEl.style.cssText = `height:1px;width:1px;opacity:0;padding:0;margin:0;border:0;float:left;flex-basis:100%;min-height:unset;`;
            }

            selectEl.tabIndex = -1;

            selectEl.addEventListener("focus", (event) => {
                this.onclick(event);
            });

            selectEl.addEventListener("invalid", (event) => {
                this._holderElement.classList.add(INVALID_CLASS);
            });
        }

        _configureDropElement() {
            const dropEl = this._dropElement;
            dropEl.classList.add(...["dropdown-menu", CLASS_PREFIX + "menu"]);
            dropEl.id = CLASS_PREFIX + "menu-" + counter;
            dropEl.setAttribute("role", "menu");

            const dropStyles = dropEl.style;
            dropStyles.padding = "0";
            dropStyles.maxHeight = "280px";
            if (!this._config.fullWidth) {
                dropStyles.maxWidth = "360px";
            }
            if (this._config.fixed) {
                dropStyles.position = "fixed";
            }
            dropStyles.overflowY = "auto";
            dropStyles.overscrollBehavior = "contain";
            dropStyles.textAlign = "unset";

            dropEl.addEventListener("mouseenter", (event) => {
                this._keyboardNavigation = false;
            });
            this._holderElement.appendChild(dropEl);

            this._searchInput.setAttribute("aria-controls", dropEl.id);
        }

        _configureHolderElement() {
            const holder = this._holderElement;
            holder.classList.add(...["form-control", "dropdown"]);
            ["form-select-lg", "form-select-sm", "is-invalid", "is-valid"].forEach(
                (className) => {
                    if (this._selectElement.classList.contains(className)) {
                        holder.classList.add(className);
                    }
                }
            );

            if (this._config.suggestionsThreshold == 0 && this._config.showDropIcon) {
                holder.classList.add("form-select");
            }

            if (this.overflowParent) {
                holder.style.position = "inherit";
            }
            holder.style.height = "auto";

            holder.addEventListener("click", this);
        }

        _configureContainerElement() {
            this._containerElement.addEventListener("click", (event) => {
                if (this.isDisabled()) {
                    return;
                }
                if (this._searchInput.style.visibility != "hidden") {
                    this._searchInput.focus();
                }
            });

            const containerStyles = this._containerElement.style;
            containerStyles.display = "flex";
            containerStyles.alignItems = "center";
            containerStyles.flexWrap = "wrap";
        }

        _configureSearchInput() {
            const searchInput = this._searchInput;

            searchInput.type = "text";
            searchInput.autocomplete = "off";
            searchInput.spellcheck = false;
            attrs(searchInput, {
                "aria-autocomplete": "list",
                "aria-haspopup": "menu",
                "aria-expanded": "false",
                "aria-label": this._config.searchLabel,
                role: "combobox",
            });
            searchInput.style.cssText = `background-color:transparent;color:currentColor;border:0;padding:0;outline:0;max-width:100%`;
            this.resetSearchInput(true);

            this._containerElement.appendChild(searchInput);
            this._rtl = window.getComputedStyle(searchInput).direction === "rtl";
        }

        onfocus(event) {
            if (this._holderElement.classList.contains(FOCUS_CLASS)) {
                return;
            }
            this._holderElement.classList.add(FOCUS_CLASS);
            this.showOrSearch();
            this._config.onFocus(event, this);
        }

        onblur(event) {
            const related = event.relatedTarget;
            if (
                this._isMouse &&
                related &&
                (related.classList.contains("modal") ||
                    related.classList.contains(CLASS_PREFIX + "menu"))
            ) {
                this._searchInput.focus();
                return;
            }
            this.afteronblur(event);
        }

        afteronblur(event) {
            if (this._abortController) {
                this._abortController.abort();
            }
            let clearValidation = true;
            if (this._config.addOnBlur && this._searchInput.value) {
                clearValidation = this._enterValue();
            }
            this._holderElement.classList.remove(FOCUS_CLASS);
            this.hideSuggestions(clearValidation);
            if (this._fireEvents) {
                const sel = this.getSelection();
                const data = {
                    selection: sel ? sel.dataset.value : null,
                    input: this._searchInput.value,
                };
                this._config.onBlur(event, this);
                this._selectElement.dispatchEvent(
                    new CustomEvent("tags.blur", { bubbles: true, detail: data })
                );
            }
        }

        onpaste(ev) {
            const clipboardData = ev.clipboardData || window.clipboardData;
            const data = clipboardData.getData("text/plain").replace(/\r\n|\n/g, " ");
            if (data.length > 2 && this._config.separator.length) {
                const splitData = splitMulti(data, this._config.separator).filter(
                    (n) => n
                );
                if (splitData.length > 1) {
                    ev.preventDefault();
                    splitData.forEach((value) => {
                        this._addPastedValue(value);
                    });
                }
            }
        }

        _addPastedValue(value) {
            let label = value;
            let addData = {};
            if (!this._config.allowNew) {
                const sel = this.getSelection();
                if (!sel) {
                    return;
                }
                value = sel.getAttribute(VALUE_ATTRIBUTE);
                label = sel.dataset.label;
            } else {
                addData.new = 1;
            }
            this._config
                .confirmAdd(value, this)
                .then(() => {
                    this._add(label, value, addData);
                })
                .catch(() => {});
            return;
        }

        oninput(ev) {
            const data = this._config.inputFilter(this._searchInput.value);
            if (data != this._searchInput.value) {
                this._searchInput.value = data;
            }

            if (data) {
                const lastChar = data.slice(-1);
                if (
                    this._config.separator.length &&
                    this._config.separator.includes(lastChar)
                ) {
                    this._searchInput.value = this._searchInput.value.slice(0, -1);
                    let value = this._searchInput.value;
                    this._addPastedValue(value);
                    return;
                }
            }

            setTimeout(() => {
                this._adjustWidth();
            });

            this.showOrSearch();
        }

        onkeydown(event) {
            let key = event.keyCode || event.key;
            const target = event.target;

            if (event.keyCode == 229) {
                key = target.value.charAt(target.selectionStart - 1).charCodeAt(0);
            }

            switch (key) {
                case 13:
                case "Enter":
                    event.preventDefault();
                    this._enterValue();
                    break;
                case 38:
                case "ArrowUp":
                    event.preventDefault();
                    this._keyboardNavigation = true;
                    this._moveSelection(PREV);
                    break;
                case 40:
                case "ArrowDown":
                    event.preventDefault();
                    this._keyboardNavigation = true;
                    if (this.isDropdownVisible()) {
                        this._moveSelection(NEXT);
                    } else {
                        this.showOrSearch(false);
                    }
                    break;
                case 8:
                case "Backspace":
                    const lastItem = this.getLastItem();
                    if (this._searchInput.value.length == 0 && lastItem) {
                        this._config
                            .confirmClear(lastItem, this)
                            .then(() => {
                                this.removeLastItem();
                                this._adjustWidth();
                                this.showOrSearch();
                            })
                            .catch(() => {});
                    }
                    break;
                case 27:
                case "Escape":
                    this._searchInput.focus();
                    this.hideSuggestions();
                    break;
            }
        }

        onmousemove(e) {
            this._isMouse = true;
            this._keyboardNavigation = false;
        }

        onmouseleave(e) {
            this._isMouse = false;
            this.removeSelection();
        }

        onscroll(e) {
            this._positionMenu();
        }

        onresize(e) {
            this._positionMenu();
        }

        onclick(e = null) {
            if (!this.isSingle() && this.isMaxReached()) {
                return;
            }
            this._searchInput.focus();
        }

        onreset(e) {
            this.reset();
        }

        loadData(init = false) {
            if (Object.keys(this._config.items).length > 0) {
                this.setData(this._config.items, true);
            } else {
                this.resetSuggestions(true);
            }

            if (this._config.server) {
                if (this._config.liveServer) {
                } else {
                    this._loadFromServer(!init);
                }
            }
        }

        _setSelectedAttributes() {
            const selectedOptions = this._selectElement.selectedOptions || [];
            for (let j = 0; j < selectedOptions.length; j++) {
                if (
                    selectedOptions[j].value &&
                    !selectedOptions[j].hasAttribute("selected")
                ) {
                    selectedOptions[j].setAttribute("selected", "selected");
                }
            }
        }

        resetState() {
            if (this.isDisabled()) {
                this._holderElement.setAttribute("readonly", "");
                this._searchInput.setAttribute("disabled", "");
                this._holderElement.classList.add(DISABLED_CLASS);
            } else {
                rmAttr(this._holderElement, "readonly");
                rmAttr(this._searchInput, "disabled");
                this._holderElement.classList.remove(DISABLED_CLASS);
            }
        }

        resetSuggestions(init = false) {
            this._setSelectedAttributes();

            const convertOption = (option) => {
                return {
                    value: option.getAttribute("value"),
                    label: option.textContent,
                    disabled: option.disabled,
                    selected: option.selected,
                    title: option.title,
                    data: Object.assign(
                        {
                            disabled: option.disabled,
                        },
                        option.dataset
                    ),
                };
            };

            let suggestions = Array.from(this._selectElement.children)
                .filter((option) => {
                    return (
                        option.hasAttribute("label") ||
                        !option.disabled ||
                        this._config.showDisabled
                    );
                })
                .map((option) => {
                    if (option.hasAttribute("label")) {
                        return {
                            group: option.getAttribute("label"),
                            items: Array.from(option.children).map((option) => {
                                return convertOption(option);
                            }),
                        };
                    }
                    return convertOption(option);
                });

            this.setData(suggestions, init);
        }

        _enterValue() {
            let selection = this.getSelection();
            if (selection) {
                selection.click();
                return true;
            } else {
                if (this._config.allowNew && this._searchInput.value) {
                    let text = this._searchInput.value;
                    this._config
                        .confirmAdd(text, this)
                        .then(() => {
                            this._add(text, text, { new: 1 });
                        })
                        .catch(() => {});
                    return true;
                }
            }
            return false;
        }

        _loadFromServer(show = false) {
            if (this._abortController) {
                this._abortController.abort();
            }
            this._abortController = new AbortController();

            let extraParams = this._selectElement.dataset.serverParams || {};
            if (typeof extraParams == "string") {
                extraParams = JSON.parse(extraParams);
            }
            const params = Object.assign({}, this._config.serverParams, extraParams);
            params[this._config.queryParam] = this._searchInput.value;
            if (this._config.noCache) {
                params.t = Date.now();
            }
            if (params.related) {
                const input = document.getElementById(params.related);
                if (input) {
                    params.related = input.value;
                    const inputName = input.getAttribute("name");
                    if (inputName) {
                        params[inputName] = input.value;
                    }
                }
            }

            const urlParams = new URLSearchParams(params);
            let url = this._config.server;
            let fetchOptions = Object.assign(this._config.fetchOptions, {
                method: this._config.serverMethod || "GET",
                signal: this._abortController.signal,
            });

            if (fetchOptions.method === "POST") {
                fetchOptions.body = urlParams;
            } else {
                url += "?" + urlParams.toString();
            }

            this._holderElement.classList.add(LOADING_CLASS);
            fetch(url, fetchOptions)
                .then((r) => this._config.onServerResponse(r, this))
                .then((suggestions) => {
                    const data =
                        nested(this._config.serverDataKey, suggestions) || suggestions;
                    this.setData(data, !show);
                    this._abortController = null;
                    if (show) {
                        this._showSuggestions();
                    }
                })
                .catch((e) => {
                    this._config.onServerError(e, this._abortController.signal, this);
                })
                .finally((e) => {
                    this._holderElement.classList.remove(LOADING_CLASS);
                });
        }

        _add(text, value = null, data = {}) {
            if (!data.value && value) {
                data.value = value;
            }
            if (!this.canAdd(text, data)) {
                return null;
            }
            const el = this.addItem(text, value, data);
            this._resetHtmlState();
            if (this._config.keepOpen) {
                this._showSuggestions();
            } else {
                this.resetSearchInput();
            }

            return el;
        }

        _isItemEnabled(li) {
            if (li.style.display === "none") {
                return false;
            }
            const fc = li.firstElementChild;
            return fc.tagName === "A" && !fc.classList.contains("disabled");
        }

        _moveSelection(dir = NEXT, sel = null) {
            const active = this.getSelection();

            if (!active) {
                if (dir === PREV) {
                    return sel;
                }
                if (!sel) {
                    sel = this._dropElement.firstChild;
                    while (sel && !this._isItemEnabled(sel)) {
                        sel = sel["nextSibling"];
                    }
                }
            } else {
                const sibling = dir === NEXT ? "nextSibling" : "previousSibling";

                sel = active.parentNode;
                do {
                    sel = sel[sibling];
                } while (sel && !this._isItemEnabled(sel));

                if (sel) {
                    active.classList.remove(...this._activeClasses());
                } else if (active) {
                    sel = active.parentElement;
                }
            }

            if (sel) {
                const selHeight = sel.offsetHeight;
                const selTop = sel.offsetTop;
                const parent = sel.parentNode;
                const parentHeight = parent.offsetHeight;
                const parentScrollHeight = parent.scrollHeight;
                const parentTop = parent.offsetTop;

                if (selHeight === 0) {
                    setTimeout(() => {
                        parent.scrollTop = 0;
                    });
                }

                if (dir === PREV) {
                    const scrollTop = selTop - parentTop > 10 ? selTop - parentTop : 0;
                    parent.scrollTop = scrollTop;
                } else {
                    const scrollNeeded =
                        selTop + selHeight - (parentHeight + parent.scrollTop);
                    if (scrollNeeded > 0 && selHeight > 0) {
                        parent.scrollTop = selTop + selHeight - parentHeight + 1;
                        if (parent.scrollTop + parentHeight >= parentScrollHeight - 10) {
                            parent.scrollTop = selTop - parentTop;
                        }
                    }
                }

                const a = sel.querySelector("a");
                a.classList.add(...this._activeClasses());
                this._searchInput.setAttribute("aria-activedescendant", a.id);
                if (this._config.updateOnSelect) {
                    this._searchInput.value = a.dataset.label;
                    this._adjustWidth();
                }
            } else {
                this._searchInput.setAttribute("aria-activedescendant", "");
            }
            return sel;
        }

        _adjustWidth() {
            this._holderElement.classList.remove(PLACEHOLDER_CLASS);
            if (this._searchInput.value) {
                this._searchInput.size = this._searchInput.value.length;
            } else {
                if (this.getSelectedValues().length) {
                    this._searchInput.placeholder = "";
                    this._searchInput.size = 1;
                } else {
                    this._searchInput.size =
                        this._config.placeholder.length > 0
                            ? this._config.placeholder.length
                            : 1;
                    this._searchInput.placeholder = this._config.placeholder;
                    this._holderElement.classList.add(PLACEHOLDER_CLASS);
                }
            }

            const v = this._searchInput.value || this._searchInput.placeholder;
            const computedFontSize = window.getComputedStyle(
                this._holderElement
            ).fontSize;
            const w = calcTextWidth(v, computedFontSize) + 16;
            this._searchInput.style.width = w + "px";
        }

        _buildSuggestions(suggestions) {
            while (this._dropElement.lastChild) {
                this._dropElement.removeChild(this._dropElement.lastChild);
            }
            let idx = 0;
            let groupId = 1;
            for (let i = 0; i < suggestions.length; i++) {
                const suggestion = suggestions[i];

                if (!suggestion) {
                    continue;
                }

                if (suggestion["group"] && suggestion["items"]) {
                    const newChild = ce("li");
                    newChild.setAttribute("role", "presentation");
                    newChild.dataset.id = "" + groupId;
                    const newChildSpan = ce("span");
                    newChild.append(newChildSpan);
                    newChildSpan.classList.add(...["dropdown-header", "text-truncate"]);
                    newChildSpan.innerHTML = this._config.sanitizer(suggestion["group"]);
                    this._dropElement.appendChild(newChild);

                    if (suggestion["items"]) {
                        for (let j = 0; j < suggestion["items"].length; j++) {
                            const groupSuggestion = suggestion["items"][j];
                            groupSuggestion.group_id = groupId;
                            this._buildSuggestionsItem(suggestion["items"][j], idx);
                            idx++;
                        }
                    }

                    groupId++;
                }

                this._buildSuggestionsItem(suggestion, idx);
                idx++;
            }

            if (this._config.notFoundMessage) {
                const notFound = ce("li");
                notFound.setAttribute("role", "presentation");
                notFound.classList.add(CLASS_PREFIX + "not-found");
                notFound.innerHTML = `<span class="dropdown-item"></span>`;
                this._dropElement.appendChild(notFound);
            }
        }

        _buildSuggestionsItem(suggestion, i) {
            if (!suggestion[this._config.valueField]) {
                return;
            }

            const value = suggestion[this._config.valueField];
            const label = suggestion[this._config.labelField];

            let textContent = this._config.onRenderItem(suggestion, label, this);

            const newChild = ce("li");
            newChild.setAttribute("role", "menuitem");
            if (suggestion.group_id) {
                newChild.setAttribute("data-group-id", "" + suggestion.group_id);
            }
            if (suggestion.title) {
                newChild.setAttribute("title", suggestion.title);
                newChild.setAttribute("data-bs-placement", "left");
            }
            const newChildLink = ce("a");
            newChild.append(newChildLink);
            newChildLink.id = this._dropElement.id + "-" + i;
            newChildLink.classList.add(...["dropdown-item", "text-truncate"]);
            if (suggestion.disabled) {
                newChildLink.classList.add(...["disabled"]);
            }
            newChildLink.setAttribute(VALUE_ATTRIBUTE, value);
            newChildLink.dataset.label = label;

            const searchData = {};
            this._config.searchFields.forEach((sf) => {
                searchData[sf] = suggestion[sf];
            });
            newChildLink.dataset.searchData = JSON.stringify(searchData);
            newChildLink.setAttribute("href", "#");
            newChildLink.innerHTML = textContent;
            this._dropElement.appendChild(newChild);

            const v5 = this._getBootstrapVersion() === 5;
            if (suggestion.title && tooltip && v5) {
                tooltip.getOrCreateInstance(newChild);
            }

            newChildLink.addEventListener("mouseenter", (event) => {
                if (this._keyboardNavigation) {
                    return;
                }
                this.removeSelection();
                newChild.querySelector("a").classList.add(...this._activeClasses());
            });
            newChildLink.addEventListener("mousedown", (event) => {
                event.preventDefault();
            });
            newChildLink.addEventListener("click", (event) => {
                event.preventDefault();
                event.stopPropagation();
                this._config
                    .confirmAdd(value, this)
                    .then(() => {
                        this._add(label, value, suggestion.data);
                        this._config.onSelectItem(suggestion, this);
                    })
                    .catch(() => {});
            });
        }

        initialOptions() {
            return this._selectElement.querySelectorAll("option[data-init]");
        }

        _removeSelectedAttrs() {
            this._selectElement.querySelectorAll("option").forEach((opt) => {
                rmAttr(opt, "selected");
            });
        }

        reset() {
            this.removeAll();

            this._fireEvents = false;
            const opts = this.initialOptions();
            this._removeSelectedAttrs();
            for (let j = 0; j < opts.length; j++) {
                const iv = opts[j];
                const data = Object.assign(
                    {},
                    {
                        disabled: iv.hasAttribute("disabled"),
                    },
                    iv.dataset
                );
                this.addItem(iv.textContent, iv.value, data);
            }
            this._resetHtmlState();
            this._fireEvents = true;
        }

        resetSearchInput(init = false) {
            this._searchInput.value = "";
            this._adjustWidth();

            this._checkMax();

            if (this.isSingle() && !init) {
                document.activeElement.blur();
                this.hideSuggestions();

                return;
            }

            if (!init) {
                if (!this._shouldShow()) {
                    this.hideSuggestions();
                }

                if (this._searchInput === document.activeElement) {
                    this._searchInput.dispatchEvent(new Event("input"));
                }
            }
        }

        _checkMax() {
            if (this.isMaxReached()) {
                this._holderElement.classList.add(MAX_REACHED_CLASS);
                this._searchInput.style.visibility = "hidden";
            } else {
                if (this._searchInput.style.visibility == "hidden") {
                    this._searchInput.style.visibility = "visible";
                }
            }
        }

        getSelectedValues() {
            const selected = this._selectElement.querySelectorAll("option[selected]");
            return Array.from(selected).map((el) => el.value);
        }

        getAvailableValues() {
            const selected = this._selectElement.querySelectorAll("option");
            return Array.from(selected).map((el) => el.value);
        }

        showOrSearch(check = true) {
            if (check && !this._shouldShow()) {
                this.hideSuggestions(false);
                return;
            }
            if (this._config.liveServer) {
                this._searchFunc();
            } else {
                this._showSuggestions();
            }
        }

        hideSuggestions(clearValidation = true) {
            this._dropElement.classList.remove(SHOW_CLASS);
            attrs(this._searchInput, {
                "aria-expanded": "false",
            });
            this.removeSelection();
            if (clearValidation) {
                this._holderElement.classList.remove(INVALID_CLASS);
            }
        }

        toggleSuggestions(check = true, clearValidation = true) {
            if (this._dropElement.classList.contains(SHOW_CLASS)) {
                this.hideSuggestions(clearValidation);
            } else {
                this.showOrSearch(check);
            }
        }

        _shouldShow() {
            if (this.isDisabled() || this.isMaxReached()) {
                return false;
            }
            return this._searchInput.value.length >= this._config.suggestionsThreshold;
        }

        _showSuggestions() {
            if (this._searchInput.style.visibility == "hidden") {
                return;
            }

            const lookup = normalize(this._searchInput.value);

            const valueCounter = {};

            const list = this._dropElement.querySelectorAll("li");
            let count = 0;
            let firstItem = null;
            let hasPossibleValues = false;
            let visibleGroups = {};
            for (let i = 0; i < list.length; i++) {
                let item = list[i];
                let link = item.firstElementChild;

                if (link instanceof HTMLSpanElement) {
                    if (item.dataset.id) {
                        visibleGroups[item.dataset.id] = false;
                    }
                    hideItem(item);
                    continue;
                }

                link.classList.remove(...this._activeClasses());

                if (!this._config.allowSame) {
                    const v = link.getAttribute(VALUE_ATTRIBUTE);
                    valueCounter[v] = valueCounter[v] || 0;
                    const opt = this._findOption(
                        link.getAttribute(VALUE_ATTRIBUTE),
                        "[selected]",
                        valueCounter[v]++
                    );
                    if (opt) {
                        hideItem(item);
                        continue;
                    }
                }

                const showAllSuggestions =
                    this._config.showAllSuggestions || lookup.length === 0;
                let isMatched =
                    lookup.length == 0 && this._config.suggestionsThreshold === 0;
                if (!showAllSuggestions && lookup.length > 0) {
                    const searchData = JSON.parse(link.dataset.searchData);
                    this._config.searchFields.forEach((sf) => {
                        const text = normalize(searchData[sf]);
                        let found = false;
                        if (this._config.fuzzy) {
                            found = fuzzyMatch(text, lookup);
                        } else {
                            const idx = text.indexOf(lookup);
                            found = this._config.startsWith ? idx === 0 : idx >= 0;
                        }
                        if (found) {
                            isMatched = true;
                        }
                    });
                }

                const selectFirst = isMatched || lookup.length === 0;
                if (showAllSuggestions || isMatched) {
                    count++;
                    showItem(item);
                    if (item.dataset.groupId) {
                        visibleGroups[item.dataset.groupId] = true;
                    }
                    if (!firstItem && this._isItemEnabled(item) && selectFirst) {
                        firstItem = item;
                    }
                    if (
                        this._config.maximumItems > 0 &&
                        count > this._config.maximumItems
                    ) {
                        hideItem(item);
                    }
                } else {
                    hideItem(item);
                }

                if (this._config.highlightTyped) {
                    const textContent = link.textContent;
                    const idx = normalize(textContent).indexOf(lookup);
                    const highlighted =
                        textContent.substring(0, idx) +
                        `<mark class="${this._config.highlightClass}">${textContent.substring(idx, idx + lookup.length)}</mark>` +
                        textContent.substring(idx + lookup.length, textContent.length);
                    link.innerHTML = highlighted;
                }

                if (this._isItemEnabled(item)) {
                    hasPossibleValues = true;
                }
            }

            if (
                !this._config.allowNew &&
                !(lookup.length === 0 && !hasPossibleValues)
            ) {
                this._holderElement.classList.add(INVALID_CLASS);
            }

            if (this._config.allowNew && this._config.regex && this.isInvalid()) {
                this._holderElement.classList.remove(INVALID_CLASS);
            }

            Array.from(list)
                .filter((li) => {
                    return li.dataset.id;
                })
                .forEach((li) => {
                    if (visibleGroups[li.dataset.id] === true) {
                        showItem(li);
                    }
                });

            if (hasPossibleValues) {
                this._holderElement.classList.remove(INVALID_CLASS);

                if (firstItem && this._config.autoselectFirst) {
                    this.removeSelection();
                    this._moveSelection(NEXT, firstItem);
                }
            }

            if (count === 0) {
                if (this._config.notFoundMessage) {
                    const notFound = this._dropElement.querySelector(
                        "." + CLASS_PREFIX + "not-found"
                    );
                    notFound.style.display = "block";
                    const notFoundMessage = this._config.notFoundMessage.replace(
                        "{{tag}}",
                        this._searchInput.value
                    );
                    notFound.innerHTML = `<span class="dropdown-item">${notFoundMessage}</span>`;
                    this._showDropdown();
                } else {
                    this.hideSuggestions(false);
                }
            } else {
                this._showDropdown();
            }
        }

        _showDropdown() {
            const isVisible = this._dropElement.classList.contains(SHOW_CLASS);
            if (!isVisible) {
                this._dropElement.classList.add(SHOW_CLASS);
                attrs(this._searchInput, {
                    "aria-expanded": "true",
                });
            }
            this._positionMenu(isVisible);
        }

        _positionMenu(wasVisible = false) {
            const isRTL = this._rtl;
            const fixed = this._config.fixed;
            const fullWidth = this._config.fullWidth;
            const bounds = this._searchInput.getBoundingClientRect();
            const holderBounds = this._holderElement.getBoundingClientRect();

            let left = 0;
            let top = 0;

            if (fixed) {
                if (fullWidth) {
                    left = holderBounds.x;
                    top = holderBounds.y + holderBounds.height + 2;
                } else {
                    left = bounds.x;
                    top = bounds.y + bounds.height;
                }
            } else {
                if (fullWidth) {
                    left = 0;
                    top = holderBounds.height + 2;
                } else {
                    left = this._searchInput.offsetLeft;
                    top = this._searchInput.offsetHeight + this._searchInput.offsetTop;
                }
            }

            if (isRTL && !fullWidth) {
                left -= this._dropElement.offsetWidth - bounds.width;
            }

            if (!fullWidth) {
                const w = Math.min(window.innerWidth, document.body.offsetWidth);
                const hdiff = isRTL
                    ? bounds.x + bounds.width - this._dropElement.offsetWidth - 1
                    : w - 1 - (bounds.x + this._dropElement.offsetWidth);
                if (hdiff < 0) {
                    left = isRTL ? left - hdiff : left + hdiff;
                }
            }

            if (fullWidth) {
                this._dropElement.style.width = this._holderElement.offsetWidth + "px";
            }

            if (!wasVisible) {
                this._dropElement.style.transform = "unset";
            }

            Object.assign(this._dropElement.style, {
                left: left + "px",
                top: top + "px",
            });

            const dropBounds = this._dropElement.getBoundingClientRect();
            const h = window.innerHeight;

            if (
                dropBounds.y + dropBounds.height > h ||
                this._dropElement.style.transform.includes("translateY")
            ) {
                const topOffset = fullWidth ? holderBounds.height + 4 : bounds.height;
                this._dropElement.style.transform =
                    "translateY(calc(-100.1% - " + topOffset + "px))";
            }
        }

        _getBootstrapVersion() {
            let ver = 5;
            let jq = window.jQuery;
            if (jq && jq.fn.tooltip && jq.fn.tooltip.Constructor) {
                ver = parseInt(jq.fn.tooltip.Constructor.VERSION.charAt(0));
            }
            return ver;
        }

        _isSelected(text) {
            const arr = Array.from(this._selectElement.querySelectorAll("option"));
            const selOpt = arr.find(
                (el) => el.textContent == text && el.getAttribute("selected")
            );
            return selOpt ? true : false;
        }

        _isSelectable(text, data) {
            const arr = Array.from(this._selectElement.querySelectorAll("option"));
            const opts = data.value
                ? arr.filter((el) => el.value == data.value)
                : arr.filter((el) => el.textContent == text);
            if (opts.length > 0) {
                const freeOpt = opts.find((opt) => !opt.getAttribute("selected"));
                if (!freeOpt) {
                    return false;
                }
            }
            return true;
        }

        hasItem(text) {
            for (let item of this._config.items) {
                const items = item["items"] || [item];
                for (let si of items) {
                    if (si[this._config.labelField] == text) return true;
                }
            }
            return false;
        }

        getItem(value) {
            for (let item of this._config.items) {
                const items = item["items"] || [item];
                for (let si of items) {
                    if (si[this._config.valueField] == value) return si;
                }
            }
            return null;
        }

        _validateRegex(value) {
            const regex = new RegExp(this._config.regex.trim());
            return regex.test(value);
        }

        getSelection() {
            return this._dropElement.querySelector("a." + ACTIVE_CLASS);
        }

        removeSelection() {
            const selection = this.getSelection();
            if (selection) {
                selection.classList.remove(...this._activeClasses());
            }
        }

        _activeClasses() {
            return [...this._config.activeClasses, ...[ACTIVE_CLASS]];
        }

        getActiveSelection() {
            return this.getSelection();
        }

        removeActiveSelection() {
            return this.removeSelection();
        }

        removeAll() {
            let items = this.getSelectedValues();
            items.forEach((item) => {
                this.removeItem(item, true);
            });
            this._adjustWidth();
        }

        removeLastItem(noEvents = false) {
            let lastItem = this.getLastItem();
            if (lastItem) {
                this.removeItem(lastItem, noEvents);
            }
        }

        getLastItem() {
            let items = this._containerElement.querySelectorAll(
                "span." + CLASS_PREFIX + "badge"
            );
            if (!items.length) {
                return;
            }
            let lastItem = items[items.length - 1];
            return lastItem.getAttribute(VALUE_ATTRIBUTE);
        }

        enable() {
            this._selectElement.setAttribute("disabled", "");
            this.resetState();
        }

        disable() {
            rmAttr(this._selectElement, "disabled");
            this.resetState();
        }

        isDisabled() {
            return (
                this._selectElement.hasAttribute("disabled") ||
                this._selectElement.disabled ||
                this._selectElement.hasAttribute("readonly")
            );
        }

        isDropdownVisible() {
            return this._dropElement.classList.contains(SHOW_CLASS);
        }

        isInvalid() {
            return this._holderElement.classList.contains(INVALID_CLASS);
        }

        isSingle() {
            return !this._selectElement.hasAttribute("multiple");
        }

        isMaxReached() {
            return (
                this._config.max && this.getSelectedValues().length >= this._config.max
            );
        }

        canAdd(text, data = {}) {
            if (!text) {
                return false;
            }
            if (data.new && !this._config.allowNew) {
                return false;
            }
            if (!data.new && !this.hasItem(text)) {
                return false;
            }
            if (this.isDisabled()) {
                return false;
            }
            if (!this.isSingle() && !this._config.allowSame) {
                if (data.new) {
                    if (this._isSelected(text)) {
                        return false;
                    }
                } else {
                    if (!this._isSelectable(text, data)) {
                        return false;
                    }
                }
            }
            if (this.isMaxReached()) {
                return false;
            }
            if (this._config.regex && data.new && !this._validateRegex(text)) {
                this._holderElement.classList.add(INVALID_CLASS);
                return false;
            }
            if (
                this._config.onCanAdd &&
                this._config.onCanAdd(text, data, this) === false
            ) {
                this._holderElement.classList.add(INVALID_CLASS);
                return false;
            }
            return true;
        }

        getData() {
            return this._config.items;
        }

        setData(src, init = false) {
            this._fireEvents = false;

            if (!Array.isArray(src)) {
                src = Object.entries(src).map(([value, label]) => ({ value, label }));
            }

            if (this._config.items != src) {
                this._config.items = src;
            }

            if (init) {
                this._removeSelectedAttrs();
                const flatSrc = src.reduce((a, b) => {
                    return a.concat(b.group ? b.items : [b]);
                }, []);
                flatSrc.forEach((suggestion) => {
                    const value = suggestion[this._config.valueField];
                    const label = suggestion[this._config.labelField];

                    if (!value) {
                        return;
                    }

                    if (suggestion.selected || this._config.selected.includes(value)) {
                        const added = this.addItem(label, value, suggestion.data);
                        if (added) {
                            added.setAttribute("data-init", "true");
                        }
                    }
                });
            }

            this._buildSuggestions(src);
            this._resetHtmlState();
            this._fireEvents = true;

            this._config.onDataLoaded(src, this);
            this._selectElement.dispatchEvent(
                new CustomEvent("tags.loaded", { bubbles: true, detail: src })
            );
        }

        _findOption(value = null, mode = "", counter = 0) {
            const val = value === null ? "" : '[value="' + CSS.escape(value) + '"]';
            const sel = "option" + val + mode;
            const opts = this._selectElement.querySelectorAll(sel);
            return opts[counter] || null;
        }

        setItem(value, data = {}) {
            let addedItem = null;
            let opt = this._findOption(value, ":not([selected])");
            if (opt) {
                addedItem = this.addItem(opt.textContent, opt.value, data);
            }
            let item = this.getItem(value);
            if (item) {
                const value = item[this._config.valueField];
                const label = item[this._config.labelField];
                addedItem = this.addItem(label, value, data);
            }
            this._adjustWidth();
            this._checkMax();
            return addedItem;
        }

        addItem(text, value = null, data = {}) {
            if (!value) {
                value = text;
            }

            if (this.isSingle() && this.getSelectedValues().length) {
                this.removeLastItem(true);
            }

            let opt = this._findOption(value, ":not([selected])");

            if (!opt) {
                opt = ce("option");
                opt.value = value;
                opt.innerText = text;
                for (const [key, value] of Object.entries(data)) {
                    opt.dataset[key] = value;
                }
                this._selectElement.appendChild(opt);
                this._config.onCreateItem(opt, this);
            }

            if (opt) {
                data = Object.assign(
                    {
                        title: opt.getAttribute("title"),
                    },
                    data,
                    opt.dataset
                );
            }
            opt.setAttribute("selected", "selected");
            opt.selected = true;

            this._createBadge(text, value, data);

            if (this._fireEvents) {
                this._selectElement.dispatchEvent(new Event("change", { bubbles: true }));
            }

            return opt;
        }

        _resetHtmlState() {
            const html = this._selectElement.innerHTML;
            this._selectElement.innerHTML = "";
            this._selectElement.innerHTML = html;

            this._adjustWidth();
        }

        _createBadge(text, value = null, data = {}) {
            const v5 = this._getBootstrapVersion() === 5;
            const disabled = data.disabled && parseBool(data.disabled);
            const allowClear = this._config.allowClear && !disabled;

            let html = this._config.allowHtml ? text : this._config.sanitizer(text);

            let span = ce("span");
            let classes = [CLASS_PREFIX + "badge"];

            const isSingle = this.isSingle() && !this._config.singleBadge;

            if (!isSingle) {
                classes.push("badge");
                let badgeStyle = this._config.badgeStyle;
                if (data.badgeStyle) {
                    badgeStyle = data.badgeStyle;
                }
                if (data.badgeClass) {
                    classes.push(...data.badgeClass.split(" "));
                }
                if (this._config.baseClass) {
                    classes.push(...this._config.baseClass.split(" "));
                } else if (v5) {
                    classes = [...classes, ...["bg-" + badgeStyle], "text-truncate"];
                } else {
                    classes = [...classes, ...["badge-" + badgeStyle]];
                }

                span.style.maxWidth = "100%";
            }

            if (disabled) {
                classes.push(...["disabled", "opacity-50"]);
            }

            const vertMargin = isSingle ? 0 : 2;

            span.style.margin = vertMargin + "px 6px " + vertMargin + "px 0px";
            span.style.marginBlock = vertMargin + "px";
            span.style.marginInline = "0px 6px";
            span.style.display = "flex";
            span.style.alignItems = "center";
            span.classList.add(...classes);
            span.setAttribute(VALUE_ATTRIBUTE, value);
            if (data.title) {
                span.setAttribute("title", data.title);
            }

            if (allowClear) {
                const closeClass =
                    classes.includes("text-dark") || isSingle
                        ? "btn-close"
                        : "btn-close btn-close-white";
                let btnMargin = "margin-inline: 0px 6px;";
                let pos = "left";
                if (this._config.clearEnd) {
                    pos = "right";
                }
                if (pos == "right") {
                    btnMargin = "margin-inline: 6px 0px;";
                }
                const btn = v5
                    ? '<button type="button" style="font-size:0.65em;' +
                      btnMargin +
                      '" class="' +
                      closeClass +
                      '" aria-label="' +
                      this._config.clearLabel +
                      '"></button>'
                    : '<button type="button" style="font-size:1em;' +
                      btnMargin +
                      'text-shadow:none;color:currentColor;transform:scale(1.2);float:none" class="close" aria-label="' +
                      this._config.clearLabel +
                      '"><span aria-hidden="true">&times;</span></button>';

                html = pos == "left" ? btn + html : html + btn;
            }

            span.innerHTML = html;
            this._containerElement.insertBefore(span, this._searchInput);

            if (data.title && tooltip && v5) {
                tooltip.getOrCreateInstance(span);
            }

            if (allowClear) {
                span.querySelector("button").addEventListener("click", (event) => {
                    event.preventDefault();
                    event.stopPropagation();
                    if (!this.isDisabled()) {
                        this._config
                            .confirmClear(value, this)
                            .then(() => {
                                this.removeItem(value);
                                document.activeElement.blur();
                                this._adjustWidth();
                            })
                            .catch(() => {});
                    }
                });
            }
        }

        getHolder() {
            return this._holderElement;
        }

        clear() {
            this.hideSuggestions();
            this.reset();
        }

        updateData(src) {
            this.setData(src, false);
            this.reset();
        }

        removeItem(value, noEvents = false) {
            const escapedValue = CSS.escape(value);
            let items = this._containerElement.querySelectorAll(
                "span[" + VALUE_ATTRIBUTE + '="' + escapedValue + '"]'
            );
            if (!items.length) {
                return;
            }
            const idx = items.length - 1;
            const item = items[idx];
            if (item) {
                if (item.dataset.bsOriginalTitle) {
                    tooltip.getOrCreateInstance(item).dispose();
                }
                item.remove();
            }

            let opt = this._findOption(value, "[selected]", idx);
            if (opt) {
                rmAttr(opt, "selected");
                opt.selected = false;

                if (this._fireEvents && !noEvents) {
                    this._selectElement.dispatchEvent(
                        new Event("change", { bubbles: true })
                    );
                }
            }

            if (
                this._searchInput.style.visibility == "hidden" &&
                !this.isMaxReached()
            ) {
                this._searchInput.style.visibility = "visible";
                this._holderElement.classList.remove(MAX_REACHED_CLASS);
            }

            if (!noEvents) {
                this._config.onClearItem(value, this);
            }
        }
    }

    window.Tags = Tags;
})();
getFeaturecategoryChooser = function (url) {
    feature_category_ids.updateElement = $("feature_category_ids");
    new Ajax.Request(
            url, {
                method: "post",
                onSuccess: function (b) {
                    var a = $('chosser-container');
                    a.update(b.responseText);
                    a.scrollTo()
                }
            })
};

getFeatureProductChooser = function (url) {
    var feature_product_ids = document.getElementById('feature_product_ids');
    var test = feature_product_ids.value;
    var demo = test.replace(/\s/g, '').split(",");

    if ($('featureproduct-chosser-container').innerHTML.length) {
        document.getElementById("featureproduct-chosser-container").innerHTML = "";
    } else {
        new Ajax.Request(
                url, {
                    method: "post",
                    parameters: {
                        'selected[]': demo},
                    onSuccess: function (b) {
                        var a = $('featureproduct-chosser-container');
                        a.update(b.responseText);
                        a.scrollTo()
                    }
                })
    }


};

getMaincategoryChooser = function (url) {
    main_content_category_ids.updateElement = $("main_content_category_ids");
    var demo = main_content_category_ids.value.split(",");
    new Ajax.Request(
            url, {
                method: "post",
                parameters: {
                    'selected[]': demo},
                onSuccess: function (b) {
                    //console.log(b);
                    var a = $('main-chosser-container');
                    a.update(b.responseText);
                    a.scrollTo()
                }
            })


};

getMainProductChooser = function (url) {
    var main_content_product_ids = document.getElementById('main_content_product_ids');
    var test = main_content_product_ids.value;
    var demo = test.replace(/\s/g, '').split(",");

    if ($('mainproduct-chosser-container').innerHTML.length) {
        document.getElementById("mainproduct-chosser-container").innerHTML = "";
    } else {
        new Ajax.Request(
                url, {
                    method: "post",
                    parameters: {
                        'selected[]': demo},
                    onSuccess: function (b) {
                        var a = $('mainproduct-chosser-container');
                        a.update(b.responseText);
                        a.scrollTo()
                    }
                })
    }
};


clearDiv = function (id) {
    $(id).update();
};


var VarienRulesForm = new Class.create();
VarienRulesForm.prototype = {
    initialize: function (a) {
        this.newChildUrl = a;
        this.shownElement = null;
        this.updateElement = $("skus");
        this.chooserSelectedItems = $H({})
    },
    initParam: function (b) {
        //console.log('initParam');
        b.rulesObject = this;
        var d = Element.down(b, ".label");
        if (d) {
            Event.observe(d, "click", this.showParamInputField.bind(this, b))
        }
        var f = Element.down(b, ".element");
        if (f) {
            var e = f.down(".rule-chooser-trigger");
            if (e) {
                Event.observe(e, "click", this.toggleChooser.bind(this, b))
            }
            var c = f.down(".rule-param-apply");
            if (c) {
                Event.observe(c, "click", this.hideParamInputField.bind(this, b))
            } else {
                f = f.down();
                if (!f.multiple) {
                    Event.observe(f, "change", this.hideParamInputField.bind(this, b))
                }
                Event.observe(f, "blur", this.hideParamInputField.bind(this, b))
            }
        }
        var a = Element.down(b, ".rule-param-remove");
        if (a) {
            Event.observe(a, "click", this.removeRuleEntry.bind(this, b))
        }
    },
    showChooserElement: function (c) {
        //console.log('showChooserElement');
        this.chooserSelectedItems = $H({});
        var a = this.updateElement.value.split(","),
                b = "";
        for (i = 0; i < a.length; i++) {
            b = a[i].strip();
            if (b != "") {
                this.chooserSelectedItems.set(b, 1)
            }
        }
        new Ajax.Updater(c, c.getAttribute("url"), {
            evalScripts: true,
            parameters: {
                form_key: FORM_KEY,
                "selected[]": this.chooserSelectedItems.keys()
            },
            onSuccess: this._processSuccess.bind(this) && this.showChooserLoaded.bind(this, c),
            onFailure: this._processFailure.bind(this)
        })
    },
    showChooserLoaded: function (a, b) {
        //console.log('showChooserLoaded');
        a.style.display = "block"
    },
    showChooser: function (a, c) {
        //console.log('showChooser');
        var b = a.up("li");
        if (!b) {
            return
        }
        b = b.down(".rule-chooser");
        if (!b) {
            return
        }
        this.showChooserElement(b)
    },
    hideChooser: function (a, c) {
        //console.log('hideChooser');
        var b = a.up("li");
        if (!b) {
            return
        }
        b = b.down(".rule-chooser");
        if (!b) {
            return
        }
        b.style.display = "none"
    },
    toggleChooser: function (a, c) {
        //console.log('toggleChooser');
        var b = a.up("li").down(".rule-chooser");
        if (!b) {
            return
        }
        if (b.style.display == "block") {
            b.style.display = "none";
            this.cleanChooser(a, c)
        } else {
            this.showChooserElement(b)
        }
    },
    cleanChooser: function (a, c) {
        //console.log('cleanChooser');
        var b = a.up("li").down(".rule-chooser");
        if (!b) {
            return
        }
        b.innerHTML = ""
    },
    showParamInputField: function (a, c) {
        //console.log('showParamInputField');
        if (this.shownElement) {
            this.hideParamInputField(this.shownElement, c)
        }
        Element.addClassName(a, "rule-param-edit");
        var d = Element.down(a, ".element");
        var b = Element.down(d, "input.input-text");
        if (b) {
            b.focus();
            if (b && b.id && b.id.match(/__value$/)) {
                this.updateElement = b
            }
        }
        var b = Element.down(d, "select");
        if (b) {
            b.focus()
        }
        this.shownElement = a
    },
    hideParamInputField: function (a, d) {
        //console.log('hideParamInputField');
        Element.removeClassName(a, "rule-param-edit");
        var b = Element.down(a, ".label"),
                c;
        if (!a.hasClassName("rule-param-new-child")) {
            c = Element.down(a, "select");
            if (c && c.options) {
                var f = [];
                for (i = 0; i < c.options.length; i++) {
                    if (c.options[i].selected) {
                        f.push(c.options[i].text)
                    }
                }
                var e = f.join(", ");
                b.innerHTML = e != "" ? e : "..."
            }
            c = Element.down(a, "input.input-text");
            if (c) {
                var e = c.value.replace(/(^\s+|\s+$)/g, "");
                c.value = e;
                if (e == "") {
                    e = "..."
                } else {
                    if (e.length > 30) {
                        e = e.substr(0, 30) + "..."
                    }
                }
                b.innerHTML = e
            }
        } else {
            c = Element.down(a, "select");
            if (c.value) {
                this.addRuleNewChild(c)
            }
            c.value = ""
        }
        if (c && c.id && c.id.match(/__value$/)) {
            this.hideChooser(a, d);
            this.updateElement = null
        }
        this.shownElement = null
    },
    addRuleNewChild: function (b) {
        //console.log('addRuleNewChild');
        var f = b.id.replace(/^.*__(.*)__.*$/, "$1");
        var h = $(b.id.replace(/__/g, ":").replace(/[^:]*$/, "children").replace(/:/g, "__"));
        var d = 0,
                c;
        var a = Selector.findChildElements(h, $A(["input.hidden"]));
        if (a.length) {
            a.each(function (k) {
                if (k.id.match(/__type$/)) {
                    c = 1 * k.id.replace(/^.*__.*?([0-9]+)__.*$/, "$1");
                    d = c > d ? c : d
                }
            })
        }
        var g = f + "--" + (d + 1);
        var j = b.value;
        var e = document.createElement("LI");
        e.className = "rule-param-wait";
        e.innerHTML = Translator.translate("Please wait, loading...");
        h.insertBefore(e, $(b).up("li"));
        new Ajax.Updater(e, this.newChildUrl, {
            evalScripts: true,
            parameters: {
                form_key: FORM_KEY,
                type: j.replace("/", "-"),
                id: g
            },
            onComplete: this.onAddNewChildComplete.bind(this, e),
            onSuccess: this._processSuccess.bind(this),
            onFailure: this._processFailure.bind(this)
        })
    },
    _processSuccess: function (b) {
        //console.log('_processSuccess');
        var a = b.responseText.evalJSON();
        if (a.ajaxExpired && a.ajaxRedirect) {
            alert(Translator.translate("Your session has been expired, you will be relogged in now."));
            location.href = a.ajaxRedirect
        }
        return true
    },
    _processFailure: function (a) {
        //console.log('_processFailure');
        location.href = BASE_URL
    },
    onAddNewChildComplete: function (c) {
        //console.log('onAddNewChildComplete');
        $(c).removeClassName("rule-param-wait");
        var a = c.getElementsByClassName("rule-param");
        for (var b = 0; b < a.length; b++) {
            this.initParam(a[b])
        }
    },
    removeRuleEntry: function (b, c) {
        //console.log('removeRuleEntry');
        var a = Element.up(b, "li");
        a.parentNode.removeChild(a)
    },
    chooserGridInit: function (a) {
        //console.log('chooserGridInit');
    },
    chooserGridRowInit: function (a, b) {
        var oldval = $(this.newChildUrl).value;
        var oldValArr = oldval.split(',');
        //console.log('chooserGridRowInit');
        if (!a.reloadParams) {
            a.reloadParams = {
                "selected[]": oldValArr.concat(this.chooserSelectedItems.keys()).unique()
            }
        }
    },
    chooserGridRowClick: function (b, d) {
        //console.log('chooserGridRowClick');
        var f = Event.findElement(d, "tr");
        var a = Event.element(d).tagName == "INPUT";
        if (f) {
            var e = Element.select(f, "input");
            if (e[0]) {
                var c = a ? e[0].checked : !e[0].checked;
                b.setCheckboxChecked(e[0], c)
            }
        }
    },
    chooserGridCheckboxCheck: function (b, a, c) {
        //console.log('chooserGridCheckboxCheck');
        var oldval = $(this.newChildUrl).value;
        var oldValArr = oldval.split(',');
        if (c) {
            if (!a.up("th")) {
                this.chooserSelectedItems.set(a.value, 1)
            }
        } else {
            for (var i = 0; i < oldValArr.length; i++) {
                if (oldValArr[i] == a.value) {
                    delete oldValArr[i];
                }
            }
            this.chooserSelectedItems.unset(a.value)
        }
        b.reloadParams = {
            "selected[]": oldValArr.concat(this.chooserSelectedItems.keys()).unique()
        };
        if (oldValArr.length > 1) {
            //console.log(oldValArr.length);
            var newVal = oldValArr.concat(this.chooserSelectedItems.keys());
        } else {
            var newVal = this.chooserSelectedItems.keys();
        }


        var newVal = newVal.unique();
        var newValStr = '';
        for (var j = 0; j < newVal.length; j++) {
            if (newVal[j]) {
                if (newValStr.length) {
                    newValStr += ',' + newVal[j];
                } else {
                    if (newVal[j]) {
                        newValStr += newVal[j];
                    }

                }

            }
        }
        $(this.newChildUrl).value = newValStr;
    }


};

Array.prototype.contains = function (v) {
    for (var i = 0; i < this.length; i++) {
        if (this[i] === v)
            return true;
    }
    return false;
};

Array.prototype.unique = function () {
    var arr = [];
    for (var i = 0; i < this.length; i++) {
        if (!arr.contains(this[i])) {
            arr.push(this[i]);
        }
    }
    return arr;
}

var feature_product_ids = new VarienRulesForm('feature_product_ids');
var main_content_product_ids = new VarienRulesForm('main_content_product_ids');


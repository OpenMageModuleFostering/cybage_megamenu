function toggleInputs(type) {
//    alert(type);
    console.log(type);
    switch (type) {
        case '0':
            hideInput('column_count');
            hideInput('target_url');
            hideForm('megamenu_feature_form');
            hideForm('megamenu_maincontent_form');
            showForm('megamenu_headercontent_form');
            removeClass('target_url');
            break;
        case '1':
            showInput('column_count');
            hideInput('category_ids');
            showForm('megamenu_feature_form');
            showForm('megamenu_maincontent_form');
            hideInput('feature_category_box_title');
            hideInput('product_ids');
            hideInput('category_box_title');
            hideInput('prodct_box_title');
            hideInput('main_content_product_ids');
            hideInput('target_url');
            showInput('main_content_category_ids');
            addClass('main_content_category_ids');
            showForm('megamenu_headercontent_form');
            hideInput('content_container');
            removeClass('category_box_title');
            removeClass('prodct_box_title');
            removeClass('prodct_box_title');
            removeClass('main_content_product_ids');
            removeClass('content_container');
            removeClass('prodct_box_title');
            removeClass('main_content_product_ids');
            removeClass('target_url');
            break;
        case '2':
            showInput('column_count');
            hideInput('prodct_box_title');
            hideInput('category_ids');
            showForm('megamenu_maincontent_form');
            showInput('main_content_product_ids');
            hideForm('megamenu_feature_form');
            hideInput('feature_category_box_title');
            hideInput('feature_product_box_title');
            hideInput('main_content_category_ids');
            removeClass('main_content_category_ids');
            hideInput('product_ids');
            hideInput('category_box_title');
            showForm('megamenu_headercontent_form');
            hideInput('target_url');
            hideInput('content_container');
            removeClass('target_url');
            removeClass('category_box_title');
            removeClass('prodct_box_title');
            removeClass('main_content_product_ids');
            removeClass('content_container');
            addClass('main_content_product_ids');
            break;
        case '3':
            showInput('column_count');
            showForm('megamenu_maincontent_form');
            hideInput('category_box_title');
            showInput('megamenu_headercontent_form');
            hideInput('prodct_box_title');
            hideInput('main_content_product_ids');
            showInput('main_content_category_ids');
            addClass('main_content_category_ids');
            showForm('megamenu_headercontent_form');
            hideInput('target_url');
            hideInput('content_container');
            removeClass('content_container');
            removeClass('prodct_box_title');
            removeClass('main_content_product_ids');
            removeClass('target_url');
            break;
        case '4':
            removeClass('column_count');
            removeClass('target_url');
            hideInput('column_count');
            hideInput('target_url');
            showForm('megamenu_headercontent_form');
            removeClass('main_content_category_ids');
            hideForm('megamenu_feature_form');
            hideForm('megamenu_maincontent_form');
            removeClass('content_container');
            removeClass('prodct_box_title');
            removeClass('main_content_product_ids');
            break;
        case '5':
            removeClass('column_count');
            hideInput('column_count');
            showInput('target_url');
            hideForm('megamenu_headercontent_form');
            removeClass('main_content_category_ids');
            hideForm('megamenu_feature_form');
            hideForm('megamenu_maincontent_form');
            removeClass('content_container');
            removeClass('prodct_box_title');
            removeClass('main_content_product_ids');
            addClass('target_url');

            break;
        case '6':
            removeClass('column_count');
            removeClass('target_url');
            removeClass('header');
            removeClass('footer');
            hideInput('column_count');
            hideForm('megamenu_feature_form');
            showForm('megamenu_maincontent_form');
            showForm('megamenu_headercontent_form');
            hideInput('target_url');
            hideInput('category_box_title');
            hideInput('prodct_box_title');
            hideInput('main_content_category_ids');
            removeClass('main_content_category_ids');
            hideInput('main_content_product_ids');
            showInput('content_container');
            removeClass('prodct_box_title');
            removeClass('main_content_product_ids');
            break;
        case '20':
            hideInput('feature_category_box_title');
//            hideInput('feature_product_box_title');
            hideInput('category_ids');
            hideInput('product_ids');
            removeClass('prodct_box_title');
            removeClass('main_content_product_ids');
            removeClass('target_url');
            removeClass('feature_product_box_title');
            removeClass('feature_product_ids');
            break;
        case '21':
            showInput('feature_category_box_title');
            hideInput('feature_product_box_title');
            showInput('category_ids');
            hideInput('product_ids');
            removeClass('prodct_box_title');
            removeClass('main_content_product_ids');
            removeClass('target_url');
            removeClass('main_content_category_ids');
            break;
        case '22':
            hideInput('feature_category_box_title');
            showInput('feature_product_box_title');
            hideInput('category_ids');
            showInput('product_ids');
            removeClass('prodct_box_title');
            removeClass('main_content_product_ids');
            removeClass('target_url');
            addClass('feature_product_box_title');
            addClass('feature_product_ids');
            break;

        default:
            hideForm('megamenu_headercontent_form');
            hideForm('megamenu_feature_form');
            hideForm('megamenu_maincontent_form');
            hideInput('column_count');
            hideInput('target_url');
            break;
    }
}

function removeClass(id)
{
    if (id)
    {
        var ele = document.getElementById(id)
        ele.classList.remove("required-entry");

        var list = getElementsByAttribute('for', document, id);
        if (list.hasChildNodes()) {
            for (var i = 0; i < list.childNodes.length; i++) {
                if (list.childNodes[i].className == "required") {
                    list.removeChild(list.childNodes[i]);
                }
            }
        }
    }
}

function addClass(id)
{
    if (id)
    {
        var ele = document.getElementById(id)
        ele.classList.add("required-entry");
        var label = ele.parentNode.previousSibling.childNodes;
        var node = document.createElement("SPAN");
        node.className = "required"
        var textnode = document.createTextNode('\ *');
        node.appendChild(textnode);
        getElementsByAttribute('for', document, id).appendChild(node);

    }
}

function getElementsByAttribute(attribute, context, value) {
    var nodeList = (context || document).getElementsByTagName('*');
    var nodeArray = [];
    var iterator = 0;
    var node = null;

    while (node = nodeList[iterator++]) {
        if (node.getAttribute(attribute) == value) {
            return node;
        }
    }
}

function showInput(id) {
    if ($(id)) {
        var td = $(id).up();
        var tr = td.up();
        tr.show();
    }
}
function showForm(id) {
    if ($(id)) {
        $(id).show();
        $(id).previous().show();
    }
}
function hideInput(id) {
    if ($(id)) {
        var td = $(id).up();
        var tr = td.up();
        tr.hide();
    }
}
function hideForm(id) {
    if ($(id)) {
        $(id).hide();
        $(id).previous().hide();
    }
}
function getTemplates(value, url) {
    new Ajax.Request(url, {
        parameters: $('type_id').serialize(true),
        onSuccess: function (transport) {
            toggleInputs(value);
            if (transport.responseText.isJSON()) {
                var field = transport.responseText.evalJSON();
                var i = 0;
                $('template_id').select('option').invoke('remove');

                var firstOption = document.createElement('option');
                firstOption.className = 'option template';
                firstOption.text = 'Select Template Type';
                firstOption.value = '';
                $('template_id').appendChild(firstOption);

                for (i = 0; i < field.length; i++) {
                    var newOption = document.createElement('option');
                    newOption.className = 'option template';
                    newOption.text = field[i].name;
                    newOption.value = field[i].entity_id;
                    $('template_id').appendChild(newOption);
                }
            }

        }.bind(this)
    });
}

function getLayoutImage(value, url) {
    new Ajax.Request(url, {
        parameters: $('template_id').serialize(true),
        onSuccess: function (transport) {
            var image = transport.responseText;
            var imgObj = document.getElementById('template_layout_image');
            imgObj.src = image;
        }.bind(this)
    });
}
document.observe("dom:loaded", function () {
    var menuType = document.getElementById('type_id');
    var selectedMenuType = menuType.options[menuType.selectedIndex].value;
    toggleInputs(selectedMenuType);
})


$$('.categories-checkboxes').each(
        function (e) {

            $('' + e.id).observe('click', function (e2) {
                if (e.checked) {
                    addCategories(e.value);
                } else {
                    removeCategories(e.value);
                }
            });
        }
);

function addCategories(id) { 
    if ($('main_content_category_ids').value != '') {
        var data = $('main_content_category_ids').value;
        data = data + ',' + id;
        $('main_content_category_ids').value = data
    } else {
        $('main_content_category_ids').value = id;
    }
}
function removeCategories(id) {
    var data = $('main_content_category_ids').value;
    var n = data.search(id);

    if (data.search("," + id) >= 0) {
        data = data.replace("," + id, "");
    }
    else if (data.search(id + ",") >= 0) {
        data = data.replace(id + ",", "");
    }
    else if (data.search(id) >= 0) {
        data = data.replace(id, "");
    }
    $('main_content_category_ids').value = data;
}
function getCategories(url) {

    new Ajax.Request(url, {
        onSuccess: function (transport) {
            var data = transport.responseText;
            var categoryDiv = document.getElementById('responsecategories');
            categoryDiv.innerHTML = data;
        }.bind(this)
    });
}
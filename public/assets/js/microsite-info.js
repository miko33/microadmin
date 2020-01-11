$('#dd').nestable({
    group: 1,
    maxDepth: 2
}).on('change', function() {
    $('#saveMenuOrder').show();
});
function clear_error() {
    $('input, select, button').removeClass('is-invalid')
    $('input, select').siblings('.invalid-feedback').remove();
}
// var switchStatus = false;
// $("#togBtn").on('change', function() {
//         if ($(this).is(':checked')) {
//             switchStatus = $(this).is(':checked');
//             alert(switchStatus);
//             $('.blog').show();
//
//         }
//         else {
//            switchStatus = $(this).is(':checked');
//            alert(switchStatus);
//              $('.blog').hide();
//         }
//     });
$(document).ready(function() {

  if ($('#blogstatus').val().trim() == 'true') {
    $("#togBtn").prop("checked", true);
    $('.blog').show();
  } else if ($('#blogstatus').val().trim() == 'false') {
        $("#togBtn").prop("checked", false);
        $('.blog').hide();
  }
});



$('#createblog').click(function () {
  $("#blogcreate").modal('show');
});

$('#storeBlog').click(function () {
  var settings = {
    "url": storeBlog_url,
    "method": "POST",
    "headers": {
        "Accept": "application/json",
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    'data': {
      'title': $('#blogTitle').val(),
      'keyword': $('#blogKeyword').val(),
      'description': $('#blogDescriptions').val(),
      'custom': $('#blogCustomTag').val(),
    }
  }

  $.ajax(settings).done(function (response) {
    clear_error();
    if (response.errors) {

        $.each(response.errors, function(k, v) {

            $form = $('#blog-form');

            $input = $form.find('[name="' + k + '"]');
            console.log(k,$input,$form);

            if ($input.data('style') != null) {
                $('[data-id="'+$input.attr('id')+'"]').addClass('is-invalid');
            }

            $input.addClass('is-invalid');
            $input.parent().append('<span class="invalid-feedback">' + v + '</span>');

        });
    } else {
        $("#blogcreate").modal('hide');
        $.toast({
            heading: response.heading,
            text: response.text,
            position: 'top-right',
            icon: response.icon,
            stack: false
        });
        location.reload();
    }
  })
});

$('#createNewMenu').click(function () {
    $("input#menuTitle").val("");
    $("input#menuUrl").val("");
    $("select#menuIsExternal").val(0).trigger('change');
    $("input#menuId").val("");
    $('#storeNewMenu').show();
    $('#updateMenu').hide();
    $("#createMenuModal").modal('show');
});
$('#storeNewMenu').click(function () {
    var settings = {
        "url": storeMenu_url,
        "method": "POST",
        "headers": {
            "Accept": "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        'data': {
            'title': $('input#menuTitle').val(),
            'url': $('input#menuUrl').val(),
            'page': $('select#pageUrl').val(),
            'is_external': $('select#menuIsExternal').val(),
        }
    }

    $.ajax(settings).done(function (response) {
        $("#createMenuModal").modal('hide');
        $.toast({
            heading: response.heading,
            text: response.text,
            position: 'top-right',
            icon: response.icon,
            stack: false
        });
        fetchMenus(1);
        fetchOrderedMenu();
    });
});
$('body').on('click', 'button#editMenu', function () {
    $("input#menuTitle").val($(this).attr('data-menuTitle'));
    if ($(this).attr('data-menuIsExternal') == "1") {
        $("select#menuIsExternal").val(1);
    } else {
        $("select#menuIsExternal").val(0);
    }
    $("select#menuIsExternal").trigger('change');
    $("input#menuUrl").val($(this).attr('data-menuUrl'));
    $("select#pageUrl").val($(this).attr('data-originalMenuUrl'));

    $("input#menuId").val($(this).attr('data-menuId'));
    $('#storeNewMenu').hide();
    $('#updateMenu').show();
    $("#createMenuModal").modal('show');
});
$('#updateMenu').click(function () {
    var settings = {
        "url": updateMenu_url,
        "method": "PATCH",
        "headers": {
            "Accept": "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        'data': {
            'id': $("input#menuId").val(),
            'title': $('input#menuTitle').val(),
            'url': $('input#menuUrl').val(),
            'page': $('select#pageUrl').val(),
            'is_external': $('select#menuIsExternal').val(),
        }
    }

    $.ajax(settings).done(function (response) {
        $("#createMenuModal").modal('hide');
        $.toast({
            heading: response.heading,
            text: response.text,
            position: 'top-right',
            icon: response.icon,
            stack: false
        });
        fetchMenus(1);
        fetchOrderedMenu();
    });
});
$('#cancelMenuOrder').on('click', function () {
    fetchOrderedMenu();
});
$('#saveMenuOrder').on('click', function () {
    var order = $('#dd').nestable('serialize');
    var settings = {
        "url": reorder_menu_url,
        "method": "POST",
        "headers": {
            "Accept": "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        "data": {'order': order}
    }

    $.ajax(settings).done(function (response) {
        $('#saveMenuOrder').hide();
        $.toast({
            heading: response.heading,
            text: response.text,
            position: 'top-right',
            icon: response.icon,
            stack: false
        });

        $("content-index").not('content-index#menu-order').show();
        $('content-index#menu-order').hide();
    });
});


$("#edit-microsite").on('click', function(e) {
    e.preventDefault();
    $(this).hide();
    $("#cancel-edit-microsite, #edit-microsite-save-btn").show();
    $("#edit-microsite-form select, #edit-microsite-form input, #edit-microsite-form textarea").removeAttr('disabled');
});

$("#cancel-edit-microsite").on('click', function(e) {
    e.preventDefault();
    $("#hostname").val(default_hostname);
    $("#title").val(default_title);
    $("#keywords").val(default_keywords);
    $("#description").val(default_description);
    $('#togBtn').val(default_blogs);
    $('#edit-microsite-save-btn').hide();
    $("#edit-microsite-form select, #edit-microsite-form input, #edit-microsite-form textarea").attr('disabled', 'disabled');
    $(this).hide();
    $("#edit-microsite").show();
});

$("#edit-microsite-form").on('submit', function(e) {
    e.preventDefault();
    if ($("#togBtn").is(':checked')) {
        var valcheck = 'true';
        $("this").attr('value', 'true');
    } else {
      var valcheck = 'false';
      $("this").attr('value', 'false')
    }
    var that = this;
    $.ajax({
        headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: $(this).attr('action'),
        data: {
          "id": $('[name="id"]').val(),
          "hostname": $('#hostname').val(),
          "title": $('#title').val(),
          "keywords": $('#keywords').val(),
          "description": $('#inputDescription').val(),
          "custom_tag": $('#inputCustomTag').val(),
          "blogs": valcheck
        },
        dataType: "json",
        success: function (response) {
            clear_error_messages();
            if (response.errors) {
                $.each(response.errors, function(k, v) {

                    $input = $(that).find('[name="' + k + '"]');

                    if ($input.data('style') != null) {
                        $('[data-id="'+$input.attr('id')+'"]').addClass('is-invalid');
                    }

                    $input.addClass('is-invalid');
                    $input.parent().append('<span class="invalid-feedback">' + v + '</span>');

                });
            } else {
                $.toast({
                    heading: response.heading,
                    text: response.text,
                    position: 'top-right',
                    icon: response.icon,
                    stack: false
                });
                if(response.icon == 'success') {
                    if($("#hostname").val() != default_hostname) {
                        default_hostname = $("#hostname").val();
                        setTimeout(() => {
                            window.location = `${microsite_route}/${$("#hostname").val()}`;
                            // location.reload();
                        }, 1000);
                    } else {
                        default_keywords = $("#keywords").val();
                        default_title = $("#title").val();
                        default_description = $("#description").val();
                        default_blogs = $("#togBtn").val();
                    }
                }
                $("#cancel-edit-microsite").trigger('click');
            }
        }
    });
});

function clear_error_messages() {
    $('input, select, button').removeClass('is-invalid')
	$('input, select').siblings('.invalid-feedback').remove();
}

$(function () {
    fetchPages(1);
    fetchMenus(1);
    fetchAllPages();
});

function fetchAllPages() {
    $.get(fetch_all_pages_url,
        function (data, textStatus, jqXHR) {
            $.each(data, function (indexInArray, value) {
                $('#pageUrl').append(`<option value="${value.id}">${value.title}</option>`);
            });
        },
        "json"
    );
}

$("#menuIsExternal").on('change', function() {
    let value = $(this).val();
    if(value == 1) {
        $("#pageUrl").val('').parents('.col-12').hide();
        $("#menuUrl").val('').parents('.col-12').show();
    } else {
        $("#pageUrl").val('').parents('.col-12').show();
        $("#menuUrl").val('').parents('.col-12').hide();
    }
});

$(document).on('click', '#page-pagination-control .pagination-controls a', function (e) {
    e.preventDefault();
    fetchPages($(this).attr('href').split('page=')[1]);
});

$(document).on('click', '#menu-pagination-control .pagination-controls a', function (e) {
    e.preventDefault();
    fetchMenus($(this).attr('href').split('page=')[1]);
});

$(document).on('keyup', '#searchInput', function(e) {
    if (e.which == 13) {
        fetchPages(1);
    } else if (e.which == 27) {
        $(this).val("");
        fetchPages(1);
    }
});

$(document).on('keyup', '#searchInput-menu', function(e) {
    if (e.which == 13) {
        fetchMenus(1);
    } else if (e.which == 27) {
        $(this).val("");
        fetchMenus(1);
    }
});

$("#search-page").on('click', function(e) {
    fetchPages(1);
});

$("#search-menu").on('click', function(e) {
    fetchMenus(1);
});

function fetchPages(page) {

    $.get(`${microsite_pages}`, {
        page: page,
        searchQuery: $('#searchInput').val()
    },
        function (response, textStatus, jqXHR) {
            var html = '', result ='', controls ='';
            if (response.data.length > 0) {
                $.each(response.data, function(k, v) {

                    html += `<tr>
                        <td>
                            <div class="lightbox-gallery" data-toggle="lightbox-gallery" data-type="image" data-effect="fadeInRight">
                                <div class="lightbox">
                                    <span>${(k + 1) + ((page - 1)*10)}. </span>
                                </div>
                            </div>
                        </td>
                        <td class="contact-list-name">
                            <div class="lightbox-gallery ml-3" data-toggle="lightbox-gallery" data-type="image" data-effect="fadeInRight">
                                <div class="lightbox">
                                    <span>${v.title}</span>
                                </div>
                            </div>
                        </td>
                        <td class="">
                            <span class="contact-list-phone d-block">${v.slug}</span>
                        </td>
                        <td>
                            <span class="badge bg-success-contrast color-success px-3">Active</span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="${edit_page_url}/${v.slug}" class="btn btn-default">
                                    <i class="feather feather-edit-2"></i>
                                </a>
                                <button id="delete" data-delete-type="swal" data-type="delete" data-url="${delete_page_url}/${v.id}" type="button" class="btn btn-default">
                                    <i class="feather feather-trash-2"></i>
                                </button>
                            </div>
                        </td>
                    </tr>`;

                });
            } else {
                html += `<tr>
                            <td colspan="5">
                                <h5 class="text-center p-5">
                                    No Data Available
                                </h5>
                            </td>
                        </tr>`;
            }

            result += 'Showing '+ response.from +' - '+ response.to +' of '+ response.total +' result';
            controls += ' <a href="'+(response.prev_page_url || '#')+'" class="btn fs-18 bw-1 radius-0 btn-outline-default ripple px-2 prev '+(response.prev_page_url || 'disabled')+'">'+
                            '<i class="list-icon material-icons">keyboard_arrow_left</i>'+
                          '</a>'+
                          '<a href="'+(response.next_page_url || '#')+'" class="btn fs-18 bw-1 radius-0 btn-outline-default ripple px-2 next '+(response.next_page_url || 'disabled')+'">'+
                              '<i class="list-icon material-icons">keyboard_arrow_right</i>'+
                          '</a>';

            $("#page-container").html(html);
            $('#page-pagination-control .pagination-result').text(result);
            $('#page-pagination-control .pagination-controls').html(controls);
        },
        "json"
    );

}

function fetchMenus(page) {

    $.get(`${microsite_menus}`, {
        page: page,
        searchQuery: $('#searchInput-menu').val()
    },
        function (response, textStatus, jqXHR) {
            var html = '', result ='', controls ='';
            if (response.data.length > 0) {
                $.each(response.data, function(k, v) {

                    html += `<tr>
                        <td>
                            <div class="lightbox-gallery" data-toggle="lightbox-gallery" data-type="image" data-effect="fadeInRight">
                                <div class="lightbox">
                                    <span>${(k + 1) + ((page - 1)*5)}. </span>
                                </div>
                            </div>
                        </td>
                        <td class="contact-list-name">
                            <div class="lightbox-gallery ml-3" data-toggle="lightbox-gallery" data-type="image" data-effect="fadeInRight">
                                <div class="lightbox">
                                    <span>${v.title}</span>
                                </div>
                            </div>
                        </td>
                        <td class="contact-list-name">
                            <div class="lightbox-gallery ml-3" data-toggle="lightbox-gallery" data-type="image" data-effect="fadeInRight">
                                <div class="lightbox">
                                    <span>${v.url}</span>
                                </div>
                            </div>
                        </td>
                        <td class="">
                            <span class="contact-list-phone d-block">${v.created_at}</span>
                        </td>
                        <td>
                            <span class="badge bg-success-contrast color-success px-3">Active</span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button id="editMenu" type="button" class="btn btn-default" data-menuId="`+v.id+`" data-originalMenuUrl="`+v.originalUrl+`" data-menuTitle="`+v.title+`" data-menuUrl="`+v.url+`" data-menuIsExternal="`+v.is_external+`">
                                    <i class="feather feather-edit-2"></i>
                                </button>
                                <button id="delete" data-delete-type="swal" data-type="delete" data-url="${delete_menu_url}/${v.id}" type="button" class="btn btn-default">
                                    <i class="feather feather-trash-2"></i>
                                </button>
                            </div>
                        </td>
                    </tr>`;

                });
            } else {
                html += `<tr>
                            <td colspan="6">
                                <h5 class="text-center p-5">
                                    No Data Available
                                </h5>
                            </td>
                        </tr>`;
            }

            result += 'Showing '+ response.from +' - '+ response.to +' of '+ response.total +' result';
            controls += ' <a href="'+(response.prev_page_url || '#')+'" class="btn fs-18 bw-1 radius-0 btn-outline-default ripple px-2 prev '+(response.prev_page_url || 'disabled')+'">'+
                            '<i class="list-icon material-icons">keyboard_arrow_left</i>'+
                          '</a>'+
                          '<a href="'+(response.next_page_url || '#')+'" class="btn fs-18 bw-1 radius-0 btn-outline-default ripple px-2 next '+(response.next_page_url || 'disabled')+'">'+
                              '<i class="list-icon material-icons">keyboard_arrow_right</i>'+
                          '</a>';

            $("#menu-container").html(html);
            $('#menu-pagination-control .pagination-result').text(result);
            $('#menu-pagination-control .pagination-controls').html(controls);
            $('content-index#menu-order').hide();
        },
        "json"
    );

}

function fetchOrderedMenu() {
    var settings = {
        "url": getOrdered_menu_url,
        "method": "GET",
        "headers": {
            "Accept": "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    }

    $("content-index").not('content-index#menu-order').show();
    $('content-index#menu-order').hide();

    $.ajax(settings).done(function (response) {
        var orderedMenu = "";
        $.each(response, function (key, val) {
            var children = ``;
            if (val.children) {
                children = children + `<ol class="dd-list">`;
                $.each(val.children, function (keyChild, valChild) {
                    children = children + `<li class="dd-item" data-id="`+valChild.id+`">
                                            <div class="dd-handle">`+valChild.title+`</div>
                                        </li>`;
                });
                children = children + `</ol>`;
            }
            orderedMenu = orderedMenu + `<li class="dd-item" data-id="`+val.id+`">
                                            <div class="dd-handle">`+val.title+`</div>
                                            `+children+`
                                        </li>`;
        });
        $("ol#most_parent_ol").html(orderedMenu);
        $('#saveMenuOrder').hide();
    });
}
function draw_data() {
    fetchPages(1);
    fetchMenus(1);
    fetchOrderedMenu();
}

$("#order-menu-btn").on('click', function(e) {
    e.preventDefault();
    $("content-index").not('content-index#menu-order').hide();
    $('content-index#menu-order').show();
});

$(".btn-edit-option").on('click', function(e) {
    let type = $(this).data('type');
    if(type == 'menu_order') {
        e.preventDefault();
        $("#order-menu-btn").trigger('click');
    } else if(type == 'custom_css') {
        e.preventDefault();
        $("#edit-custom-css").trigger('click');
    }
});

$("#edit-custom-css").on('click', function(e) {
    e.preventDefault();
    $("#editCssModal").modal({
        'backdrop': 'static',
        'keyboard': false
    });
});

$('#editCssModal').on('hidden.bs.modal', function (e) {
    $("#custom-css").val(default_custom_css);
});

$("#saveCustomCss").on('click', function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: custom_css_url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            css: $("#custom-css").val()
        },
        dataType: "json",
        success: function (response) {
            default_custom_css = $("#custom-css").val();
            $.toast({
                heading: response.heading,
                text: response.text,
                position: 'top-right',
                icon: response.icon,
                stack: false
            });
        }
    });
});

$("#clear-cache").on('click', function(e) {
    var that = this;
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: clear_cache_url,
        beforeSend: function(e) {
            $(that).attr('disabled', 'disabled');
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function (response) {
            $.toast({
                heading: response.heading,
                text: response.text,
                position: 'top-right',
                icon: response.icon,
                stack: false
            });
            $(that).removeAttr('disabled');
        }
    });
});

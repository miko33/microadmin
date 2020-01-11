$("#edit-blog").on('click', function(e) {
  e.preventDefault();
  $(this).hide();
  $("#cancel-edit-blog, #edit-blog-save-btn").show();
  $("#edit-blog-form select, #edit-blog-form input, #edit-blog-form textarea").removeAttr('disabled');
});
$("#cancel-edit-blog").on('click', function(e) {
  e.preventDefault();
  $('#edit-blog-save-btn').hide();
  $("#edit-blog-form select, #edit-blog-form input, #edit-blog-form textarea").attr('disabled', 'disabled');
  $(this).hide();
  $("#edit-blog").show();
});


$("#togBtn").on('change', function() {
        if ($(this).is(':checked')) {
            $(this).attr('value', 'true');
            $('.SelMenu').show()
            $('.squen').show()

        }
        else {
           $(this).attr('value', 'false');
             $('.SelMenu').hide()
             $('.squen').hide()
        }
    });

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
$('#createNewMenu').click(function () {
    $("input#menuTitle").val("");
    $("input#menuUrl").val("");
    $("select#menuIsExternal").val(0).trigger('change');
    $("input#menuId").val("");
    $("input#sequence").val("");
    $("select#UrlMenu").val("");
    $('#storeNewMenu').show();
    $('#updateMenu').hide();
    $("#createMenuModal").modal('show');
});


$('#storeNewMenu').click(function () {
    var settings = {
        "url": storeMenus,
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
    $('.sub').hide();
    $("#createMenuModal").modal('show');
});

$('#updateMenu').click(function () {
    var settings = {
        "url": upadteMenus,
        "method": "PATCH",
        "headers": {
            "Accept": "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        'data': {
            'id_menu': $("input#menuId").val(),
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
    });
});


$(function () {
    fetchPages(1);
    fetchMenus(1);
    fetchAllPages();
    fetchAllmenu();
});

function fetchAllPages() {
  $.get(fetch_all_content,
    function (data, textStatus, jqXHR) {
      // console.log(data);
      $.each(data, function (indexInArray, value) {
        $('#pageUrl').append(`<option value="${value.id_page}">${value.title}</option>`);
      });
    },
    "json"
  );
}
function fetchAllmenu() {
  $.get(fetch_all_menu,
    function (data, textStatus, jqXHR) {
      // console.log(data);
      $.each(data, function (indexInArray, value) {
        $('#UrlMenu').append(`<option value="${value.id_menu}">${value.title}</option>`);
      });
    },
    "json"
  );
}



$(document).on('click', '#page-pagination-control .pagination-controls a', function (e) {
    e.preventDefault();
    fetchPages($(this).attr('href').split('page=')[1]);
});

$(document).on('keyup', '#searchInput', function(e) {
    if (e.which == 13) {
        fetchPages(1);
    } else if (e.which == 27) {
        $(this).val("");
        fetchPages(1);
    }
});

$("#search-page").on('click', function(e) {
    fetchPages(1);
});


// page datatables
function fetchPages(page) {

    $.get(`${blog_page}`, {
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
                      <td style="text-align: center">
                      <div class="btn-group">
                      <a href="${editblogpage}/${v.slug}" class="btn btn-default">
                      <i class="feather feather-edit-2"></i>
                      </a>
                      <button id="delete" data-delete-type="swal" data-type="delete" data-url="${delete_content}/${v.id_page}" type="button" class="btn btn-default">
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


function draw_data() {
  fetchPages(1);
  fetchMenus(1);
}

$(document).on('click', '#menu-pagination-control .pagination-controls a', function (e) {
    e.preventDefault();
    fetchMenus($(this).attr('href').split('page=')[1]);
});
$(document).on('keyup', '#searchInput-menu', function(e) {
    if (e.which == 13) {
        fetchMenus(1);
    } else if (e.which == 27) {
        $(this).val("");
        fetchMenus(1);
    }
});
$("#search-menu").on('click', function(e) {
    fetchMenus(1);
});

function fetchMenus(page) {

    $.get(`${blog_menus}`, {
        page: page,
        searchQuery: $('#searchInput-menu').val()
    },
        function (response, textStatus, jqXHR) {
            var html = '', result ='', controls ='';
              if (response.data.length > 0) {
                $.each(response.data, function(k, v) {
                  // console.log(k);

                  html += `<tr id="${v.id_menu}" class="menuMaster${v.title}" subMenu="${v.sub_menu}">
                  <td></td>
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
                  <span>${v.url}</span>
                  </td>
                  <td class="">
                  <span class="contact-list-phone d-block">${v.created_at}</span>
                  </td>
                  <td>
                  <span class="badge bg-success-contrast color-success px-3">Active</span>
                  </td>
                  <td style="text-align: center">
                  <div class="btn-group">
                  <button id="editMenu" type="button" class="btn btn-default"  data-menuId="`+v.id_menu+`" data-originalMenuUrl="`+v.url+`" data-menuTitle="`+v.title+`" data-menuUrl="`+v.url+`" data-menuIsExternal="`+v.is_external+`">
                  <i class="feather feather-edit-2"></i>
                  </button>
                  <button id="delete" data-delete-type="swal" data-type="delete" data-url="${delete_list}/${v.id_menu}" type="button" class="btn btn-default">
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

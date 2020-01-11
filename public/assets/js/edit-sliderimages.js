function readURL(input, upload = false) {
    if (input.files && input.files[0]) {
    	$.each(input.files, function (key, val) {
    		var reader = new FileReader();

	        reader.onload = function (e) {
                if (upload) {
                    var settings = {
                        "url": uploadImageRoute,
                        "method": "POST",
                        "headers": {
                        "Accept": "application/json",
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        "data": {
                            'image': e.target.result,
                            'hostname': $('#uploadSlider').attr('data-microsite'),
                            'slider': 'true'
                        }
                    }

                    $.ajax(settings).done(function (response) {
                        console.log(response);
                        renderSliders();
                        renderSliderOrder();
                        $('input#sliderImage').val('');
                        $('#uploadSlider').hide();
                        $.toast({
                            heading: response.heading,
                            text: response.text,
                            position: 'top-right',
                            icon: response.icon,
                            stack: false
                        });
                    });
                } else {
                    $('content-index.previewImage').slideUp();
                    $('img#previewImage').attr('src', e.target.result);
                    $('content-index.previewImage').slideDown();
                }
	        }
	        reader.readAsDataURL(input.files[key]);
    	});
    }
}


$(document).on('submit','#imageupload',function (){
    console.log(new FormData(this));
    var formData = new FormData($('#imageupload')[0]);
    formData.append('hostname',$('input#host').val());
    $.ajax({
        headers : {'X-CSRF-Token': "{{ csrf_token() }}"},
        type:'POST',
        url: location.origin+'/microsites/uploadlocal',
        data:formData,
        cache:false,
        contentType : false,
        processData: false,
        success:function(response){
            $('input#image').val('');
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

$("#select-slider").on('click', function(e) {
    e.preventDefault();

    var settings = {
        "url": selectSliderFromMedia,
        "method": "POST",
        "headers": {
        "Accept": "application/json",
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        "data": {
            'image': $("#image-selector").val()
        }
    }

    $.ajax(settings).done(function (response) {
        $("#selectImageModal").modal('hide');
        renderSliders();
        renderSliderOrder();
        $('input#sliderImage').val('');
        $('#uploadSlider').hide();
        $.toast({
            heading: response.heading,
            text: response.text,
            position: 'top-right',
            icon: response.icon,
            stack: false
        });
    });
});

$("#sfm-button").on('click', function(e) {
    e.preventDefault();
    $("#selectImageModal").modal('show');
});

$('#dd').nestable({
    group: 1,
    maxDepth: 1
}).on('change', function() {
    $('#saveSliderOrder').show();
});

$('body').on('click', 'span.slider-url', function () {
    $('span.slider-url').css('color', '#444');
    $(this).css('color', '#8253eb');
    $('content-index.previewImage').slideUp();
    $('img#previewImage').attr('src', $(this).text());
    $('content-index.previewImage').slideDown();
});

$('body').on('click', '#slideUp', function () {
    $('span.slider-url').css('color', '#444');
    $('content-index.previewImage').slideUp();
});

$('body').on('change', 'input#sliderImage', function () {
    $('#uploadSlider').show();
    readURL(this);
});

$('body').on('change', '#imagelocal', function (){
    $('.saves').show();
});

$('body').on('click', '#uploadSlider', function () {
    var input = document.getElementById('sliderImage');
    readURL(input, true);
});

$('body').on('click', '#reorderSlider', function () {
    $('.firstStage').hide();
    $('.secondStage').show();
});
$('body').on('click', '#cancelSliderOrder', function () {
    $('.firstStage').show();
    $('.secondStage').hide();
    renderSliderOrder();
});
$('body').on('click', '#saveSliderOrder', function () {
    var order = $('#dd').nestable('serialize');
    console.log(order);
    var settings = {
        "url": reorderSliderRoute,
        "method": "POST",
        "headers": {
            "Accept": "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        "data": {'order': order}
    }

    $.ajax(settings).done(function (response) {
        $.toast({
            heading: response.heading,
            text: response.text,
            position: 'top-right',
            icon: response.icon,
            stack: false
        });
        $('.firstStage').show();
        $('.secondStage').hide();
    });
});

function draw_data() {
    $('.secondStage').hide();
    renderSliders();
    renderSliderOrder();
}
function renderSliders() {
    $('content-index.previewImage').slideUp();
    var sliders = "";
    var settings = {
        "url": getSlidersRoute,
        "method": "GET",
        "headers": {
        "Accept": "application/json",
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
    }

    $.ajax(settings).done(function (response) {
        $.each(response.sliders, function (key, val) {
            if(val.alt == null) {
                val.alt = '';
            }
            sliders = sliders + `<tr>
                                    <td>`+(key+1)+`</th>
                                    <td>
                                        <div class="lightbox-gallery ml-3" data-toggle="lightbox-gallery" data-type="image" data-effect="fadeInRight">
                                            <div class="lightbox">
                                                <span class="slider-url" title="Click me to preview." style="cursor: pointer;">${val.url}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>${val.alt}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="edit-slider btn btn-default" data-key="${key}" data-url="${val.url}" data-alt="${val.alt}">
                                                <i class="feather feather-edit-2"></i>
                                            </button>
                                            <button id="delete" data-delete-type="swal" data-type="delete" data-url="/microsites/${hostname}/deleteslider/${key}" type="button" class="btn btn-default">
                                                <i class="feather feather-trash-2"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>`;
        });
        $("#slider-container").html(sliders);
        $('.secondStage').hide();
        bindEditSlider();
    });
}

function renderSliderOrder() {
    var settings = {
        "url": getOrderedSliderRoute,
        "method": "GET",
        "headers": {
            "Accept": "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    }

    $.ajax(settings).done(function (response) {
        var orderedMenu = "";
        $.each(response.sliders, function (key, val) {
            orderedMenu = orderedMenu + `<li class="dd-item" data-id="${key}">
                                            <div class="dd-handle d-flex justify-content-between" style="width:100%;height: auto;">
                                                <span class="align-middle">${val.url} </span>
                                                <img class="" src="${val.url}" height="50px">
                                            </div>
                                        </li>`;
        });
        $("ol#most_parent_ol").html(orderedMenu);
    });
}

$(document).ready(function () {
    $(".image-picker").imagepicker();
    bindEditSlider();
});

function bindEditSlider() {
    $(".edit-slider").unbind('click').bind('click', function(event) {
        $("#editSliderModal").modal('show');
        $("#edit-slider-url").val($(this).data('url'));
        $("#edit-slider-image-alt").val($(this).data('alt'));
        $("#edit-slider-key").val($(this).data('key'));
    });
}

$("#save-edit-slider").on('click', function(event) {
    var settings = {
        "url": editSliderRoute,
        "method": "POST",
            "headers": {
            "Accept": "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        "data": {
            'key': $("#edit-slider-key").val(),
            'alt': $("#edit-slider-image-alt").val()
        }
    }

    $.ajax(settings).done(function (response) {
        console.log(response);
        renderSliders();
        renderSliderOrder();
        $('input#sliderImage').val('');
        $('#uploadSlider').hide();
        $.toast({
            heading: response.heading,
            text: response.text,
            position: 'top-right',
            icon: response.icon,
            stack: false
        });
        $("#editSliderModal").modal('hide');
    });
});

$(document).on('click', '#images-pagination-control .pagination-controls a', function (e) {
    e.preventDefault();
    renderImages($(this).attr('href'));
});
function draw_data() {
    renderImages(null);
}
function renderImages(page) {
    var url_request = imagesRoute;
    if (page) {
        url_request = page;
    }
    $('content-index.previewImage').slideUp();
    var images = "";
    var settings = {
        "url": url_request,
        "method": "GET",
        "headers": {
            "Accept": "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
    }

    $.ajax(settings).done(function (response) {
        $.each(response.images.data, function (key, val) {
            images = images + `<tr>
                                    <td>${key+1}</th>
                                    <td>
                                        <div class="lightbox-gallery ml-3" data-toggle="lightbox-gallery" data-type="image" data-effect="fadeInRight">
                                            <div class="lightbox">
                                                <span class="slider-url" title="Click me to preview." style="cursor: pointer;">${val.url}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="width:15%">
                                        <img src="${val.url}" style="height: 100px">
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button id="delete" data-delete-type="swal" data-type="delete" data-url="/microsites/${hostname}/deleteimage/`+val.id+`" type="button" class="btn btn-default">
                                                <i class="feather feather-trash-2"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>`;
        });
        $("#images-container").html(images);
        $("#images-pagination-result").text(`Showing ${response.images.from} - ${response.images.to} of ${response.images.total} result`);
        
        
        if (response.images.current_page == response.images.last_page) {
            // $("a.next").attr('disabled');
            $("a.next").attr('href', response.images.first_page_url);
        } else {
            // $("a.next").removeAttr('disabled');
            $("a.next").attr('href', response.images.next_page_url);
        }
        if (response.images.current_page == 1) {
            $("a.prev").attr('href', response.images.last_page_url);
            // $("a.prev").attr('disabled');
        } else {
            // $("a.prev").removeAttr('disabled');
            $("a.prev").attr('href', response.images.prev_page_url);
        }
    });
}
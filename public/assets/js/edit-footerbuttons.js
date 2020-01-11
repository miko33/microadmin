$(function () {
    fetchFooterButtons();
});

function draw_data() {
    fetchFooterButtons();
}

function fetchFooterButtons() {
    $("#footer-btn-tbl").html('');
    $.get(footer_buttons_url,
        function (data, textStatus, jqXHR) {
            $.each(data, function (index, value) {                
                $("#footer-btn-tbl").append(`
                    <tr>
                        <td>${index + 1}.</td>
                        <td>${value.title}</td>
                        <td>${value.url}</td>
                        <td style="width: 10%">
                            <div class="btn-group">
                                <button id="edit" data-type="put" data-url="${edit_footer_url}/${index}" type="button" class="btn btn-default"><i class="feather feather-edit-2"></i></button>
                                <button id="delete" data-delete-type="swal" data-type="delete" data-url="${delete_footer_url}/${index}" type="button" class="btn btn-default">
                                    <i class="feather feather-trash-2"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `);
            });
        },
        "json"
    );
}
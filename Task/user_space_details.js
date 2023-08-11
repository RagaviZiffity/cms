$(document).ready(function() {
    $('.page-link').click(function() {
        $('.subpage-link').removeClass('active');
        $('.page-link').removeClass('active');
        $(this).addClass('active');
    });

    $('.subpage-link').click(function() {
        $('.page-link').removeClass('active');
        $('.subpage-link').removeClass('active');
        $(this).addClass('active');
    });
});

function goToSubpageForm(pageId) {
    window.location.href = 'subpage_form.php?page_id=' + pageId;
}

function goBack() {
    window.location.href = 'userPage.php';
}

function getContent(space_id, sub_page_id, sub_id) {
    $.ajax({
        url: 'view_subpage.php?space_id=' + space_id + '&sub_page_id=' + sub_page_id + '&sub_id=' + sub_id,
        cache: false,
        type: 'GET',
        success: function(response) {
            $("#result").html(response);
        }
    });
}

function getContent1(space_id, sub_page_id, sub_id) {
    $.ajax({
        url: 'view_content.php?space_id=' + space_id + '&sub_page_id=' + sub_page_id + '&sub_id=' + sub_id,
        cache: false,
        type: 'GET',
        success: function(response) {
            $("#result").html(response);
        }
    });
}

$(document).ready(function () {
    $('img').each(function () {
        var src = $(this).attr('src');;
        $(this).attr('src', src.replace('www.dropbox', 'dl.dropboxusercontent'));
    });
    $('[style*="www.dropbox.com"]').each(function () {
        $(this).css('background-image', function (i, old) {
            return old.replace('www.dropbox', 'dl.dropboxusercontent')
        });
    });
});
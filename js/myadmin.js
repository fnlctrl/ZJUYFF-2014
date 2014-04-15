/**
 *
 * Author: Senorsen
 *
 */
var init_disp_list = ['name', 'method', 'slogan', 'members', 'time', 'ip', 'introduction'];
jQuery(function() {
    for (var i in init_disp_list) {
        $('.' + init_disp_list[i]).css('display', 'table-row').attr('must-disp', '1');;
    }
    $('.name').attr('data-expand', '0');
    $('.name').click(function() {
        if ($(this).attr('data-expand') == '0') {
            $(this).parent().children().css('display', 'table-row');
            $(this).attr('data-expand', '1');
        } else {
            $(this).parent().children().each(function() {
                if ($(this).attr('must-disp') != 1) {
                    $(this).css('display', 'none');
                }
            });
            $(this).attr('data-expand', '0');
        }
    });
});

var switchexpand = 0;
function switchAll() {
    if (!switchexpand) {
        switchexpand = 1;
        $('#exp-switch').html('全部隐藏');
        $('tr').css('display', 'table-row');
    } else {
        switchexpand = 0;
        $('#exp-switch').html('全部展开');
        $('tr').each(function() {
            if ($(this).attr('must-disp') != 1) {
                $(this).css('display', 'none');
            }
        });
    }
}


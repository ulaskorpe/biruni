$('#uttl_gonder').on('click', function (e) {
    e.preventDefault();
    var url = 'https://gtr.asrialahotel.com/likya/utatil/default.aspx?eid=1&hid=10583'

    var adultCount = $('#hotel_adult_count').val();
    var cid = $('#check_in').val();
    var cod = $('#check_out').val();

    var childCount = $('#hotel_child_count').val();
    var c1 = $('#child_count_1').val();
    var c2 = $('#child_count_2').val();
    var c3 = $('#child_count_3').val();

    var params = "&ac={adultCount}&cid={cid}&cod={cod}&cc={childCount}&c1ad={c1}&c2ad={c2}&c3ad={c3}"
        .replace(/{site_id}/gi, getParameterByName('site_id'))
        .replace(/{adultCount}/gi, adultCount)
        .replace(/{cid}/gi, cid)
        .replace(/{cod}/gi, cod)
        .replace(/{childCount}/gi, childCount)
        .replace(/{c1}/gi, c1)
        .replace(/{c2}/gi, c2)
        .replace(/{c3}/gi, c3);

    window.open(url + params);

});
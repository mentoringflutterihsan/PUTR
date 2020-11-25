$('select[name="kecamatan"]').on('change', function(){
    let kecamatan_id = $(this).val();
    $('select[name="desa"]').empty();
    $('select[name="desa"]').append(
        $('<option/>', {
            value: null,
            text: '- Pilih Desa -',
            disabled: true,
            selected: true
        })
    );

    if (kecamatan_id > 0) {
        $.ajax({
            url : base_url + '/kecamatan/' + kecamatan_id + '/desa',
            type : "GET",
            dataType : "json",
            success: function(data) {
                data.map( (data) => {
                    $('select[name="desa"]').append(
                        $('<option/>', {
                            value: data.id,
                            text: data.text
                        })
                    );
                })
            }
        });
    }
});
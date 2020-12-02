var _date = new Date();
var filter_tahun = _date.getFullYear();

const loadPembangunanTable = (tahun) => {
    $('#__tablePembangunan').DataTable({
        serverSide: true,
        processing: true,
        bDestroy: true,
        ajax: {
            type: 'GET',
            url: base_url + '/pembangunan/datatable',
            data: {
                tahun: tahun
            }
        },
        columnDefs: [
            {
                targets: [ 0, 6 ],
                orderable: false
            }
        ]
    })
}

loadPembangunanTable(filter_tahun);

$('#__filterTahun').change( function() {
    let tahun = $(this).val();

    filter_tahun = tahun;
    loadPembangunanTable(filter_tahun);
});


$('#__btnExportExcel').click( function() {
    window.location.href = base_url + '/pembangunan/export-excel/' + filter_tahun;
});
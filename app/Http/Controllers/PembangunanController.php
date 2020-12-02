<?php

namespace App\Http\Controllers;

use App\Pembangunan;
use App\Kecamatan;
use Illuminate\Http\Request;
use App\Exports\PembangunanExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class PembangunanController extends Controller
{
    /**
     * Display a listing of the pembangunan.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('pembangunan.index');
    }

    /**
     * Show the form for creating a new pembangunan.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', new Pembangunan);

        $data = [
            'kecamatan' => Kecamatan::pluck('nama_kecamatan','id')
        ];

        return view('pembangunan.create', $data);
    }

    /**
     * Store a newly created pembangunan in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->authorize('create', new Pembangunan);

        $newpembangunan = $request->validate([
            'name'      => 'required|max:60',
            'nilai_kontrak'   => 'nullable|max:255',
            'latitude'  => 'nullable|required_with:longitude|max:15',
            'longitude' => 'nullable|required_with:latitude|max:15',
            'lokasi'      => 'required|max:60',
            'panjang_pekerjaan' => 'required|max:60',

        ]);

        $pembangunan = Pembangunan::create($newpembangunan);

        return redirect()->route('pembangunan.show', $pembangunan);
    }

    /**
     *
     * @param  \App\Pembangunan  $pembangunan
     * @return \Illuminate\View\View
     */
    public function show(Pembangunan $pembangunan)
    {
        return view('pembangunan.show', compact('pembangunan'));
    }

    /**
     * Show the form for editing the specified pembangunan.
     *
     * @param  \App\pembangunan  $pembangunan
     * @return \Illuminate\View\View
     */
    public function edit(Pembangunan $pembangunan)
    {
        $this->authorize('update', $pembangunan);

        return view('pembangunan.edit', compact('pembangunan'));
    }

    /**
     * Update the specified pembangunan in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\pembangunan  $pembangunan
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, Pembangunan $pembangunan)
    {
        $this->authorize('update', $pembangunan);

        $pembangunanData = $request->validate([
            'name'      => 'required|max:60',
            'nilai_kontrak'   => 'nullable|max:255',
            'latitude'  => 'nullable|required_with:longitude|max:15',
            'longitude' => 'nullable|required_with:latitude|max:15',
            'lokasi'      => 'required|max:60',
            'panjang_pekerjaan' => 'required|max:60',
            'volume'      => 'required|max:60',
        ]);
        $pembangunan->update($pembangunanData);

        return redirect()->route('pembangunan.show', $pembangunan);
    }

    /**
     * Remove the specified pembangunan from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\pembangunan  $pembangunan
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Pembangunan $pembangunan)
    {
        $this->authorize('delete', $pembangunan);

        $request->validate(['pembangunan_id' => 'required']);

        if ($request->get('pembangunan_id') == $pembangunan->id && $pembangunan->delete()) {
            return redirect()->route('pembangunan.index');
        }

        return back();
    }

    /**
     * Export extel
     *
     * @return mixed
     */
    public function export_excel()
	{
		return Excel::download(new PembangunanExport, 'pembangunan.xlsx');
    }

    /**
     * Handle datatable server side of `Pembangunan` data
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function dataTable(Request $request)
    {
        $data = [];

        $tahun = $request->get('tahun', date('Y'));

        $start = $request->get('start', 10);
        $limit = $request->get('length', 10);
        $search = isset($request->get('search')['value']) ? $request->get('search')['value'] : null;
        $col_idx = isset($request->get('order')[0]['column']) ? $request->get('order')[0]['column'] : 0;
        $order_dir = isset($request->get('order')[0]['dir']) ? $request->get('order')[0]['dir'] : 'asc';

        $col_array = [
            'name', 'name', 'address', 'nilai_kontrak', 'tahun', 'panjang_pekerjaan'
        ];
        $col_name = $col_array[$col_idx];

        if ($limit > 100) {
            $limit = 100;
        }

        $fields = Pembangunan::tahun($tahun)
                            ->searchTable($search)
                            ->orderBy($col_name, $order_dir)
                            ->take($limit)
                            ->skip($start)
                            ->get();

        if (!empty($fields)) {
            $no = $start + 1;

            foreach ($fields as $field) {
                $row = [];

                $row[] = $no++;
                $row[] = $field->name;
                $row[] = $field->address;
                $row[] = $field->nilai_kontrak;
                $row[] = $field->tahun;
                $row[] = $field->panjang_pekerjaan;
                $row[] = '
                    <a href="'. route('pembangunan.show', [ 'pembangunan' => $field ]) .'" class="btn btn-sm btn-danger">
                        Detail
                    </a>';

                $data[] = $row;
            }
        }

        $count_total = Pembangunan::tahun($tahun)->count();
        $count_total_search = Pembangunan::tahun($tahun)->searchTable($search)->count();

        $response = [
            'draw' => $request->get('draw'),
            'recordsTotal' => $count_total,
            'recordsFiltered' => $count_total_search,
            'data' => $data
        ];

        return response()->json($response);
    }

    /**
     * Export excel `pembangunan` data
     *
     * @param int $tahun
     * @return mixed
     */
    public function exportExcel($tahun)
    {
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();

        $datas = Pembangunan::tahun($tahun)->with('desa')->get();

        $title = 'Data Pembangunan Tahun ' . $tahun;

        $sheet->setCellValue('A1', strtoupper($title));

        $sheet->setCellValue('A3', 'NO');
        $sheet->setCellValue('B3', 'NAMA PEKERJAAN');
        $sheet->setCellValue('C3', 'ALAMAT / LOKASI');
        $sheet->setCellValue('D3', 'DESA');
        $sheet->setCellValue('E3', 'LATITUDE');
        $sheet->setCellValue('F3', 'LONGITUDE');
        $sheet->setCellValue('G3', 'NILAI KONTRAK');
        $sheet->setCellValue('H3', 'TAHUN');
        $sheet->setCellValue('I3', 'PANJANG PEKERJAAN');

        $sheet->getRowDimension('1')->setRowHeight(25);
        $sheet->getRowDimension('3')->setRowHeight(25);
        $sheet->getStyle('A3:I3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3:I3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A3:I3')->getFont()->setBold(true);

        foreach (range('B', 'I') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $no = 1;
        $row_numb = 4;
        foreach ($datas as $data) {
            $sheet->setCellValue('A' . $row_numb, $no);
            $sheet->setCellValue('B' . $row_numb, $data->name);
            $sheet->setCellValue('C' . $row_numb, $data->address);
            $sheet->setCellValue('D' . $row_numb, $data->desa->nama_desa);
            $sheet->setCellValue('E' . $row_numb, $data->latitude);
            $sheet->setCellValue('F' . $row_numb, $data->longitude);
            $sheet->setCellValue('G' . $row_numb, $data->nilai_kontrak);
            $sheet->setCellValue('H' . $row_numb, $data->tahun);
            $sheet->setCellValue('I' . $row_numb, $data->panjang_pekerjaan);

            $no++;
            $row_numb++;
        }

        $xls = new Xls($spreadsheet);
        $filename = Str::slug($title, '_');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xls"');
        header('Cache-Control: max-age=0');

        return $xls->save('php://output');
    }
}

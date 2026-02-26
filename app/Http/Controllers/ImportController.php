<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use App\Services\ImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImportController extends Controller
{
    public function index()
    {
        return view('import.index');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimetypes:text/csv,text/plain,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|max:10240',
            'type' => 'required|in:arrears,tasks,followups,vehicle_statuses,taxpayers,vehicles',
        ]);

        $file = $request->file('file');
        $type = $request->input('type');

        $service = new ImportService();
        $result = $service->import($file, $type);

        AuditTrail::log('import', null, null, [
            'type' => $type,
            'filename' => $file->getClientOriginalName(),
            'result' => $result,
        ], "Import {$type}: {$result['created']} created, {$result['updated']} updated, {$result['skipped']} skipped, " . count($result['errors']) . " errors");

        return view('import.result', compact('result', 'type'));
    }

    public function downloadTemplate(string $type)
    {
        $templates = [
            'arrears' => 'templates/template_tunggakan.csv',
            'tasks' => 'templates/template_tugas.csv',
            'followups' => 'templates/template_followup.csv',
            'vehicle_statuses' => 'templates/template_status_kendaraan.csv',
            'taxpayers' => 'templates/template_wajib_pajak.csv',
            'vehicles' => 'templates/template_kendaraan.csv',
        ];

        if (!isset($templates[$type])) {
            abort(404);
        }

        $path = storage_path('app/' . $templates[$type]);
        if (!file_exists($path)) {
            abort(404, 'Template belum tersedia.');
        }

        return response()->download($path);
    }
}

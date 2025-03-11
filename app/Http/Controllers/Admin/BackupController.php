<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Backup\Tasks\Monitor\BackupDestinationStatusFactory;

class BackupController extends Controller
{
    public function index()
    {
        $statuses = BackupDestinationStatusFactory::createForMonitorConfig(config('backup.monitor_backups'));
        $backups = collect();

        foreach ($statuses as $status) {
            $backups = $backups->merge($status->backupDestination()->backups());
        }

        $backups = $backups->sortByDesc('date');

        return view('admin.backups.index', compact('statuses', 'backups'));
    }

    public function create(Request $request)
    {
        try {
            $type = $request->input('type');

            if ($type === 'database') {
                Artisan::call('backup:run --only-db');
                $message = 'Backup de la base de datos creado exitosamente.';
            } elseif ($type === 'files') {
                Artisan::call('backup:run --only-files');
                $message = 'Backup del sistema creado exitosamente.';
            } else {
                Artisan::call('backup:run');
                $message = 'Backup completo creado exitosamente.';
            }

            return redirect()->route('backups.index')->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Error al crear el backup: ' . $e->getMessage());
            return redirect()->route('backups.index')->with('error', 'Error al crear el backup.');
        }
    }

    public function download(Request $request)
    {
        $request->validate(['path' => 'required|string']);

        $path = $request->input('path');
        $disk = Storage::disk('google');

        if (!$disk->exists($path)) {
            return redirect()->route('backups.index')->with('error', 'El archivo no existe.');
        }

        try {
            $file = $disk->get($path);
            $fileName = basename($path);
            $mimeType = 'application/octet-stream';

            return response($file, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', "attachment; filename=\"$fileName\"");
        } catch (\Exception $e) {
            Log::error('Error al descargar el backup: ' . $e->getMessage());
            return redirect()->route('backups.index')->with('error', 'No se pudo descargar el archivo.');
        }
    }
}

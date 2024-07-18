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

    public function create()
    {
        try {
            Artisan::call('backup:run');
            return redirect()->route('backups.index')->with('success', 'Backup creado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear el backup: ' . $e->getMessage());
            return redirect()->route('backups.index')->with('error', 'Error al crear el backup.');
        }
    }

    public function download(Request $request)
    {
        $path = $request->input('path');
        $disk = Storage::disk('google');
        $file = $disk->get($path);
        $mimeType = $disk->mimeType($path);
        $fileName = basename($path);
    
        return response($file, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', "attachment; filename=\"$fileName\"");
    }
    
}

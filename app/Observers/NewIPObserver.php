<?php

namespace App\Observers;

use App\Models\BarcodeMachineMaster;
use Illuminate\Support\Facades\Log;

class NewIPObserver
{
    public function created(BarcodeMachineMaster $post)
    {
        //shell_exec('taskkill.exe /F /PID $(Get-WmiObject Win32_Process -Filter "name = \'python3.9.exe\'" | Where-Object {$_.CommandLine -like \'*init.py\'} | Select -ExpandProperty ProcessId)'); 
        pclose(popen("start /B c:\barcode\start.bat", "r")); 
        Log::debug('Script Statrted in BG');

    }
}

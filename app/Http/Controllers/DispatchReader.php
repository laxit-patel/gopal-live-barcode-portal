<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\ProcessMaster;

class DispatchReader extends Controller
{
    public function start($voucher)
    {
        $data = DB::select("select 
        om.so_po_no,
        pm.plant_id,
        lm.line_id,
        bmm.ip_address as ip,
        bmm.port,
        bmm.machine_id
         from order_masters om 
         join line_masters lm on lm.line_id = om.line_no
         join plant_masters pm on pm.plant_name = om.plant
        join barcode_machine_masters bmm on bmm.line_id = om.line_no
        where om.so_po_no = '{$voucher}' LIMIT 1;");

        if (count($data) == 0) {
            return redirect()->back()->with('error', 'Mapping Error [ line and plant not matched with machine masters table ]');
        } else {
            ProcessMaster::create([
                'so_po_no' => $data[0]->so_po_no,
                'plant_id' => $data[0]->plant_id,
                'line_id' => $data[0]->line_id,
                'machine_id' => $data[0]->machine_id,
                'ip' => $data[0]->ip,
                'port' => $data[0]->port,
            ]);

            pclose(popen("START /B c:\barcode\process\start.bat", "r"));
        }

        return redirect()->back()->with('success', 'Starting Barcode Reader');
    }

    public function stop($voucher)
    {
        $running = ProcessMaster::where('so_po_no', $voucher)->get()->first();
        if ($running) {
            exec("taskkill /f /PID {$running->pid}");
            ProcessMaster::find($running->id)->delete();
            return redirect()->back()->with('success', 'Reader Stopped');
        } else {
            return redirect()->back()->with('error', 'Reader is already Closed');
        }
    }
}

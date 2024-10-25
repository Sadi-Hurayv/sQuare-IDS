<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIController extends Controller
{
    public function predict(Request $request) 
    {
        $binary_column_names = [
            'dstPort' => null,
            'protocol' => null,
            'bwdPktLenMin' => null,
            'flowBytes' => null,
            'fwdIATMean' => null,
            'fwdIATMin' => null,
            'bwdIATTot' => null,
            'bwdIATStd' => null,
            'bwdIATMax' => null,
            'bwdIATMin' => null,
            'fwdPSHFlags' => null,
            'fwdURGFlags' => null,
            'fwdPkts' => null,
            'bwdPkts' => null,
            'pktLenMin' => null,
            'pktLenStd' => null,
            'pktLenVar' => null,
            'finFlagCnt' => null,
            'pshFlagCnt' => null,
            'ackFlagCnt' => null,
            'urgFlagCnt' => null,
            'eceFlagCnt' => null,
            'downUpRatio' => null,
            'fwdSegSizeAvg' => null,
            'bwdSegSizeAvg' => null,
            'subFlowBwdByts' => null,
            'initFwdWinByts' => null,
            'initBwdWinByts' => null,
            'fwdActDataPkts' => null,
            'fwdSegSizeMin' => null,
            'activeStd' => null,
            'activeMax' => null,
            'activeMin' => null,
            'idleMax' => null,
            'idleMin' => null,
        ];

        $multi_column_names = [
            'dstPort' => null,
            'protocol' => null,
            'fwdPktLenStd' => null, //--
            'bwdPktLenMin' => null,
            'flowBytes' => null,
            'flowIATStd' => null, //--
            'flowIATMin' => null, //--
            'fwdIATTot' => null, //--
            'fwdIATStd' => null, //--
            // 'fwdIATMean' => null,
            'fwdIATMin' => null,
            'bwdIATTot' => null,
            'bwdIATStd' => null,
            'bwdIATMax' => null,
            'bwdIATMin' => null,
            'fwdPSHFlags' => null,
            'fwdURGFlags' => null,
            'fwdPkts' => null,
            'bwdPkts' => null,
            'pktLenMin' => null,
            'pktLenStd' => null,
            'pktLenVar' => null,
            'finFlagCnt' => null,
            'rstFlagCnt' => null, //--
            'pshFlagCnt' => null, //--
            'ackFlagCnt' => null,
            'urgFlagCnt' => null,
            // 'eceFlagCnt' => null,
            'downUpRatio' => null,
            'fwdSegSizeAvg' => null,
            'bwdSegSizeAvg' => null,
            'subFlowBwdByts' => null,
            'initFwdWinByts' => null,
            'initBwdWinByts' => null,
            'fwdActDataPkts' => null,
            'fwdSegSizeMin' => null,
            'activeStd' => null,
            'activeMax' => null,
            'activeMin' => null,
            'idleStd' => null, //--
            // 'idleMax' => null,
            'idleMin' => null,
        ];

        // dd(implode('=1&', array_keys($column_names)));
        $hasNull = false;
        $colName = null;

        // dd($request->all());

        // data for binary classification
        foreach ($binary_column_names as $param => $val) {
            if ($request->has($param)) {
                $binary_column_names[$param] = $request->input($param);
            } else {
                $hasNull = true;
                $colName = $param;
                break;
            }   
        }

        if ($hasNull) {
            return response()->json([
                'message' => 'Bad input parameter (' . $colName . ').',
                'code' => 400,
            ], 400);
        }

        // data for multi classification
        foreach ($multi_column_names as $param => $val) {
            if ($request->has($param)) {
                $multi_column_names[$param] = $request->input($param);
            } else {
                $hasNull = true;
                $colName = $param;
                break;
            }   
        }
 
        if ($hasNull) {
            return response()->json([
                'message' => 'Bad input parameter (' . $colName . ').',
                'code' => 400,
            ], 400);
        }

        // Binary Classification
        $filePath = "\"". public_path('assets/python/binaryClassification.py') . "\"";
        $command = 'python3 ' . $filePath . ' ' . implode(' ', $binary_column_names) . ' 2>&1';
        
        $output = shell_exec($command);
        //dd([$command, $output]);
        $output="Malicious";

        // Multi Classification
        if(trim($output) === "Malicious")
        {
            $filePath = "\"". public_path('assets/python/multiClassification.py') . "\"";
            $command = 'python3 ' . $filePath . ' ' . implode(' ', $multi_column_names) . ' 2>&1';
            
            $output = shell_exec($command);
            // $output = "multi";
            //dd([$command, $output]);
        }

        return response()->json([
            // $command, 
            'message' => $output,
        ], 200);
    }
}

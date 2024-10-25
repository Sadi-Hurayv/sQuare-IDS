<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Packet;


class FrontendController extends Controller
{

    public $column_names = [
        'dstPort' => ['Dst Port', 'Destination port'],
        'protocol' => ['Protocol', 'Protocol of the packet'],
        'fwdPktLenStd' => ['Fwd Pkt Len Std', 'Standard deviation size of packet in forward direction'], //--
        'bwdPktLenMin' => ['Bwd Pkt Len Min', 'Minimum size of packet in backward direction'],
        'flowBytes' => ['Flow Byts/s', 'Flow byte rate that is number of packets transferred per second'],
        'flowIATStd' => ['Flow IAT Std', 'Standard deviation time two flows'], //--
        'flowIATMin' => ['Flow IAT Min', 'Minimum time between two flows'], //--
        'fwdIATTot' => ['Fwd IAT Tot', 'Total time between two packets sent in the forward direction'], //--
        'fwdIATStd' => ['Fwd IAT Std', 'Standard deviation time between two packets sent in the forward direction'], //--
        'fwdIATMean' => ['Fwd IAT Mean', 'Mean time between two packets sent in the forward direction'],
        'fwdIATMin' => ['Fwd IAT Min', 'Minimum time between two packets sent in the forward direction'],
        'bwdIATTot' => ['Bwd IAT Tot', 'Total time between two packets sent in the backward direction'],
        'bwdIATStd' => ['Bwd IAT Std', 'Standard deviation time between two packets sent in the backward direction'],
        'bwdIATMax' => ['Bwd IAT Max', 'Maximum time between two packets sent in the backward direction'],
        'bwdIATMin' => ['Bwd IAT Min', 'Minimum time between two packets sent in the backward direction'],
        'fwdPSHFlags' => ['Fwd PSH Flags', 'Number of times the PSH flag was set in packets travelling in the forward direction (0 for UDP)'],
        'fwdURGFlags' => ['Fwd URG Flags', 'Number of times the URG flag was set in packets travelling in the forward direction (0 for UDP)'],
        'fwdPkts' => ['Fwd Pkts/s', 'Number of forward packets per second'],
        'bwdPkts' => ['Bwd Pkts/s', 'Number of backward packets per secon'],
        'pktLenMin' => ['Pkt Len Min', 'Minimum length of a flow'],
        'pktLenStd' => ['Pkt Len Std', 'Standard deviation length of a flow'],
        'pktLenVar' => ['Pkt Len Var', 'Minimum inter-arrival time of packet'],
        'finFlagCnt' => ['FIN Flag Cnt', 'Number of packets with FIN'],
        'rstFlagCnt' => ['RST Flag Cnt', 'Number of packets with RST'], //--
        'pshFlagCnt' => ['PSH Flag Cnt', 'Number of packets with PUSH'],
        'ackFlagCnt' => ['ACK Flag Cnt', 'Number of packets with ACK'],
        'urgFlagCnt' => ['URG Flag Cnt', 'Number of packets with URG'],
        'eceFlagCnt' => ['ECE Flag Cnt', 'Number of packets with ECE'],
        'downUpRatio' => ['Down/Up Ratio', 'Download and upload ratio'],
        'fwdSegSizeAvg' => ['Fwd Seg Size Avg', 'Average size observed in the forward direction'],
        'bwdSegSizeAvg' => ['Bwd Seg Size Avg', 'Average size observed in the backward direction'],
        'subFlowBwdByts' => ['Subflow Bwd Byts', 'The average number of bytes in a sub flow in the backward direction'],
        'initFwdWinByts' => ['Init Fwd Win Byts', 'Number of bytes sent in initial window in the forward direction'],
        'initBwdWinByts' => ['Init Bwd Win Byts', 'Number of bytes sent in initial window in the backward direction'],
        'fwdActDataPkts' => ['Fwd Act Data Pkts', 'Number of packets with at least 1 byte of TCP data payload in the forward direction'],
        'fwdSegSizeMin' => ['Fwd Seg Size Min', 'Minimum segment size observed in the forward direction'],
        'activeStd' => ['Active Std', 'Standard deviation time a flow was active before becoming idle'],
        'activeMax' => ['Active Max', 'Maximum time a flow was active before becoming idle'],
        'activeMin' => ['Active Min', 'Minimum time a flow was active before becoming idle'],
        'idleStd' => ['Idle Std', 'Standard deviation time a flow was idle before becoming active'], //--
        'idleMax' => ['Idle Max', 'Maximum time a flow was idle before becoming active'],
        'idleMin' => ['Idle Min', 'Minimum time a flow was idle before becoming active'],
    ];

    public function information()
    {
        return view('information', ['column_names'=> $this->column_names]);
    }

    public function test()
    {
        // dd(public_path('assets/data/testData.csv'));

        $reader = \LeagueCSVReader::createFromPath(public_path('assets/data/testData.csv'), 'r');

        $reader->setHeaderOffset(0);
        // $results = $reader->getRecords();

        // dd(count($reader));
        // dd($reader->nth(rand(0, count($reader) - 1)));
        $testData = $reader->nth(rand(0, count($reader) - 1));

        return view('apitest', ['column_names'=> $this->column_names, 'testData'=> $testData]);
    }

    public function call(Request $request)
    {
        $params = $request->all();
        unset($params['_token']);
        $label = $params['label'];
        unset($params['label']);
        // dd($params);

        $response = Http::get('http://127.0.0.1:8001/api/classification', $params);
        $formData=['Label' => trim($response->json('message'))];
        foreach($this->column_names as $key=>$data)
        {
            $formData[$data[0]] = $params[$key];
        }
        // dd($formData);
        Packet::create($formData);

        // dd($response->json());
        return redirect()->route('api.test')->withOutput($response->json('message'))->withLabel($label);
    }
}

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <style>
            html{font-family:sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}body{margin:0}b{font-weight:700}table{border-spacing:0;border-collapse:collapse}td,th{padding:0}*{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}:after,:before{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}html{font-size:10px;-webkit-tap-highlight-color:transparent}body{font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:14px;line-height:1.42857143;color:#333;background-color:#fff}h2,h4{font-family:inherit;font-weight:500;line-height:1.1;color:inherit}h2{margin-top:20px;margin-bottom:10px}h4{margin-top:10px;margin-bottom:10px}h2{font-size:30px}h4{font-size:18px}table{background-color:transparent}th{text-align:left}.table{width:100%;max-width:100%;margin-bottom:20px}.table>tbody>tr>td,.table>thead>tr>th{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd}.table>thead>tr>th{vertical-align:bottom;border-bottom:2px solid #ddd}.table>thead:first-child>tr:first-child>th{border-top:0}.table-bordered{border:1px solid #ddd}.table-bordered>tbody>tr>td,.table-bordered>thead>tr>th{border:1px solid #ddd}.table-bordered>thead>tr>th{border-bottom-width:2px}.panel{margin-bottom:20px;background-color:#fff;border:1px solid transparent;border-radius:4px;-webkit-box-shadow:0 1px 1px rgba(0,0,0,.05);box-shadow:0 1px 1px rgba(0,0,0,.05)}.panel-body{padding:15px}.panel-default{border-color:#ddd}.panel-body:after,.panel-body:before{display:table;content:" "}.panel-body:after{clear:both}div,h1,h2,h3,h4,h5,h6,p,span{font-family:DejaVu Sans;margin:0;padding:0},.page-break{page-break-after: always;}
            .container { white-space: nowrap; }
            .column { display: inline-block; width: 50%; white-space: normal; }
        </style>
    </head>
    <body style="margin:0">
        @foreach ($data["feed_analysis_tests"] as $feed_analysis_test)
        <div style="text-align:center">
            <h4>Republic of the Philippines</h5>
            <h4 style="font-weight: bold">DEPARTMENT OF AGRICULTURE</h4>
            <h4>Regional Feed Analysis Laboratory</h4>
        </div>

        <div style="margin-top:0.5in;margin-bottom:0.5in">
            <h3 style="text-align: center">CHEMICAL ANALYSIS REPORT</h3>
        </div>
        
        <div class="container">
            <div class="column">
                <b>Client's Name: </b> {{ $data["client"]->name }}<br>
                <b>Address: </b> {{ $data["client"]->address }}<br>
                <b>Analysis Requested: </b>
                @foreach($feed_analysis_test->analysis_requests as $analysis_request)
                    {{ $analysis_request->parameter }}{{ $loop->last ? '' : ', ' }}
                @endforeach<br>
                <b>Name of Sample: </b> {{ $feed_analysis_test->sample_name }}
            </div>
            <div class="column">
                <b>Date Received: </b> {{ date_format($data["created_at"], 'F j, Y') }}<br>
                <b>Date Reported: </b> {{ date('F j, Y') }}<br>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Parameter</th>
                    <th>Result</th>
                    <th>Method</th>
                </tr>
            </thead>
            <tbody>
                @foreach($feed_analysis_test->analysis_requests as $analysis_request)
                    <tr>
                        <td>{{ $analysis_request->parameter }}</td>
                        <td>{{ $analysis_request->result }} %</td>
                        <td>{{ $analysis_request->method }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="font-size:11px"><i>Results of analyses refer to the particular sample submitted. Reproduction of excerpts from this report unless otherwise authorized by the Regional Feed Analysis Laboratory (RFAL) is punishable by law. Any erasures thereon will invalidate the report.</i></div>

        <div style="position:absolute;bottom:0">
            <p style="margin-top:0.2in">Certified by:</p>

            <div style="margin-top:0.2in;width:50%">
                <h4 style="text-decoration:underline;text-transform:uppercase"><b>{{ App\HeadManager::find(1)->name }}</b></h4>
                <span>Head Manager</span>
            </div>
        </div>

        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
        @endforeach
        
{{-- 
        <div style="margin-top:0.2in">
            <h3 style="text-align: center">MEAT INSPECTION CERTIFICATE</h3>
            <p style="margin-top:0.2in;text-indent: 1in">This is to certify that the meat and / or entrails described below are animals slaughtered in this abbatoir and at the time and date of inspection is fit for human consumption.</p>
            <table class="table table-bordered" style="margin-top: 0.2in">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kind of Meat</th>
                        <th>Quantity</th>
                        <th>Total Weight</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (array_pad($data["outgoings"], 3, array("meat_type" => null, "quantity" => null, "total_weight" => null)) as $outgoing)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $outgoing["meat_type"] }}</td>
                            <td>{{ $outgoing["quantity"] }}</td>
                            <td>{{ $outgoing["total_weight"] }} {{ $outgoing["total_weight"] ? 'kg' : null }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top:0.2in">This said meat and / or entrails is offered or transported as follows:<div>

            <div style="margin-top:0.2in">
                <p><b>Name of Owner:</b> {{ $data["name"] }}</p>
                <p><b>Conveyance used:</b>  {{ $data["conveyance_type"] }}</p>
                <p><b>Plate number:</b> {{ $data["plate_number"] }}</p>
            </div>

            <div style="position:absolute;bottom:0">
                <p style="margin-top:0.2in">Inspected by:</p>

                <div style="margin-top:0.2in;width:50%;text-align:center">
                    <h4 style="text-decoration: underline">{{ $data["inspected_by"] }}</h4>
                    <span><b>{{ $data["inspector_position"] }}</b></span>
                </div>
            </div>
        </div> --}}
    </body>
</html>

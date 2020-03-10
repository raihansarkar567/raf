@extends('layouts.admin_layout')

@section('content')
<div class="container cusTopMargin">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Admin Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    You are logged in as Admin!
                    
                      <div class="row">
                        <div class="col-sm-6">
                            <div class="card ad_top_card">
                              <div style="margin:auto;">
                                <i class="fa fa-dollar" style="font-size:200%; color:#616774;"></i>
                              </div>
                            <div>
                              <p>Total Cost</p>
                              <p><strong id="cost">0</strong> <span> tk</span></p>
                            </div>
                          </div>
                          <div class="card ad_top_card">
                              <div style="margin:auto;">
                                <i class="fa fa-bar-chart" style="font-size:200%; color:#46BFBD;"></i>
                              </div>
                            <div>
                              <p>Total Sale</p>
                              <p><strong id="sales">0</strong> <span> tk</span></p>
                            </div>
                          </div>
                          <div class="card ad_top_card">
                              <div style="margin:auto;">
                                <i class="fa fa-pie-chart" aria-hidden="true" style="font-size:200%; color:#FF5A5E;"></i>
                              </div>
                            <div>
                              <p>Total Profit</p>
                              <p><strong id="profit">0</strong> <span> tk</span></p>
                            </div>
                          </div>
                          <div class="card ad_top_card">
                              <div style="margin:auto;">
                                <i class="fa fa-hourglass-start" aria-hidden="true" style="font-size:200%; color:#FFC870;"></i>
                              </div>
                            <div>
                              <p>Total Asset</p>
                              <p><strong id="asset">0</strong> <span> tk</span></p>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                              <canvas id="lineChart" width="400" height="200"></canvas>
                        </div>
                      </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                   <th>Month</th>
                                   <th>Cost</th>
                                   <th>Sale</th>
                                   <th>Profit</th>
                                   <th>Asset</th>
                               </tr>
                            </thead>
                            <tbody>
                                @foreach ($deshboard_info as $desh_info)
                                    @if ($desh_info->time_num!=13 && $desh_info->time_num!=14 && $desh_info->time_num!=15)
                                        <tr>
                                            <td><b>{{$desh_info->time_name}}</b></td>
                                            <td>{{$desh_info->total_cost}}</td>
                                            <td>{{$desh_info->total_sale}}</td>
                                            <td>{{$desh_info->total_profit}}</td>
                                            <td>{{$desh_info->remaining}}</td>
                                        </tr>
                                    @endif
                                    
                                @endforeach
                            </tbody>
                        </table>
                      </div>
                      <div class="col-sm-6">
                        {{-- pai chart section --}}
                        <div id="piechart"></div>
                        <div id="piechartYearly"></div>
                        {{-- pai chart section end --}}
                      </div>
                    </div>
                    
                    <h5><b><u>Yearly Calculation</u></b></h5>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                               <th>Month</th>
                               <th>Cost</th>
                               <th>Sale</th>
                               <th>Profit</th>
                               <th>Asset</th>
                           </tr>
                        </thead>
                        <tbody>
                            @foreach ($deshboard_info as $desh_info)
                                @if ($desh_info->time_num==13 || $desh_info->time_num==14)
                                    <tr>
                                        <td><b>{{$desh_info->time_name}}</b></td>
                                        <td>{{$desh_info->total_cost}}</td>
                                        <td>{{$desh_info->total_sale}}</td>
                                        <td>{{$desh_info->total_profit}}</td>
                                        <td>{{$desh_info->remaining}}</td>
                                    </tr>
                                @endif
                                
                            @endforeach
                        </tbody>
                    </table>
                    <h5><b><u>Begain to Endtime Calculation</u></b></h5>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                               <th>Month</th>
                               <th>Cost</th>
                               <th>Sale</th>
                               <th>Profit</th>
                               <th>Asset</th>
                           </tr>
                        </thead>
                        <tbody>
                            @foreach ($deshboard_info as $desh_info)
                                @if ($desh_info->time_num==15)
                                    <tr>
                                        <td><b>{{$desh_info->time_name}}</b></td>
                                        <td>{{$desh_info->total_cost}}</td>
                                        <td>{{$desh_info->total_sale}}</td>
                                        <td>{{$desh_info->total_profit}}</td>
                                        <td>{{$desh_info->remaining}}</td>
                                    </tr>
                                @endif
                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- scroll top --}}
<button onclick="topFunction()" id="scrollTop" title="Go to top">Top</button>
<script type="text/javascript">
//Get the button
var mybutton = document.getElementById("scrollTop");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
</script>
{{-- scroll top end --}}

{{-- script pai chart --}}
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
  

//curent date
var date = new Date();
var month =date.getMonth() + 1;

var array = @json($deshboard_info);
array.forEach(arrFunction);
function arrFunction(value){
  if(month==value["time_num"]){
    var cost = parseFloat(value["total_cost"]);
    var asset = parseFloat(value["remaining"]);
    var profit = parseFloat(value["total_profit"]);
    var sales = parseFloat(value["total_sale"]);

    document.getElementById("cost").innerHTML = cost;
    document.getElementById("asset").innerHTML = asset;
    document.getElementById("profit").innerHTML = profit;
    document.getElementById("sales").innerHTML = sales;
    // Load google charts
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    // Draw the chart and set the chart values
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
      ['Finance', 'Current Month Report'],
      ['Total Cost', cost],
      ['Asset', asset],
      ['Profit', profit],
      ['Sales', sales]
    ]);

      // Optional; add a title and set the width and height of the chart
      var options = {
      width: 400,
      height: 240,
      backgroundColor: 'transparent',
      title: 'Current Month Report',
      colors: ['#616774', '#FF5A5E', '#FFC870', '#46BFBD']
    };

      // Display the chart inside the <div> element with id="piechart"
      var chart = new google.visualization.PieChart(document.getElementById('piechart'));
      chart.draw(data, options);
    }
  }

  if(value["time_num"]==13){
    var cost = parseFloat(value["total_cost"]);
    var asset = parseFloat(value["remaining"]);
    var profit = parseFloat(value["total_profit"]);
    var sales = parseFloat(value["total_sale"]);
    // Load google charts
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    // Draw the chart and set the chart values
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
      ['Finance', 'Yearly Report'],
      ['Total Cost', cost],
      ['Asset', asset],
      ['Profit', profit],
      ['Sales', sales]
    ]);

      // Optional; add a title and set the width and height of the chart
      var options = {
      width: 400,
      height: 240,
      backgroundColor: 'transparent',
      title: 'Yearly Report',
      colors: ['#616774', '#FF5A5E', '#FFC870', '#46BFBD']
    };

      // Display the chart inside the <div> element with id="piechart"
      var chart = new google.visualization.PieChart(document.getElementById('piechartYearly'));
      chart.draw(data, options);
    }
  }
}
</script>

{{-- Line Chart --}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script>
  var jan = 0; var fab = 0; var mar = 0; var apr = 0; var may = 0; var jun = 0;
  var jul = 0; var aug = 0; var sep = 0; var oct = 0; var nov = 0; var dec = 0;

  var array = @json($deshboard_info);
  array.forEach(arrFunction);
  function arrFunction(value){
      if(value["time_num"]==1){
        jan = parseFloat(value["total_profit"]);
      }
      if(value["time_num"]==2){
        fab = parseFloat(value["total_profit"]);
      }
      if(value["time_num"]==3){
        mar = parseFloat(value["total_profit"]);
      }
      if(value["time_num"]==4){
        apr = parseFloat(value["total_profit"]);
      }
      if(value["time_num"]==5){
        may = parseFloat(value["total_profit"]);
      }
      if(value["time_num"]==6){
        jun = parseFloat(value["total_profit"]);
      }
      if(value["time_num"]==7){
        jul = parseFloat(value["total_profit"]);
      }
      if(value["time_num"]==8){
        aug = parseFloat(value["total_profit"]);
      }
      if(value["time_num"]==9){
        sep = parseFloat(value["total_profit"]);
      }
      if(value["time_num"]==10){
        oct = parseFloat(value["total_profit"]);
      }
      if(value["time_num"]==11){
        nov = parseFloat(value["total_profit"]);
      }
      if(value["time_num"]==12){
        dec = parseFloat(value["total_profit"]);
      }

  }
      var ctx = document.getElementById('lineChart').getContext('2d');
      var lineChart = new Chart(ctx, {
          type: 'line',
          data: {
              labels: ['Jan', 'Fab', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
              datasets: [{
                  label: 'Profit',
                  data: [jan, fab, mar, apr, may, jun, jul, aug, sep, oct, nov, dec],
                  backgroundColor: [
                      'rgba(255, 99, 132, 0.2)',
                      'rgba(54, 162, 235, 0.2)',
                      'rgba(255, 206, 86, 0.2)',
                      'rgba(75, 192, 192, 0.2)',
                      'rgba(153, 102, 255, 0.2)',
                      'rgba(255, 159, 64, 0.2)',
                      'rgba(255, 99, 132, 0.2)',
                      'rgba(54, 162, 235, 0.2)',
                      'rgba(255, 206, 86, 0.2)',
                      'rgba(75, 192, 192, 0.2)',
                      'rgba(153, 102, 255, 0.2)',
                      'rgba(255, 159, 64, 0.2)'
                  ],
                  borderColor: [
                      'rgba(255, 99, 132, 1)',
                      'rgba(54, 162, 235, 1)',
                      'rgba(255, 206, 86, 1)',
                      'rgba(75, 192, 192, 1)',
                      'rgba(153, 102, 255, 1)',
                      'rgba(255, 159, 64, 1)',
                      'rgba(255, 99, 132, 1)',
                      'rgba(54, 162, 235, 1)',
                      'rgba(255, 206, 86, 1)',
                      'rgba(75, 192, 192, 1)',
                      'rgba(153, 102, 255, 1)',
                      'rgba(255, 159, 64, 1)'
                  ],
                  borderWidth: 1
              }]
          },
          options: {
              scales: {
                  yAxes: [{
                      ticks: {
                          beginAtZero: true
                      }
                  }]
              }
          }
      });
    
</script>


{{-- script chart end --}}


@endsection
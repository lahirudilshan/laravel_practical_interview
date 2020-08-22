@extends('layouts.master')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
@endsection

@section('content')
<div class="h-100">
    <div class="row h-100 d-flex align-items-center justify-content-center">
        <div class="col">
            <div class="bg-white p-4">
                <!-- chart section -->
                <div class="row">
                    <div class="col-12">
                        <div id="charts">
                        </div>
                    </div>
                </div>
                <!--/. chart section -->

                <!-- filter section -->
                <div class="row mt-4">
                    <div class="col-10">
                        <div class="row">
                            <div class="col-6">
                                <div class="row justify-content-center align-items-center mb-4">
                                    <div class="col-3"><div class="inline-label">Start Date</div></div>
                                    <div class="col-9">
                                        <div class="form-group">
                                            <div class="input-group date" id="startDate" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input" 
                                                placeholder="YYYY/MM/DD" data-target="#startDate"/>
                                                <div class="input-group-append" data-target="#startDate" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                            <div id="startDateError"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row justify-content-center align-items-center mb-4">
                                    <div class="col-3"><div class="inline-label">End Date</div></div>
                                    <div class="col-9">
                                        <div class="form-group">
                                            <div class="input-group date" id="endDate" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input" placeholder="YYYY/MM/DD" data-target="#endDate"/>
                                                <div class="input-group-append" data-target="#endDate" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                            <div id="endDateError"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <button type="submit" id="filter_button" class="btn btn-primary btn-block">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
                <!--/. chart section -->

                <!-- feedback table -->
                <table class="table table-condensed">
                    <thead class="bg-dark text-white">
                        <tr>
                            <td>Email</td>
                            {!! $tableHeaderHTML !!}
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        {!! $tableBodyHTML !!}
                    </tbody>
                </table>

                <div class="my-4" id="pagination"></div>
                
                @error('answer')
                    <div class="alert alert-danger mt-4" role="alert">
                        {{ $message }}
                    </div>
                @enderror
                <!--/. feedback table -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        // init datepicker
        $('#startDate').datetimepicker({
            format: 'YYYY/MM/DD'
        });
        $('#endDate').datetimepicker({
            format: 'YYYY/MM/DD'
        });

        $("#startDate").on("change.datetimepicker", function (e) {
            if(e.date){
                $('#startDateError').html('');
                $('#startDate > input').removeClass('is-invalid');
            }
            $('#endDate').datetimepicker('minDate', e.date);
        });

        $("#endDate").on("change.datetimepicker", function (e) {
            if(e.date){
                $('#endDateError').html('');
                $('#endDate > input').removeClass('is-invalid');
            }
            $('#startDate').datetimepicker('maxDate', e.date);
        });

        $('#filter_button').click(function(e){
            e.preventDefault();

            var options = {
                data: {
                    startDate: $('#startDate > input').val(),
                    endDate: $('#endDate > input').val(),
                },
                method: 'POST',
                url: '{{ route("question.summery") }}'
            };

            // load feedback with pagination
            loadFeedbacks(options);
        });
    });

    // get feedbacks from server
    function loadFeedbacks(options){
        $.ajax({
            type: options.method,
            url: options.url,
            data: options.data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (response) {
                removeLoading();

                if(response.success){
                    // replace table body with generate table from controller
                    $('#tbody').html(response.data);

                    if(response.pagination){
                        $('#pagination').html(response.pagination);
                    }else{
                        $('#pagination').html('');
                    } 

                    initPagination();
                    loadCharts(response);
                }else{
                    $('#charts').html('');
                    $('#pagination').html('');
                    $('#tbody').html(response.data);

                    // validations
                    if(response.errors){
                        var errors = response.errors;

                        if(errors.startDate){
                            $('#startDate > input').addClass('is-invalid');
                            $('#startDateError').html(errors.startDate.message).addClass('text-danger');
                        }

                        if(errors.endDate){
                            $('#endDate > input').addClass('is-invalid');
                            $('#endDateError').html(errors.endDate.message).addClass('text-danger');
                        }
                    }
                }
            },
            error: function (data) {
                console.log(data);
            }
        });    
    }

    function initPagination(){
        $(".pagination a").click(function(event) {
            event.preventDefault();
            
            var options = {
                data: {
                    startDate: $('#startDate > input').val(),
                    endDate: $('#endDate > input').val(),
                },
                method: 'POST',
                url: $(this).attr('href')
            };

            // load feedback with pagination
            loadFeedbacks(options);
        });
    }

    function loadCharts(response){
        $('#charts').html('<div class="row">'+response.chartsHTML+'</div>');

        // loop each questions
        $('.charts').each(function(index, currentChart){
            var chart           = currentChart.getContext('2d');
            var answersLabel    = [];
            var answersCount    = [];
            var backgroundColor = [];
            var borderColor     = [];
            var question_id     = $(this).data('question-id');
            var question        = $(this).data('label');
            
            $(response.chartData).each(function(index, data){
                if(question_id == data.question_id){
                    answersLabel.push(data.answer.name);
                    answersCount.push(data.answer_count);
                    backgroundColor.push(random_color());
                    borderColor.push('rgb(255, 255, 255)');
                }
            });
            
            // init chart with data
            new Chart(chart, {
                type: 'pie',
                data: {
                    labels: answersLabel,
                    datasets: [{
                        fill: true,
                        data: answersCount,
                        backgroundColor: backgroundColor,
                        borderColor: borderColor,
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    title: {
                        display: true,
                        text: question,
                        position: 'bottom'
                    }
                }
            });
        });
    }

    // get random color for chart
    function random_color() {
       return '#'+(0x1000000+(Math.random())*0xffffff).toString(16).substr(1,6);
    }

    $('#filter_button').click(function(){
        loading();
    });

    // show button loading
    function loading(){
        $('.spinner-border').removeClass('d-none');
        $('spinner-border i').addClass('d-none');
    }

    // remove button loading
    function removeLoading(){
        $('.spinner-border').addClass('d-none');
        $('spinner-border i').removeClass('d-none');
    }
</script>
@endsection

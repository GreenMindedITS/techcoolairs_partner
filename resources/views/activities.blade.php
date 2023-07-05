@extends('layouts.app')

@section('third_party_stylesheets')
    <style>
        table#dashboard_jo_table thead th, table#dashboard_jo_table tbody td{
            text-align:center;
            vertical-align: middle;
        }

        @media (max-width:796px){
            table#dashboard_jo_table{
                font-size:0.9rem!important;
            }
        }
    </style>
@endsection

@section('content')        
    <section class="content">
        <div class="container-fluid">
            
            <div class="row mt-4 pb-4">
                <div class="col-md-12 pl-5 pr-5">
                    <div class="card">
                        <div class="card-header p-0">
                            <ul class="nav nav-pills nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link gmis-nav-link active" href="#activity" data-toggle="tab">Transaction History</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link gmis-nav-link" href="#logs" data-toggle="tab">Logs</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <div class="timeline">
                                        @foreach($user_action_history as $action_history)
                                            <div>
                                                <i class="fas fa-circle-alt bg-gmis"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fas fa-clock"></i> {{$action_history->created_at_time}}</span> 
                                                    {{-- timeline-header is created date --}}
                                                    <h3 class="timeline-header">{{$action_history->created_at_date}}</h3>
                                                    {{-- timeline-body is activity/description --}}
                                                    <div class="timeline-body">
                                                        {{$action_history->action_history_activity}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-pane" id="logs">
                                    <div class="timeline">
                                        <div>
                                            <i class="fas fa-circle-alt bg-secondary"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="fas fa-clock"></i> 08:05 AM</span>
                                                <h3 class="timeline-header">April 10, 2023</h3>
                                                <div class="timeline-body">
                                                    Changes to <span class="text-warning">"Logs"</span>.
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <i class="fas fa-circle-alt bg-secondary"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="fas fa-clock"></i> 08:05 AM</span>
                                                <h3 class="timeline-header">April 10, 2023</h3>
                                                <div class="timeline-body">
                                                    Changes to <span class="text-warning">"Logs"</span>.
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <i class="fas fa-circle-alt bg-gmis"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="fas fa-clock"></i> 08:05 AM</span>
                                                <h3 class="timeline-header">April 10, 2023</h3>
                                                <div class="timeline-body">
                                                    Changes to <span class="text-warning">"Logs"</span>.
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <i class="fas fa-circle-alt bg-gmis"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="fas fa-clock"></i> 08:05 AM</span>
                                                <h3 class="timeline-header">April 10, 2023</h3>
                                                <div class="timeline-body">
                                                    Changes to <span class="text-warning">"Logs"</span>.
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <i class="fas fa-circle-alt bg-gmis"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="fas fa-clock"></i> 08:05 AM</span>
                                                <h3 class="timeline-header">April 10, 2023</h3>
                                                <div class="timeline-body">
                                                    Changes to <span class="text-warning">"Logs"</span>.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('third_party_scripts')
    <script type="module">
        
    </script>
@endsection
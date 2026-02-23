@extends('backend.layout.app')

@section('title')
    <title>Calendar — Appointments</title>
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Appointments Calendar</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <div class="stat-card d-flex align-items-center p-3">
                                <div class="stat-icon primary me-3">
                                    <i class="fas fa-calendar-check fa-lg"></i>
                                </div>
                                <div>
                                    <div class="text-muted">Total Appointments</div>
                                    <div class="h4 mb-0">{{ $totalAppointments }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="stat-card d-flex align-items-center p-3">
                                <div class="stat-icon success me-3">
                                    <i class="fas fa-calendar-day fa-lg"></i>
                                </div>
                                <div>
                                    <div class="text-muted">Today's Appointments</div>
                                    <div class="h4 mb-0">{{ $todayAppointments }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="stat-card d-flex align-items-center p-3">
                                <div class="stat-icon warning me-3">
                                    <i class="fas fa-calendar-week fa-lg"></i>
                                </div>
                                <div>
                                    <div class="text-muted">Next 7 Days</div>
                                    <div class="h4 mb-0">{{ $upcomingWeekAppointments }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                </div>
                    <div class="row px-3 mb-3">
                        <div class="col-12">
                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                <span class="d-flex align-items-center">
                                    <span class="rounded-circle me-1" style="width: 12px; height: 12px; background-color: #28a745; display: inline-block;"></span>
                                    <small>Approved</small>
                                </span>
                                <span class="d-flex align-items-center">
                                    <span class="rounded-circle me-1" style="width: 12px; height: 12px; background-color: #ffc107; display: inline-block;"></span>
                                    <small>Pending</small>
                                </span>
                                <span class="d-flex align-items-center">
                                    <span class="rounded-circle me-1" style="width: 12px; height: 12px; background-color: #dc3545; display: inline-block;"></span>
                                    <small>Cancelled</small>
                                </span>
                                <span class="d-flex align-items-center">
                                    <span class="rounded-circle me-1" style="width: 12px; height: 12px; background-color: #007bff; display: inline-block;"></span>
                                    <small>Completed</small>
                                </span>
                                <span class="d-flex align-items-center">
                                    <span class="rounded-circle me-1" style="width: 12px; height: 12px; background-color: #6c757d; display: inline-block;"></span>
                                    <small>Other</small>
                                </span>
                            </div>
                        </div>
                </div>
                    <div id="calendar-placeholder" class="text-center p-5">
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            if (!calendarEl) return;

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek,timeGridDay' },
                events: { url: '{{ route("dashboard.events") }}', method: 'GET' },
                eventDidMount: function(info) {
                    var tooltip = new bootstrap.Tooltip(info.el, {
                        title: info.event.title + ' Start at: ' + info.event.start.toLocaleString(),
                        placement: 'top',
                        trigger: 'hover',
                        container: 'body'
                    });
                }   
            });

            calendar.render();
        });
    </script>
@endpush

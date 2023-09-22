@extends('mpesa.header')

@section('head')
    @parent

    <script src="{{ asset('js/jquery.datetimepicker.js') }}" type="text/javascript"></script>
    <link href="{{ asset('css/jquery.datetimepicker.css') }}" rel="stylesheet" type="text/css"/>
@stop

@section('content')

    <style type="text/css">

        input.time-input {
            width: 100%;
            font-size: 14px !important;
        }

    </style>

    @if ($errors->first('time_log'))
        <div class="alert alert-danger">
            <li>{{ trans('texts.task_errors') }}  </li>
        </div>
    @endif



    <div class="row" onkeypress="formEnterClick(event)">
        <div class="col-md-12">

            <div class="panel panel-default">
                @if($invoice->balance >1)
                <div class="panel-body">
                    <p class="bold">Once you make the payment, refresh this page,</p>
                    <p>How to Pay</p>

                    <ol>
                        <li>Access the Safaricom M-PESA menu on your phone.</li>
                        <li>Go to Lipa na MPESA.</li>
                        <li>Go to Pay Bill.</li>
                        <li>Enter Account Number <span class="bold">4026389</span></li>
                        <li>Enter Account Number : <span class="bold">{{$invoice_number}} </span></li>
                        <li>Enter the invoice amount: <span class="bold">{{ $invoice_balance }}</span></li>
                        <li>Enter PIN and send</li>
                        <li>You will receive payment confirmation through a Short Message.</li>
                        <li>The invoice payment will be automatically update once the payment is received</li>

                    </ol>

                    <br><br>

                    <p class="bold">Pay with MPESA Express</p>
                    <p>To pay with MPESA Express, a pop-up will be sent to your phone with the details of the invoice
                        above</p>
                    <p>Once you enter the pin and send, the payment will be processed and a confirmation message will be
                        sent to you</p>
                    <p class="bold">Use number format: (Format- 254---------)</p>
                    {!! Former::open($url)
           ->addClass('col-lg-10 col-lg-offset-1 warn-on-exit task-form')
           ->onsubmit('return onFormSubmit(event)')
           ->autocomplete('on')
           ->method($method) !!}
                    <?= Former::hidden('invoice_balance1')->value($invoice_balance) ?>
                    {!! Former::hidden('invoice_number', $invoice->invoice_number) !!}
                    {!! Former::number('clientPhone', 'Enter Phone') !!}

                    <div class="pull-right">
                        {!! Button::success('Send Request')->large()->submit() !!}
                    </div>
                    @else
                        <div class="">
                        <p>Payment for this invoice ({{$invoice_number}}) has been received, click the button below to go back to invoices</p>

                            {!! Button::success('Back to invoices')->asLinkTo(url('/').'/client/invoices')->large() !!}

                        </div>

                    @endif
                </div>

            </div>
        </div>

    </div>
    </div>

    {!! Former::close() !!}

    <script type="text/javascript">

        // Add moment support to the datetimepicker
        Date.parseDate = function (input, format) {
            return moment(input, format).toDate();
        };
        Date.prototype.dateFormat = function (format) {
            return moment(this).format(format);
        };

        var timeLabels = {};
        @foreach (['hour', 'minute', 'second'] as $period)
            timeLabels['{{ $period }}'] = '{{ strtolower(trans("texts.{$period}")) }}';
        timeLabels['{{ $period }}s'] = '{{ strtolower(trans("texts.{$period}s")) }}';

        @endforeach

        function tock(startTime) {
            var duration = new Date().getTime() - startTime;
            duration = Math.floor(duration / 100) / 10;
            var str = convertDurationToString(duration);
            $('#duration-text').html(str);

            setTimeout(function () {
                tock(startTime);
            }, 1000);
        }

        function convertDurationToString(duration) {
            var data = [];
            var periods = ['hour', 'minute', 'second'];
            var parts = secondsToTime(duration);

            for (var i = 0; i < periods.length; i++) {
                var period = periods[i];
                var letter = period.charAt(0);
                var value = parts[letter];
                if (!value) {
                    continue;
                }
                period = value == 1 ? timeLabels[period] : timeLabels[period + 's'];
                data.push(value + ' ' + period);
            }

            return data.length ? data.join(', ') : '0 ' + timeLabels['seconds'];
        }

        function submitAction(action, invoice_id) {
            model.refresh();
            var data = [];
            for (var i = 0; i < model.time_log().length; i++) {
                var timeLog = model.time_log()[i];
                if (!timeLog.isEmpty()) {
                    data.push([timeLog.startTime(), timeLog.endTime()]);
                }
            }
            $('#invoice_id').val(invoice_id);
            $('#time_log').val(JSON.stringify(data));
            $('#action').val(action);
            $('.task-form').submit();
        }

        function onDeleteClick() {
            if (confirm({!! json_encode(trans("texts.are_you_sure")) !!})) {
                submitAction('delete');
            }
        }

        function showTimeDetails() {
            $('#datetime-details').fadeIn();
            $('#editDetailsLink').hide();
        }

        function TimeModel(data) {
            var self = this;

            var dateTimeFormat = '{{ $datetimeFormat }}';
            var timezone = '{{ $timezone }}';

            self.startTime = ko.observable(0);
            self.endTime = ko.observable(0);
            self.duration = ko.observable(0);
            self.actionsVisible = ko.observable(false);
            self.isStartValid = ko.observable(true);
            self.isEndValid = ko.observable(true);

            if (data) {
                self.startTime(data[0]);
                self.endTime(data[1]);
            }
            ;

            self.isEmpty = ko.computed(function () {
                return !self.startTime() && !self.endTime();
            });

            self.startTime.pretty = ko.computed({
                read: function () {
                    return self.startTime() ? moment.unix(self.startTime()).tz(timezone).format(dateTimeFormat) : '';
                },
                write: function (data) {
                    self.startTime(moment(data, dateTimeFormat).tz(timezone).unix());
                }
            });

            self.endTime.pretty = ko.computed({
                read: function () {
                    return self.endTime() ? moment.unix(self.endTime()).tz(timezone).format(dateTimeFormat) : '';
                },
                write: function (data) {
                    self.endTime(moment(data, dateTimeFormat).tz(timezone).unix());
                }
            });

            self.setNow = function () {
                self.startTime(moment.tz(timezone).unix());
                self.endTime(moment.tz(timezone).unix());
            }

            self.duration.pretty = ko.computed({
                read: function () {
                    var duration = false;
                    var start = self.startTime();
                    var end = self.endTime();

                    if (start && end) {
                        var duration = end - start;
                    }

                    var duration = moment.duration(duration * 1000);
                    return Math.floor(duration.asHours()) + moment.utc(duration.asMilliseconds()).format(":mm:ss")
                },
                write: function (data) {
                    self.endTime(self.startTime() + convertToSeconds(data));
                }
            });

            /*
            self.duration.pretty = ko.computed(function() {
            }, self);
            */

            self.hideActions = function () {
                self.actionsVisible(false);
            };

            self.showActions = function () {
                self.actionsVisible(true);
            };
        }

        function convertToSeconds(str) {
            if (!str) {
                return 0;
            }
            if (str.indexOf(':') >= 0) {
                return moment.duration(str).asSeconds();
            } else {
                return parseFloat(str) * 60 * 60;
            }
        }

        function loadTimeLog(data) {
            model.time_log.removeAll();
            data = JSON.parse(data);
            for (var i = 0; i < data.length; i++) {
                model.time_log.push(new TimeModel(data[i]));
            }
            model.time_log.push(new TimeModel());
        }

        function ViewModel(data) {
            var self = this;
            self.time_log = ko.observableArray();

            if (data) {
                data = JSON.parse(data.time_log);
                for (var i = 0; i < data.length; i++) {
                    self.time_log.push(new TimeModel(data[i]));
                }
            }
            self.time_log.push(new TimeModel());

            self.removeItem = function (item) {
                self.time_log.remove(item);
                self.refresh();
            }

            self.removeItems = function () {
                self.time_log.removeAll();
                self.refresh();
            }

            self.refresh = function () {
                var hasEmpty = false;
                var lastTime = 0;
                for (var i = 0; i < self.time_log().length; i++) {
                    var timeLog = self.time_log()[i];
                    if (timeLog.isEmpty()) {
                        hasEmpty = true;
                    }
                }
                if (!hasEmpty) {
                    self.addItem();
                }
            }

            self.showTimeOverlaps = function () {
                var lastTime = 0;
                for (var i = 0; i < self.time_log().length; i++) {
                    var timeLog = self.time_log()[i];
                    var startValid = true;
                    var endValid = true;
                    if (!timeLog.isEmpty()) {
                        if (timeLog.startTime() < lastTime || timeLog.startTime() > timeLog.endTime()) {
                            startValid = false;
                        }
                        if (timeLog.endTime() < Math.min(timeLog.startTime(), lastTime)) {
                            endValid = false;
                        }
                        lastTime = Math.max(lastTime, timeLog.endTime());
                    }
                    timeLog.isStartValid(startValid);
                    timeLog.isEndValid(endValid);
                }
            }

            self.addItem = function () {
                self.time_log.push(new TimeModel());
            }
        }

        window.model = new ViewModel({!! $task !!});
        ko.applyBindings(model);

        function onTaskTypeChange() {
            var val = $('input[name=task_type]:checked').val();
            if (val == 'timer') {
                $('#datetime-details').hide();
            } else {
                $('#datetime-details').fadeIn();
            }
            setButtonsVisible();
            if (isStorageSupported()) {
                localStorage.setItem('last:task_type', val);
            }
        }

        function setButtonsVisible() {
            var val = $('input[name=task_type]:checked').val();
            if (val == 'timer') {
                $('#start-button').show();
                $('#save-button').hide();
            } else {
                $('#start-button').hide();
                $('#save-button').show();
            }
        }

        function formEnterClick(event) {
            if (event.keyCode === 13) {
                if (event.target.type == 'textarea') {
                    return;
                }
                event.preventDefault();
                @if ($task && $task->trashed())
                    return;
                @endif
                submitAction('');
                return false;
            }
        }

        $(function () {
            $('input[type=radio]').change(function () {
                onTaskTypeChange();
            })

            setButtonsVisible();

            $('#start-button').click(function () {
                submitAction('start');
            });
            $('#save-button').click(function () {
                submitAction('save');
            });
            $('#stop-button').click(function () {
                submitAction('stop');
            });
            $('#resume-button').click(function () {
                submitAction('resume');
            });

            @if ($task)
            @if ($task->is_running)
            tock({{ $task->getLastStartTime() * 1000 }});
            @endif
            @endif

            @if ($errors->first('time_log'))
            loadTimeLog({!! json_encode(Input::old('time_log')) !!});
            model.showTimeOverlaps();
            showTimeDetails();
            @endif

            $('input.duration').keydown(function (event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });

    </script>


@stop

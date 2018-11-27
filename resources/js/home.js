new Vue({
    el:'#content-wrapper',
    data:{
        topClicks: [],
        topEarnings: [],
        topPaids: [],
        topTrials: [],
        all:[],
        date_from : moment(this.date_to).add(-30, 'day').format('MMM DD, YYYY'),
        date_to   : moment().format('MMM DD, YYYY'),
        show_filter_date_picker: false,
    },
    created: function(){

        this.run_first()

        $('#dataTable').DataTable({
            "destroy": true
        })
    },
    mounted: function(){
        let _this = this
        $('#filter_date_from').datetimepicker({
            widgetParent: '#filter-date-time-picker-from',
            format: 'MMM DD, YYYY',
            keepOpen: true,
            debug: true,
            inline: true,
            sideBySide: true,
            /*maxDate: date.getMonth()+' '+date.getDate()+', '+date.getFullYear()*/
        });

        /*$('#filter_date_from').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });*/

        $('#filter_date_to').datetimepicker({
            widgetParent: '#filter-date-time-picker-to',
            format: 'MMM DD, YYYY',
            keepOpen: true,
            debug: true,
            inline: true,
            sideBySide: true,
            /*maxDate: date.getMonth()+' '+date.getDate()+', '+date.getFullYear()*/
        });

        $("#filter_date_from").on("dp.change", function (e) {
            _this.date_from = e.date.format('MMM DD, YYYY')
            /*_this.chart_loading = true;*/
            // _this.renderChart(_this.date_from, _this.date_to)
            $('#filter_date_to').data("DateTimePicker").minDate(e.date);
        });

        $("#filter_date_to").on("dp.change", function (e) {
            _this.date_to = e.date.format('MMM DD, YYYY')
            /*_this.chart_loading = true;*/
            // _this.renderChart(_this.date_from, _this.date_to)
        });
    },
    methods: {

        run_first:function(){
            this.reportAll()
            this.unique_click()
            this.trial_signup()
            this.paid_conversion()
            this.earning()
        },

        reportAll:function(){
            let _this = this
            axios.get(appUrl+'/report_all?from_date='+ _this.date_from + '&to_date=' + _this.date_to )
                .then(function (res) {
                    console.log(res.data)
                    let { topClick, topEarning, topPaid, topTrial, all } = res.data

                    _this.topClicks = topClick
                    _this.topTrials = topTrial
                    _this.topPaids = topPaid
                    _this.topEarnings = topEarning
                    _this.all = Object.values(all).map(function (item) {
                         item.earning = isNaN(parseFloat(item.earning).toFixed(2)) ? 0 : parseFloat(item.earning).toFixed(2)
                         return item
                    })
                })
        },

        unique_click:function () {
            let _this = this
            axios.get(appUrl+'/unique_click?from_date='+ _this.date_from + '&to_date=' + _this.date_to)
                .then(function (res) {
                    _this.Chart('unique_click',res.data)
                })
        },

        trial_signup:function () {
            let _this = this
            axios.get(appUrl+'/trial_signup?from_date='+ _this.date_from + '&to_date=' + _this.date_to)
                .then(function (res) {
                    _this.Chart('trial_signup',res.data)
                })
        },

        paid_conversion:function(){
            let _this = this
            axios.get(appUrl+'/paid_conversion?from_date='+ _this.date_from + '&to_date=' + _this.date_to)
                .then(function (res) {
                    _this.Chart('paid_conversion',res.data)
                })
        },

        earning: function () {
            let _this = this
            axios.get(appUrl+'/earning?from_date='+ _this.date_from + '&to_date=' + _this.date_to)
                .then(function (res) {
                    console.log(res.data)
                    _this.Chart('earning',res.data)
                })
        },

        Chart:function (type,data) {

            this.resetChart(type);

            var ctx = document.getElementById(type);
            let labels = Object.keys(data)
            let datas = Object.values(data).map(function (obj) {
                return obj.data
            })
            let max = Math.max(...datas)
            max = max < 10 ? 10 : max
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Revenue",
                        backgroundColor: "rgba(2,117,216,1)",
                        borderColor: "rgba(2,117,216,1)",
                        data: datas,
                    }],
                },
                options: {
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'month'
                            },
                            gridLines: {
                                display: false
                            },
                            ticks: {
                                maxTicksLimit: 30
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                min: 0,
                                max: max,
                            },
                            gridLines: {
                                display: true
                            }
                        }],
                    },
                    legend: {
                        display: false
                    }
                }
            });
        },

        showFilterDatePicker: function() {
            if(this.show_filter_date_picker == true)
                this.show_filter_date_picker = false
            else
                this.show_filter_date_picker = true
        },
        filterOrdersDate: function () {
            if(this.show_filter_date_picker == true)
                this.show_filter_date_picker = false
            else
                this.show_filter_date_picker = true
            console.log(this.date_to, this.date_from)
            // this.renderChart(this.date_from, this.date_to)
            this.run_first()
        },
        resetChart:function (type) {
            $('#'+type).remove()
            let adNewId = type.replace('_','-')
            $('.'+adNewId).append('<canvas id="'+type+'" width="100%" height="50"></canvas>')
        }
    }
})
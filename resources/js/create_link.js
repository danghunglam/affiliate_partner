new Vue({
    el:'#create_link',
    data:{
        custom_link : '',
        campaign: '',
        source: '',
        medium: '',
        link: {},
        share_link: ''
    },
    created: function(){
        let _this = this
        axios.get(appUrl+'/getCampaigns')
            .then(function (res) {
                let { data, status } = res
                if(status=200){
                    _this.custom_link = data.custom_url
                    _this.campaign = data.campaign
                    _this.source = data.source
                    _this.medium = data.medium

                    _this.share_link = _this.custom_link
                }
            })
    },
    mounted:function(){


    },
    methods: {
        addLink: function () {
            let _this = this
            let utm_campaign = _this.campaign !='' ? '&utm_campaign=' + _this.campaign : ''
            let utm_source = _this.source !='' ? '&utm_source=' + _this.source : ''
            let utm_medium = _this.medium !='' ? '&utm_medium=' + _this.medium : ''
            _this.share_link = _this.custom_link + utm_campaign + utm_source + utm_medium

        },
        save: function () {
            let _this = this
            axios.post(appUrl+'/saveCampaign',{
                custom_link: _this.share_link,
                campaign: _this.campaign !='' ? _this.campaign : 'default',
                source: _this.source,
                medium: _this.medium
            })
                .then(function (res) {
                    console.log(res.data)
                    if(res.data){
                        notify('success', 'Created')
                    }else{
                        notify('error', 'Campaign is exist')
                    }
                })
        },

        copyClipboard: function(event) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($('#link').val()).select();
            document.execCommand("copy");
            $temp.remove();
        }
    }
})
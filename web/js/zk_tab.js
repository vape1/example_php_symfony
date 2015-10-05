$(function () {
    'use strict';

    var App = {
        init: function () {
            this.tabs();
        },
        tabs: function () {
            var tabId;
            var tabSelector = '#zkTab';
            if('undefined' != typeof window['localStorage']) {
                if ( localStorage.getItem('idTab') ) {
                    tabId = localStorage.getItem('idTab');
                    if ( 'tabajax' == $('#'+tabId).data('toggle') ) {
                        var loadurl = $('#'+tabId).attr('href');
                        var targ = $('#'+tabId).attr('data-target');
                        $.get(loadurl, function(data) {
                            $(targ).html(data);
                        });
                        $('#'+tabId).tab('show');
                    } else {
                        $('#'+tabId).tab('show');
                    }
                } else {
                    $(tabSelector+' a:first').tab('show');
                }
                $(tabSelector+' a').on('click', function (e) {
                    e.preventDefault();
                    $(this).tab('show');
                    localStorage.setItem('idTab', e.currentTarget.id);
                });
            } else {
                $(tabSelector+' a:first').tab('show');
                $('#zkTab a').on('click', function (e) {
                    e.preventDefault();
                    $(this).tab('show');
                });
            }
        }
    };

    App.init();

});
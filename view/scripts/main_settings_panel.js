/**
 * Created by vagenas on 27/12/2014.
 */
/*!
 * Stand-Alone Scripts
 *
 * Copyright: 2014 Panagiotis Vagenas
 *
 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since 150120
 */

/**
 * Just a helper :p
 * @constructor
 */
BSPHelper = function () {

};

/**
 *
 * @type {{generateXMLNow: Function, updateProgressBar: Function}}
 */
BSPHelper.prototype = {

    /**
     * Performs the request to generate the bestprice.xml file
     * @param $modalContainer
     */
    generateXMLNow: function ($modalContainer) {
        var $progressBar = $modalContainer.find('.progress-bar');
        var $genNowBtn = jQuery('.generate-now');

        var progress = 0;

        jQuery.ajax({
            url: ajaxurl,
            dataType: 'json',
            data: {
                'action': 'generateBestpriceXML'
            },
            complete: function (response) {
                var json = response.responseJSON;
                if (json.success != true || json.data.productsUpdated == undefined) {
                    $modalContainer.find('.modal-title').html('<p class="bg-danger">' + json.data + '</p>');
                } else {
                    $modalContainer.find('.modal-title').html('<p class="bg-success">Generation Complete! ' + json.data.productsUpdated + ' products included in XML</p>');
                }
                jQuery('.generate-now').removeClass('disabled');
                $genNowBtn.removeClass('disabled');
                BSPHelper.prototype.updateProgressBar($progressBar, 100);
                //window.clearInterval(interval);
            },
            beforeSend: function () {
                $genNowBtn.addClass('disabled');
            }
        });
        /***********************************************
         * progress bar needs a diferent approach
         ***********************************************/

        //var interval = setInterval(function(){
        //    jQuery.ajax({
        //        url: ajaxurl,
        //        data: {
        //            'action': 'generateBestpriceXMLProgress'
        //        },
        //        complete: function(response, json){
        //            var json = response.responseJSON;
        //            if(json == undefined || json.progress == undefined){
        //                return;
        //            }
        //
        //            if( json.progress > 100 ){
        //                window.clearInterval(interval);
        //                return;
        //            }
        //
        //            BSPHelper.prototype.updateProgressBar($progressBar, response.responseJSON.progress);
        //
        //            if(response.responseJSON.progress > 90) {
        //                window.clearInterval(interval);
        //            }
        //        },
        //        dataType: 'json'
        //    });
        //}, 1000)
    },

    /**
     * Updates the specified bar to the given value
     * @param $bar jQuery
     * @param value integer
     */
    updateProgressBar: function ($bar, value) {
        $bar.prop('aria-valuenow', value).css('width', value + '%');
    },

    copyToClipboard: function (text) {
        window.prompt("Copy to clipboard: Ctrl+C, Enter", text);
    }
};

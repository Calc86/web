<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 24.06.14
 * Time: 12:47
 */

/** @var $cam Cam */

if($cam != null){
    $live_url = $this->createUrl("ajax",array("id"=>$cam->id, $this::GET_TYPE => Cam::LIVE));
    $rec_url = $this->createUrl("ajax",array("id"=>$cam->id, $this::GET_TYPE => Cam::RECORD));
    $mtn_url = $this->createUrl("ajax",array("id"=>$cam->id, $this::GET_TYPE => Cam::MOTION));

    WebYii::app()->clientScript->registerScript('cam', "
        var live_url='$live_url';
        var rec_url='$rec_url';
        var mtn_url='$mtn_url';

        $(document).ready(function(){
        });

        $('.play').click(function(){
            if($(this).hasClass('on')){
                $(this).removeClass('on');
            }else{
                $(this).addClass('on');
                var live = $('#live').html();
                $('#live').html(live);
            }
            $('#status').load(live_url).fadeIn( 400 ).delay(2000).slideUp( 300 );
        });

        $('.rec').click(function(){
            if($(this).hasClass('on')){
                $(this).removeClass('on');
            }else{
                $(this).addClass('on');
            }
            $('#status').load(rec_url).fadeIn( 400 ).delay(2000).slideUp( 300 );
        });

        $('.mtn').click(function(){
            if($(this).hasClass('on')){
                $(this).removeClass('on');
            }else{
                $(this).addClass('on');
            }
            $('#status').load(mtn_url).fadeIn( 400 ).delay(2000).slideUp( 300 );
        });

        function url_me(){
            location.href = $(this).attr('data-href');
        }
        $('.cam').click(url_me);
        $('.settings').click(url_me);

    ");
}

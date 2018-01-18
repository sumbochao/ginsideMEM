<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<div id="content-t" style="min-height: 500px; padding-top: 10px">
    <style>
        #loading {
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            position: fixed;
            display: block;
            z-index: 99;
        }

        #loading-image {
            position: absolute;
            top: 40%;
            left: 45%;
            z-index: 100;
        }

        label {
            width: auto !important;
            color: #f36926;
        }

        .age {
            margin-bottom: 5px;;
        }

        .age input{
            width: 20%;
            display: inline;
        }
    </style>
    <script type="text/javascript">

        $(function() {
            var availableTags = <?php echo $country_name;?>;
            function split( val ) {
                return val.split( /,\s*/ );
            }
            function extractLast( term ) {
                return split( term ).pop();
            }

            $( "#tags-country" )
                // don't navigate away from the field on tab when selecting an item
                .bind( "keydown", function( event ) {
                    if ( event.keyCode === $.ui.keyCode.TAB &&
                        $( this ).autocomplete( "instance" ).menu.active ) {
                        event.preventDefault();
                    }
                })
                .autocomplete({
                    minLength: 0,
                    source: function( request, response ) {
                        // delegate back to autocomplete, but extract the last term
                        response( $.ui.autocomplete.filter(
                            availableTags, extractLast( request.term ) ) );
                    },
                    focus: function() {
                        // prevent value inserted on focus
                        return false;
                    },
                    select: function( event, ui ) {
                        var terms = split( this.value );
                        // remove the current input
                        terms.pop();
                        // add the selected item
                        terms.push( ui.item.value );
                        // add placeholder to get the comma-and-space at the end
                        terms.push( "" );
                        this.value = terms.join( ", " );
                        return false;
                    }
                });
        });


        $(function() {
            var availableTags = <?php echo $locale_name;?>;
            function split( val ) {
                return val.split( /,\s*/ );
            }
            function extractLast( term ) {
                return split( term ).pop();
            }

            $( "#tags-locale" )
                // don't navigate away from the field on tab when selecting an item
                .bind( "keydown", function( event ) {
                    if ( event.keyCode === $.ui.keyCode.TAB &&
                        $( this ).autocomplete( "instance" ).menu.active ) {
                        event.preventDefault();
                    }
                })
                .autocomplete({
                    minLength: 0,
                    source: function( request, response ) {
                        // delegate back to autocomplete, but extract the last term
                        response( $.ui.autocomplete.filter(
                            availableTags, extractLast( request.term ) ) );
                    },
                    focus: function() {
                        // prevent value inserted on focus
                        return false;
                    },
                    select: function( event, ui ) {
                        var terms = split( this.value );
                        // remove the current input
                        terms.pop();
                        // add the selected item
                        terms.push( ui.item.value );
                        // add placeholder to get the comma-and-space at the end
                        terms.push( "" );
                        this.value = terms.join( ", " );
                        return false;
                    }
                });
        });

        $(function() {
            var availableTags = <?php echo $interest_name;?>;
            function split( val ) {
                return val.split( /,\s*/ );
            }
            function extractLast( term ) {
                return split( term ).pop();
            }

            $( "#tags-interest" )
                // don't navigate away from the field on tab when selecting an item
                .bind( "keydown", function( event ) {
                    if ( event.keyCode === $.ui.keyCode.TAB &&
                        $( this ).autocomplete( "instance" ).menu.active ) {
                        event.preventDefault();
                    }
                })
                .autocomplete({
                    minLength: 0,
                    source: function( request, response ) {
                        // delegate back to autocomplete, but extract the last term
                        response( $.ui.autocomplete.filter(
                            availableTags, extractLast( request.term ) ) );
                    },
                    focus: function() {
                        // prevent value inserted on focus
                        return false;
                    },
                    select: function( event, ui ) {
                        var terms = split( this.value );
                        // remove the current input
                        terms.pop();
                        // add the selected item
                        terms.push( ui.item.value );
                        // add placeholder to get the comma-and-space at the end
                        terms.push( "" );
                        this.value = terms.join( ", " );
                        return false;
                    }
                });
        });

        $(document).ready(function () {

            $("#start_time").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
            $("#end_time").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });

            $('#add-age').click(function () {
                var age = $('.age:last').clone().insertAfter('.age:last');
            });

            $('#remove-age').click(function () {
                if($('.age').length > 1){
                    var age = $('.age:last').remove();
                }

            });

            $('.rdo_age').click(function(){
                if($(this).val() == 'split'){
                    $('#add-age').show();
                    $('#remove-age').show();
                }else if($(this).val() == 'any'){
                    $('#add-age').hide();
                    $('#remove-age').hide();
                }

            });


            //load user os follow campaign
            var platform = $(this).find('option:selected').attr('platform');
            if(platform == 'itunes'){
                var html = '<option selected value="iOS">iOS</option> <option value="iOS_ver_8.0_to_9.0">iOS_ver_8.0_to_9.0</option>';
                $('#user_os').html(html);
            }else if(platform == 'google_play'){
                var html = '<option selected value="Android_ver_4.2_and_above">Android_ver_4.2_and_above</option>';
                $('#user_os').html(html);
            }
            $('select[name=campaign]').change(function(){
                var option = $(this).find('option:selected');
                platform = option.attr('platform');

                if(platform == 'itunes'){
                    var html = '<option selected value="iOS">iOS</option> <option value="iOS_ver_8.0_to_9.0">iOS_ver_8.0_to_9.0</option>';
                    $('#user_os').html(html);
                }else if(platform == 'google_play'){
                    var html = '<option selected value="Android_ver_4.2_and_above">Android_ver_4.2_and_above</option>';
                    $('#user_os').html(html);
                }
            });

            $('#comeback').on('click', function () {
                window.history.go(-1);
                return false;
            });


            $('#onSubmit').click(function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $(".loading").fadeIn("fast");
                $('#frmSendChest').ajaxForm(function (data) {
                    $(".modal-body #messgage").html(data);
                    $('.bs-example-modal-sm').modal('show');
                    $('#frmSendChest').clearForm();
                    $(".loading").fadeOut("fast");
                });
            });

        });
    </script>
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include 'tab.php'; ?>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form id="frmSendChest" action="/?control=facebook_ads&func=createTargeting&module=all" method="POST"
                              enctype="multipart/form-data">
                            <div class="well form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Select Campaign</label>

                                    <div class="col-sm-10">
                                        <select name="campaign" id="campaign" class="form-control">
                                            <?php foreach($campaigns as $camp):?>
                                            <option platform="<?php echo $camp['platform'];?>" objective="<?php echo $camp['objective'];?>" value="<?php echo $camp['id'];?>"><?php echo $camp['name'];?></option>
                                            <?php endforeach?>
                                        </select>
                                    </div>

                                </div>


                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Adset Information</h3>
                                    </div>

                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Name</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="ads_name" />
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Daily Budge</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="ads_daily_budge" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Bid Amount</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="ads_bid_amount" />
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Optimization Goals</label>
                                            <div class="col-sm-10">
                                                <select name="ads_optimization_goals" class="form-control">
                                                    <?php foreach($goals as $goal):?>
                                                    <option value="<?php echo $goal;?>"><?php echo $goal;?></option>
                                                    <?php endforeach?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Billing Event</label>
                                            <div class="col-sm-10">
                                                <select name="ads_billing_event" class="form-control">
                                                    <?php foreach($billings as $b):?>
                                                    <option <?php if($b == 'IMPRESSIONS') echo 'selected';?> value="<?php echo $b;?>"><?php echo $b;?></option>
                                                    <?php endforeach?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Start Time</label>
                                            <div class="col-sm-10">
                                                <div id="start_time" name="start_time"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">End Time</label>
                                            <div class="col-sm-10">
                                                <div id="end_time" name="end_time"></div>
                                            </div>
                                        </div>


                                    </div>
                                </div>


                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Device</h3>
                                    </div>

                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Placement</label>

                                            <div class="col-sm-10">
                                                <select multiple name="placement[]" id="placement" class="form-control">
                                                    <option selected value="mobilefeed">Mobile Feed</option>
                                                    <option value="instagramstream">Instagram Stream</option>
                                                    <option value="mobileexternal">Mobile External</option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">User OS</label>
                                            <div class="col-sm-10">
                                                <select multiple name="user_os[]" id="user_os" class="form-control">
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Location</h3>
                                    </div>

                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Location</label>
                                            <div class="col-sm-7">
                                                <div class="ui-widget">
                                                    <input name="tags_country" class="form-control" id="tags-country">
                                                </div>

                                            </div>
                                            <div class="col-sm-3">
                                                <label class = "checkbox-inline">
                                                    <input type = "radio" name = "rdo_location" value = "any" checked> any
                                                </label>

                                                <label class = "checkbox-inline">
                                                    <input type = "radio" name = "rdo_location" value = "split"> split
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Languages</label>
                                            <div class="col-sm-7">
                                                <div class="ui-widget">
                                                    <input class="form-control" id="tags-locale" name="tags_locale">
                                                </div>

                                            </div>
                                            <div class="col-sm-3">
                                                <label class = "checkbox-inline">
                                                    <input type = "radio" name = "rdo_lang" value = "any" checked> any
                                                </label>

                                                <label class = "checkbox-inline">
                                                    <input type = "radio" name = "rdo_lang" value = "split"> split
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Age and Gender</h3>
                                    </div>

                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Age(inclusive)</label>
                                            <div class="col-sm-3">
                                                <div class="age">
                                                    <input class="form-control" name="start_age[]"> -
                                                    <input  class="form-control" name="end_age[]">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <button style="display: none;" type="button" id="add-age" class="btn btn-primary" >Add Age</button>
                                                <button style="display: none;" type="button" id="remove-age" class="btn btn-primary" >Remove Age</button>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class = "checkbox-inline">
                                                    <input class="rdo_age" type = "radio" name = "rdo_age" value = "any" checked> any
                                                </label>

                                                <label class = "checkbox-inline">
                                                    <input class="rdo_age" type = "radio" name = "rdo_age" value = "split"> split
                                                </label>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Gender</label>
                                            <div class="col-sm-7">
                                                <label class = "checkbox-inline">
                                                    <input type = "radio" name = "rdo_sex" value = "" checked> All
                                                </label>

                                                <label class = "checkbox-inline">
                                                    <input  type = "radio" name = "rdo_sex" value = "1"> Male
                                                </label>

                                                <label class = "checkbox-inline">
                                                    <input  type = "radio" name = "rdo_sex" value = "2"> Female
                                                </label>

                                            </div>
                                            <div class="col-sm-3">
                                                <label class = "checkbox-inline">
                                                    <input type = "radio" name = "radio_sex" value = "any" checked> any
                                                </label>

                                                <label class = "checkbox-inline">
                                                    <input type = "radio" name = "radio_sex" value = "split"> split
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Interest</h3>
                                    </div>

                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Interest</label>
                                            <div class="col-sm-7">
                                                <div class="ui-widget">
                                                    <input class="form-control" id="tags-interest" name="tags_interest">
                                                </div>

                                            </div>
                                            <div class="col-sm-3">
                                                <label class = "checkbox-inline">
                                                    <input type = "radio" name = "rdo_interest" value = "any" checked> any
                                                </label>

                                                <label class = "checkbox-inline">
                                                    <input type = "radio" name = "rdo_interest" value = "split"> split
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-7 pull-right">
                                        <button class="btn btn-primary">CREATE</button>
                                    </div>
                                </div>


                            </div>
                            <input type="hidden" name="operating_system" id="operating_system" value="">
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>

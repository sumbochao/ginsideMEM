<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
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

            $('#comeback').on('click', function () {
                window.history.go(-1);
                return false;
            });

            //Set DateTime Format
            $("#start_time").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
            $("#stop_time").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });

            var start_time = '<?php echo $campaign["start_time"]; ?>';
            $('#start_time').jqxDateTimeInput('setDate', start_time);
            var stop_time = '<?php echo $campaign["stop_time"];; ?>';
            $('#stop_time').jqxDateTimeInput('setDate', stop_time);

        });
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include 'tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form id="frmSendChest" action="/?control=facebook_ads&func=updateTargeting&module=all#campaign" method="POST"
                              enctype="multipart/form-data">
                            <div class="well form-horizontal">

                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Device</h3>
                                    </div>

                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Placement</label>

                                            <div class="col-sm-10">
                                                <select multiple name="placement[]" id="placement" class="form-control">
                                                    <option <?php if(in_array('mobilefeed',$page_types)) echo 'selected';?> value="mobilefeed">Mobile Feed</option>
                                                    <option <?php if(in_array('instagramstream',$page_types)) echo 'selected';?> value="instagramstream">Instagram Stream</option>
                                                    <option <?php if(in_array('mobileexternal',$page_types)) echo 'selected';?> value="mobileexternal">Mobile External</option>
                                                </select>
                                            </div>

                                        </div>

<!--                                        <div class="form-group">-->
<!--                                            <label class="col-sm-2 control-label">User OS</label>-->
<!--                                            <div class="col-sm-10">-->
<!--                                                <select multiple name="user_os[]" id="user_os" class="form-control">-->
<!--                                                </select>-->
<!--                                            </div>-->
<!---->
<!--                                        </div>-->
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
                                                    <input name="tags_country" class="form-control" id="tags-country" value="<?php echo $country_string;?>" >
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Languages</label>
                                            <div class="col-sm-7">
                                                <div class="ui-widget">
                                                    <input class="form-control" id="tags-locale" name="tags_locale" value="<?php echo $locale_string;?>">
                                                </div>

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
                                                    <input  class="form-control" name="age_min" value="<?php echo $targeting['age_min']?>"> -
                                                    <input class="form-control" name="age_max" value="<?php echo $targeting['age_max']?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Gender</label>
                                            <div class="col-sm-7">
                                                <label class = "checkbox-inline">
                                                    <input type = "radio" name = "rdo_sex" value = "" <?php if($targeting['genders'] == '') echo 'checked';?> > All
                                                </label>

                                                <label class = "checkbox-inline">
                                                    <input  type = "radio" name = "rdo_sex" value = "1" <?php if($targeting['genders'] == 1) echo 'checked';?>> Male
                                                </label>

                                                <label class = "checkbox-inline">
                                                    <input  type = "radio" name = "rdo_sex" value = "2" <?php if($targeting['genders'] == 2) echo 'checked';?>> Female
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
                                                    <input class="form-control" id="tags-interest" name="tags_interest" value="<?php echo $interest_string;?>">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-8 pull-right">
                                        <button id="comeback" class="btn btn-primary" type="button">Back</button>
                                        <button id="onSubmit" class="btn btn-primary" type="submit">Submit</button>
                                        <input type="hidden" name="id" value="<?php echo $id;?>">
                                        <input type="hidden" name="campaign_id" value="<?php echo $campaign_id;?>">
                                    </div>
                                </div>


                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>

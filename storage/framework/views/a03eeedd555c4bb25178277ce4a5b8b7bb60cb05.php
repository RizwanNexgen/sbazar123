
<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> <?php echo e(trans('labels.Setting')); ?><small><?php echo e(trans('labels.Setting')); ?>...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('labels.breadcrumb_dashboard')); ?></a></li>
            <li class="active"><?php echo e(trans('labels.Setting')); ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo e(trans('labels.Setting')); ?></h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <!--<div class="box-header with-border">
                                          <h3 class="box-title">Setting</h3>
                                        </div>-->
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <div class="box-body">
                                        <?php if( count($errors) > 0): ?>
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="alert alert-success" role="alert">
                                            <span class="icon fa fa-check" aria-hidden="true"></span>
                                            <span class="sr-only"><?php echo e(trans('labels.Setting')); ?>:</span>
                                            <?php echo e($error); ?></div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>

                                        <?php echo Form::open(array('url' =>'admin/updateSetting', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')); ?>

                                        <h4><?php echo e(trans('labels.generalSetting')); ?></h4>
                                        <hr>
                                        <div class="form-group">
                                       		<label class="col-sm-2 col-md-3 control-label" style=""><?php echo e(trans('labels.Web/App Environment')); ?></label>
                                            <div class="col-sm-10 col-md-4">
                                                <label class=" control-label">
                                                      <input type="radio" name="environment" value="Maintenance" class="flat-red" <?php if($result['commonContent']['setting']['environment'] == 'Maintenance'): ?> checked <?php endif; ?> > &nbsp;<?php echo e(trans('labels.Maintenance')); ?>

                                                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                <label class=" control-label">
                                                      <input type="radio" name="environment" value="production" class="flat-red" <?php if($result['commonContent']['setting']['environment'] == 'production'): ?> checked <?php endif; ?> >  &nbsp;<?php echo e(trans('labels.production')); ?>

                                                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                <label class=" control-label">
                                                      <input type="radio" name="environment" value="local" class="flat-red" <?php if($result['commonContent']['setting']['environment'] == 'local'): ?> checked <?php endif; ?> >  &nbsp;<?php echo e(trans('labels.local')); ?>

                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                       		<label class="col-sm-2 col-md-3 control-label" style=""><?php echo e(trans('labels.Inventory')); ?></label>
                                            <div class="col-sm-10 col-md-4">
                                                <label class=" control-label">
                                                      <input type="radio" name="Inventory" value="1" class="flat-red" <?php if($result['commonContent']['setting']['Inventory'] == '1'): ?> checked <?php endif; ?> > &nbsp;<?php echo e(trans('labels.Enabled')); ?>

                                                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                <label class=" control-label">
                                                      <input type="radio" name="Inventory" value="0" class="flat-red" <?php if($result['commonContent']['setting']['Inventory'] == '0'): ?> checked <?php endif; ?> >  &nbsp;<?php echo e(trans('labels.Disabled')); ?>

                                                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </div>
                                        </div>

                                       
                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Maintenance Text')); ?></label>
                                          <div class="col-sm-10 col-md-4">
                                            <?php echo Form::text('maintenance_text',  stripslashes($result['commonContent']['setting']['maintenance_text']), array('class'=>'form-control', 'id'=>'maintenance_text')); ?>

                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.Maintenance Text detail')); ?></span>
                                          </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.website Link')); ?></label>
                                            <div class="col-sm-10 col-md-4">
                                                <?php echo Form::text('external_website_link', $result['commonContent']['setting']['external_website_link'], array('class'=>'form-control', 'id'=>'external_website_link')); ?>

                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.Website Link Text')); ?></span>
                                            </div>
                                        </div>
                                       
                                        <?php if($result['commonContent']['setting']['facebook_callback_url'] ==1 ): ?>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Android App Link')); ?></label>
                                            <div class="col-sm-10 col-md-4">
                                                <?php echo Form::text('android_app_link',$result['commonContent']['setting']['android_app_link'], array('class'=>'form-control', 'id'=>'android_app_link')); ?>

                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.Android App Link')); ?></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Iphone App Link')); ?></label>
                                            <div class="col-sm-10 col-md-4">
                                                <?php echo Form::text('iphone_app_link',$result['commonContent']['setting']['iphone_app_link'], array('class'=>'form-control', 'id'=>'iphone_app_link')); ?>

                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.Iphone App Link')); ?></span>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.AppName')); ?></label>
                                            <div class="col-sm-10 col-md-4">
                                                <?php echo Form::text('app_name', $result['commonContent']['setting']['app_name'], array('class'=>'form-control', 'id'=>'app_name')); ?><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.AppNameText')); ?></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.NewProductDuration')); ?></label>
                                            <div class="col-sm-10 col-md-4">
                                                <?php echo Form::text('new_product_duration', $result['commonContent']['setting']['new_product_duration'], array('class'=>'form-control', 'id'=>'new_product_duration')); ?><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.NewProductDurationText')); ?></span>
                                            </div>
                                        </div>

                                        <!--<hr>
                                        <h4>Points Settings</h4>
                                        <hr>-->
                                        
                                        <!--<div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Welcome Bonus</label>
                                            <div class="col-sm-10 col-md-4">
                                                <?php echo Form::text('points_welcome_bonus', $result['commonContent']['setting']['points_welcome_bonus'], array('class'=>'form-control', 'id'=>'points_welcome_bonus')); ?>

                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                                    When new user register 
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Profile Completion</label>
                                            <div class="col-sm-10 col-md-4">
                                                <?php echo Form::text('points_profile_finish', $result['commonContent']['setting']['points_profile_finish'], array('class'=>'form-control', 'id'=>'points_profile_finish')); ?>

                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                                    When user completed profile
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Birthday Gift</label>
                                            <div class="col-sm-10 col-md-4">
                                                <?php echo Form::text('points_birthday', $result['commonContent']['setting']['points_birthday'], array('class'=>'form-control', 'id'=>'points_birthday')); ?>

                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                                    On user birthday, system will send automatic greeting with points
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Referral Purchase (%)</label>
                                            <div class="col-sm-10 col-md-4">
                                                <?php echo Form::text('points_ref_commission_rate', $result['commonContent']['setting']['points_ref_commission_rate'], array('class'=>'form-control', 'id'=>'points_ref_commission_rate')); ?>

                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                                    When referred user purchase item from shop
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Writing review or rating app</label>
                                            <div class="col-sm-10 col-md-4">
                                                <?php echo Form::text('points_review_post', $result['commonContent']['setting']['points_review_post'], array('class'=>'form-control', 'id'=>'points_review_post')); ?>

                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                                    When user write a review or rating app
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Points Settings</label>
                                            <div class="col-sm-10 col-md-4">
                                                <label class=" control-label" style="margin-right:10px;">
                                                      <input type="radio" name="points_system_enabled" value="Y" class="flat-red" <?php if($result['commonContent']['setting']['points_system_enabled'] == 'Y'): ?> checked <?php endif; ?> > Enabled
                                                </label>
                                                <label class=" control-label">
                                                      <input type="radio" name="points_system_enabled" value="N" class="flat-red" <?php if($result['commonContent']['setting']['points_system_enabled'] == 'N'): ?> checked <?php endif; ?> >  Disabled
                                                </label>
                                            </div>
                                        </div>-->

                                        <hr>
                                        <h4><?php echo e(trans('labels.InqueryEmails')); ?></h4>
                                        <hr>

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.ContactUsEmail')); ?></label>
                                            <div class="col-sm-10 col-md-4">
                                                <?php echo Form::text('contact_us_email', $result['commonContent']['setting']['contact_us_email'], array('class'=>'form-control', 'id'=>'contact_us_email')); ?><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                                    <?php echo e(trans('labels.ContactUsEmailText')); ?></span>
                                            </div>
                                        </div>

                                        <hr>
                                        <h4><?php echo e(trans('labels.OrderEmail')); ?></h4>
                                        <hr>

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.OrderEmail')); ?></label>
                                            <div class="col-sm-10 col-md-4">
                                                <?php echo Form::text('order_email', $result['commonContent']['setting']['order_email'], array('class'=>'form-control', 'id'=>'order_email')); ?><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                                    <?php echo e(trans('labels.OrderEmailText')); ?></span>
                                            </div>
                                        </div>

                                        <hr>
                                        <h4><?php echo e(trans('labels.Orders')); ?></h4>
                                        <hr>
                                        

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Min Order Price')); ?></label>
                                            <div class="col-sm-10 col-md-4">
                                                <?php echo Form::text('min_order_price',$result['commonContent']['setting']['min_order_price'], array('class'=>'form-control', 'id'=>'min_order_price')); ?>

                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                                    <?php echo e(trans('labels.Min Order Price Text')); ?></span>
                                            </div>
                                        </div>

                                        <hr>
                                        <h4><?php echo e(trans('labels.OurInfo')); ?></h4>
                                        <hr>
                                       
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.PhoneNumber')); ?></label>
                                            <div class="col-sm-10 col-md-4">
                                                <?php echo Form::text('phone_no', $result['commonContent']['setting']['phone_no'], array('class'=>'form-control', 'id'=>'phone_no')); ?><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                                    <?php echo e(trans('labels.PhoneNumberText')); ?></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Address')); ?></label>
                                            <div class="col-sm-10 col-md-4">
                                                <?php echo Form::text('address', $result['commonContent']['setting']['address'], array('class'=>'form-control', 'id'=>'address')); ?><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.AddressText')); ?></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.City')); ?></label>
                                            <div class="col-sm-10 col-md-4">
                                                <?php echo Form::text('city', $result['commonContent']['setting']['city'], array('class'=>'form-control', 'id'=>'city')); ?><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.CityText')); ?></span>
                                            </div>
                                        </div>

                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.State')); ?></label>
                                            <div class="col-sm-10 col-md-4">
                                                <?php echo Form::text('state', $result['commonContent']['setting']['state'], array('class'=>'form-control', 'id'=>'state')); ?><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.StateText')); ?></span>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Zip')); ?></label>
                                            <div class="col-sm-10 col-md-4">
                                                <?php echo Form::text('zip', $result['commonContent']['setting']['zip'], array('class'=>'form-control', 'id'=>'zip')); ?><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.ZipText')); ?></span>
                                            </div>
                                        </div>
                                       
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Country')); ?></label>
                                            <div class="col-sm-10 col-md-4">
                                                <?php echo Form::text('country', $result['commonContent']['setting']['country'], array('class'=>'form-control', 'id'=>'country')); ?><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.CountryContactUs')); ?></span>
                                            </div>
                                        </div>
                                       


                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Latitude')); ?></label>
                                            <div class="col-sm-10 col-md-4">
                                                <?php echo Form::text('latitude', $result['commonContent']['setting']['latitude'], array('class'=>'form-control', 'id'=>'latitude')); ?><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.latitudeText')); ?></span>
                                            </div>
                                        </div>
                                       
                                       
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Longitude')); ?></label>
                                            <div class="col-sm-10 col-md-4">
                                                <?php echo Form::text('longitude', $result['commonContent']['setting']['longitude'], array('class'=>'form-control', 'id'=>'longitude')); ?><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.LongitudeText')); ?></span>
                                            </div>
                                        </div>
                                        
                                        <!--Search Tags-->
                                        <hr>
                                        <h4>Search Tags</h4>
                                        <hr>
    
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Search Tags</label>
                                            <div class="col-sm-10 col-md-4">
                                                <?php echo Form::text('search_tags', $result['commonContent']['setting']['search_tags'], array('class'=>'form-control', 'id'=>'search_tags')); ?><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 1px;">
                                                    Ex. Tag1,Tag2,Tag3      [N.B. No space betweeen tags and no ending comma]</span>
                                            </div>
                                        </div>

                                    </div>
                                    
                                    



                                    <!-- /.box-body -->
                                    <div class="box-footer text-center">
                                        <button type="submit" class="btn btn-primary"><?php echo e(trans('labels.Submit')); ?></button>
                                        <a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>" type="button" class="btn btn-default"><?php echo e(trans('labels.back')); ?></a>
                                    </div>

                                    <!-- /.box-footer -->
                                    <?php echo Form::close(); ?>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->

        <!-- /.row -->

        <!-- Main row -->

        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/app/current/resources/views/admin/settings/general/setting.blade.php ENDPATH**/ ?>
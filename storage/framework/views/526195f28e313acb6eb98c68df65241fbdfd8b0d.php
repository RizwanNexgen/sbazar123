
<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> <?php echo e(trans('labels.application_settings')); ?> <small><?php echo e(trans('labels.application_settings')); ?>...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('labels.breadcrumb_dashboard')); ?></a></li>
                <li class="active"><?php echo e(trans('labels.application_settings')); ?></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->

            <!-- /.row -->

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"><?php echo e(trans('labels.application_settings')); ?> </h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info">
                                        <!-- /.box-header -->
                                        <!-- form start -->
                                        <div class="box-body">
                                            <?php if( count($errors) > 0): ?>
                                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="alert alert-success" role="alert">
                                                        <span class="icon fa fa-check" aria-hidden="true"></span>
                                                        <span class="sr-only"><?php echo e(trans('labels.Setting')); ?>:</span>
                                                        <?php echo e($error); ?>

                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>

                                            <?php echo Form::open(array('url' =>'admin/updateSetting', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')); ?>

                                            <h4><?php echo e(trans('labels.generalSetting')); ?> </h4>
                                            <hr>

                                            

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.homeStyle')); ?>


                                                </label>
                                                
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="home_style" class="form-control">
                                                    
                                                    
                                                        <option <?php if($result['commonContent']['setting']['home_style'] == '1'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="1"> <?php echo e(trans('labels.Style1')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['home_style'] == '2'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="2"> <?php echo e(trans('labels.Style2')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['home_style'] == '3'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="3"> <?php echo e(trans('labels.Style3')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['home_style'] == '4'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="4"> <?php echo e(trans('labels.Style4')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['home_style'] == '5'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="5"> <?php echo e(trans('labels.Style5')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['home_style'] == '6'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="6"> <?php echo e(trans('labels.Style6')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['home_style'] == '7'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="7"> <?php echo e(trans('labels.Style 7')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['home_style'] == '8'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="8"> <?php echo e(trans('labels.Style 8')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['home_style'] == '9'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="9"> <?php echo e(trans('labels.Style 9')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['home_style'] == '10'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="10"> <?php echo e(trans('labels.Style 10')); ?></option>


                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.homeStyleText')); ?></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Card Style')); ?>


                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="card_style" id="card_style" class="form-control">
                                                  
                                                        <option <?php if($result['commonContent']['setting']['card_style'] == '1'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="1"> <?php echo e(trans('labels.Style1')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['card_style'] == '2'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="2"> <?php echo e(trans('labels.Style2')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['card_style'] == '3'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="3"> <?php echo e(trans('labels.Style3')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['card_style'] == '4'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="4"> <?php echo e(trans('labels.Style4')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['card_style'] == '5'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="5"> <?php echo e(trans('labels.Style5')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['card_style'] == '6'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="6"> <?php echo e(trans('labels.Style6')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['card_style'] == '7'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="7"> <?php echo e(trans('labels.Style 7')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['card_style'] == '8'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="8"> <?php echo e(trans('labels.Style 8')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['card_style'] == '9'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="9"> <?php echo e(trans('labels.Style 9')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['card_style'] == '10'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="10"> <?php echo e(trans('labels.Style 10')); ?></option>

                                                        <option <?php if($result['commonContent']['setting']['card_style'] == '11'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="11"> <?php echo e(trans('labels.Style 11')); ?></option>

                                                        <option <?php if($result['commonContent']['setting']['card_style'] == '12'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="12"> <?php echo e(trans('labels.Style 12')); ?></option>

                                                        <option <?php if($result['commonContent']['setting']['card_style'] == '13'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="13"> <?php echo e(trans('labels.Style 13')); ?></option>

                                                        <option <?php if($result['commonContent']['setting']['card_style'] == '14'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="14"> <?php echo e(trans('labels.Style 14')); ?></option>

                                                        <option <?php if($result['commonContent']['setting']['card_style'] == '15'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="15"> <?php echo e(trans('labels.Style 15')); ?></option>

                                                        <option <?php if($result['commonContent']['setting']['card_style'] == '16'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="16"> <?php echo e(trans('labels.Style 16')); ?></option>

                                                        <option <?php if($result['commonContent']['setting']['card_style'] == '17'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="17"> <?php echo e(trans('labels.Style 17')); ?></option>

                                                        <option <?php if($result['commonContent']['setting']['card_style'] == '18'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="18"> <?php echo e(trans('labels.Style 18')); ?></option>

                                                        <option <?php if($result['commonContent']['setting']['card_style'] == '19'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="19"> <?php echo e(trans('labels.Style 19')); ?></option>

                                                        <option <?php if($result['commonContent']['setting']['card_style'] == '20'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="20"> <?php echo e(trans('labels.Style 20')); ?></option>

                                                        <option <?php if($result['commonContent']['setting']['card_style'] == '21'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="21"> <?php echo e(trans('labels.Style 21')); ?></option>

                                                        <option <?php if($result['commonContent']['setting']['card_style'] == '22'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="22"> <?php echo e(trans('labels.Style 22')); ?></option>
                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.Please choose card style')); ?></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Banner Style')); ?>


                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                
                                                    <select name="banner_style" class="form-control">
                                                        <option <?php if($result['commonContent']['setting']['banner_style'] == '1'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="1"> <?php echo e(trans('labels.Style1')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['banner_style'] == '2'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="2"> <?php echo e(trans('labels.Style2')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['banner_style'] == '3'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="3"> <?php echo e(trans('labels.Style3')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['banner_style'] == '4'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="4"> <?php echo e(trans('labels.Style4')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['banner_style'] == '5'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="5"> <?php echo e(trans('labels.Style5')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['banner_style'] == '6'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="6"> <?php echo e(trans('labels.Style6')); ?></option>
                                                       
                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.Please choose banner style')); ?></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.categoryStyle')); ?></label>
                                                <div class="col-sm-10 col-md-4">
                                                
                                                
                                                    <select name="category_style" class="form-control">
                                                        <option <?php if($result['commonContent']['setting']['category_style']  == '1'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="1"> <?php echo e(trans('labels.categories1')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['category_style']  == '2'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="2"> <?php echo e(trans('labels.categories2')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['category_style']  == '3'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="3"> <?php echo e(trans('labels.categories3')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['category_style']  == '4'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="4"> <?php echo e(trans('labels.categories4')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['category_style']  == '5'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="5"> <?php echo e(trans('labels.categories5')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['category_style']  == '6'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="6"> <?php echo e(trans('labels.categories6')); ?></option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.categoryStyleText')); ?></span>
                                                </div>
                                            </div>
                                        
                                            
                                            <div class="form-group android-hide"id="cart1style" <?php if($result['commonContent']['setting']['card_style'] != '1'): ?>
                                                style="display: none"
                                                <?php endif; ?>>
                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.DisplayCartButton')); ?>


                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                               
                                                
                                                    <select name="cart_button" class="form-control">
                                                    
                                                        <option <?php if($result['commonContent']['setting']['cart_button'] == '1'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="1"> <?php echo e(trans('labels.Show')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['cart_button'] == '0'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="0"> <?php echo e(trans('labels.Hide')); ?></option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.DisplayCartButtonText')); ?></span>
                                                </div>
                                            </div>

                                            <div class="form-group android-hide">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.packageName')); ?>


                                                </label>
                                                
                                                <div class="col-sm-10 col-md-4">
                                                    <?php echo Form::text('share_app_url',  $result['commonContent']['setting']['share_app_url'], array('class'=>'form-control', 'id'=>'share_app_url')); ?>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.packageNameText')); ?></span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group android-hide">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">Welcome Background</label>                                                
                                                <div class="col-sm-10 col-md-4">
                                                    <input type="file" name="welcome_background" class="form-control" />
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                                        <?php if(!empty($result['commonContent']['setting']['app_welcome_background'])): ?>
                                                            <a href="<?php echo e(asset('storage/app/welcome/'.$result['commonContent']['setting']['app_welcome_background'])); ?>" target="_blank"><?php echo e(asset('storage/app/welcome/'.$result['commonContent']['setting']['app_welcome_background'])); ?></a>
                                                        <?php else: ?> 
                                                            Upload Image or Video Background for Welcome Screen
                                                        <?php endif; ?>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="form-group android-hide">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">Splash Background</label>                                                
                                                <div class="col-sm-10 col-md-4">
                                                    <input type="file" name="splash_background" class="form-control" />
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                                        <?php if(!empty($result['commonContent']['setting']['app_splash_background'])): ?>
                                                            <a href="<?php echo e(asset('storage/app/splash/'.$result['commonContent']['setting']['app_splash_background'])); ?>" target="_blank"><?php echo e(asset('storage/app/splash/'.$result['commonContent']['setting']['app_splash_background'])); ?></a>
                                                        <?php else: ?> 
                                                            Upload Image or Video Background for Splash Screen
                                                        <?php endif; ?>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="form-group android-hide"  style="display: none">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.googleAnalyticId')); ?>


                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                

                                                
                                                    <?php echo Form::text('google_analytic_id',  $result['commonContent']['setting']['google_analytic_id'], array('class'=>'form-control', 'id'=>'google_analytic_id')); ?>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.googleAnalyticIdText')); ?></span>
                                                </div>
                                            </div>

                                            <div class="form-group android-hide" style="display: none">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.LazzyLoadingEffect')); ?>


                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                               
                                                    <select name="lazzy_loading_effect" class="form-control">
                                                   
                                                        <option
                                                                <?php if( $result['commonContent']['setting']['lazzy_loading_effect'] == 'android'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="android"> <?php echo e(trans('labels.Android')); ?></option>
                                                        <option
                                                                <?php if( $result['commonContent']['setting']['lazzy_loading_effect'] == 'ios-small'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="ios-small"> <?php echo e(trans('labels.IOSSmall')); ?></option>
                                                        <option
                                                                <?php if( $result['commonContent']['setting']['lazzy_loading_effect'] == 'bubbles'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="bubbles"> <?php echo e(trans('labels.Bubbles')); ?></option>
                                                        <option
                                                                <?php if( $result['commonContent']['setting']['lazzy_loading_effect'] == 'circles'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="circles"> <?php echo e(trans('labels.Circles')); ?></option>
                                                        <option
                                                                <?php if( $result['commonContent']['setting']['lazzy_loading_effect'] == 'crescent'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="crescent"> <?php echo e(trans('labels.Crescent')); ?></option>
                                                        <option
                                                                <?php if( $result['commonContent']['setting']['lazzy_loading_effect'] == 'dots'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="dots"> <?php echo e(trans('labels.Dots')); ?></option>
                                                        <option
                                                                <?php if( $result['commonContent']['setting']['lazzy_loading_effect'] == 'lines'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="lines"> <?php echo e(trans('labels.Lines')); ?></option>
                                                        <option
                                                                <?php if( $result['commonContent']['setting']['lazzy_loading_effect'] == 'ripple'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="ripple"> <?php echo e(trans('labels.Ripple')); ?></option>
                                                        <option
                                                                <?php if( $result['commonContent']['setting']['lazzy_loading_effect'] == 'spiral'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="spiral"> <?php echo e(trans('labels.Spiral')); ?></option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.LazzyLoadingEffectText')); ?></span>
                                                </div>
                                            </div>

                                            <hr>
                                            <h4><?php echo e(trans('labels.displayPages')); ?> </h4>
                                            <hr>
                                            
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.wishListPage')); ?>


                                                </label>
                                                
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="wish_list_page" class="form-control">
                                                        <option <?php if($result['commonContent']['setting']['wish_list_page'] == '1'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="1"> <?php echo e(trans('labels.Show')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['wish_list_page'] == '0'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="0"> <?php echo e(trans('labels.Hide')); ?></option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.wishListPageText')); ?></span>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.editProfilePage')); ?>


                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="edit_profile_page" class="form-control">
                                                        <option <?php if($result['commonContent']['setting']['edit_profile_page']  == '1'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="1"> <?php echo e(trans('labels.Show')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['edit_profile_page']  == '0'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="0"> <?php echo e(trans('labels.Hide')); ?></option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.editProfilePageText')); ?></span>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.shippingAddressPage')); ?>


                                                </label>
                                               
                                                <div class="col-sm-10 col-md-4">
                                                
                                                    <select name="shipping_address_page" class="form-control">
                                                        <option <?php if($result['commonContent']['setting']['shipping_address_page'] == '1'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="1"> <?php echo e(trans('labels.Show')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['shipping_address_page'] == '0'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="0"> <?php echo e(trans('labels.Hide')); ?></option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.shippingAddressPageText')); ?></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.myOrdersPage')); ?>


                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="my_orders_page" class="form-control">
                                                    
                                                        <option <?php if($result['commonContent']['setting']['my_orders_page']  == '1'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="1"> <?php echo e(trans('labels.Show')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['my_orders_page']  == '0'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="0"> <?php echo e(trans('labels.Hide')); ?></option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.myOrdersPageText')); ?></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.contactUsPage')); ?>


                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="contact_us_page" class="form-control">
                                                        <option <?php if($result['commonContent']['setting']['contact_us_page'] == '1'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="1"> <?php echo e(trans('labels.Show')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['contact_us_page'] == '0'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="0"> <?php echo e(trans('labels.Hide')); ?></option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.contactUsPageText')); ?></span>
                                                </div>
                                            </div>

                                            

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.aboutUsPage')); ?>


                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="about_us_page" class="form-control">
                                                        <option <?php if($result['commonContent']['setting']['about_us_page']  == '1'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="1"> <?php echo e(trans('labels.Show')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['about_us_page']  == '0'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="0"> <?php echo e(trans('labels.Hide')); ?></option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.aboutUsPageText')); ?></span>
                                                </div>
                                            </div>
                                            

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.newsPage')); ?>


                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="news_page" class="form-control">
                                                        <option <?php if($result['commonContent']['setting']['news_page'] == '1'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="1"> <?php echo e(trans('labels.Show')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['news_page'] == '0'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="0"> <?php echo e(trans('labels.Hide')); ?></option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.newsPageText')); ?></span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.introPage')); ?>


                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="intro_page" class="form-control">
                                                        <option <?php if($result['commonContent']['setting']['intro_page'] == '1'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="1"> <?php echo e(trans('labels.Show')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['intro_page'] == '0'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="0"> <?php echo e(trans('labels.Hide')); ?></option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.introPageText')); ?></span>
                                                </div>
                                            </div>
                                            

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.shareapp')); ?>


                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="share_app" class="form-control">
                                                        <option <?php if($result['commonContent']['setting']['share_app'] == '1'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="1"> <?php echo e(trans('labels.Show')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['share_app'] == '0'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="0"> <?php echo e(trans('labels.Hide')); ?></option>

                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.shareappText')); ?></span>
                                                </div>
                                            </div>
                                            

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.rateapp')); ?></label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="rate_app" class="form-control">
                                                        <option <?php if($result['commonContent']['setting']['rate_app'] == '1'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="1"> <?php echo e(trans('labels.Show')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['rate_app'] == '0'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="0"> <?php echo e(trans('labels.Hide')); ?></option>

                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.rateappText')); ?></span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.settingPage')); ?>


                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="setting_page" class="form-control">
                                                        <option <?php if($result['commonContent']['setting']['setting_page'] == '1'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="1"> <?php echo e(trans('labels.Show')); ?></option>
                                                        <option <?php if($result['commonContent']['setting']['setting_page'] == '0'): ?>
                                                                selected
                                                                <?php endif; ?>
                                                                value="0"> <?php echo e(trans('labels.Hide')); ?></option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.settingPageText')); ?></span>
                                                </div>
                                            </div>
                                            
                                            <hr>
                                            <h4><?php echo e(trans('labels.LocalNotification')); ?> </h4>
                                            <hr>


                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Title')); ?>


                                                </label>
                                                
                                                <div class="col-sm-10 col-md-4">
                                                    <?php echo Form::text('notification_title', $result['commonContent']['setting']['notification_title'], array('class'=>'form-control', 'id'=>'notification_title')); ?>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.NotificationTitleText')); ?></span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Detail')); ?>


                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <?php echo Form::text('notification_text', $result['commonContent']['setting']['notification_text'], array('class'=>'form-control', 'id'=>'notification_text')); ?>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.NotificationDetailtext')); ?></span>
                                                </div>
                                            </div>
                                           
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.NotificationDuration')); ?></label>
                                                <div class="col-sm-10 col-md-4">

                                                    <select class="form-control" name="notification_duration">
                                                        <option value="day" <?php if($result['commonContent']['setting']['notification_duration']=='day'): ?> selected <?php endif; ?>><?php echo e(trans('labels.Day')); ?></option>
                                                        <option value="month" <?php if($result['commonContent']['setting']['notification_duration']=='month'): ?> selected <?php endif; ?>><?php echo e(trans('labels.Month')); ?></option>
                                                        <option value="year" <?php if($result['commonContent']['setting']['notification_duration']=='year'): ?> selected <?php endif; ?>><?php echo e(trans('labels.Year')); ?></option>
                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"><?php echo e(trans('labels.NotificationDurationText')); ?></span>
                                                </div>
                                            </div>
                                        </div>



                                        <!-- /.box-body -->
                                        <div class="box-footer text-center">
                                            <button type="submit" class="btn btn-primary"><?php echo e(trans('labels.Submit')); ?> </button>
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

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/app/current/resources/views/admin/settings/app/appSettings.blade.php ENDPATH**/ ?>
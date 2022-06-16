<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> <?php echo e(trans('labels.EditProduct')); ?> <small><?php echo e(trans('labels.EditProduct')); ?>...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('labels.breadcrumb_dashboard')); ?></a></li>
            <li><a href="<?php echo e(URL::to('admin/products/display')); ?>"><i class="fa fa-database"></i> <?php echo e(trans('labels.ListingAllProducts')); ?></a></li>
            <li class="active"><?php echo e(trans('labels.EditProduct')); ?></li>
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
                        <h3 class="box-title"><?php echo e(trans('labels.EditProduct')); ?> </h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                    <div class="row">
                            <div class="col-xs-12">
                                <?php if(session()->has('message.level')): ?>
                                    <div class="alert alert-<?php echo e(session('message.level')); ?> alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo session('message.content'); ?>

                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <div class="box-body">
                                        <?php if( count($errors) > 0): ?>
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="alert alert-danger" role="alert">
                                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                            <span class="sr-only">Error:</span>
                                            <?php echo e($error); ?>

                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>

                                        <?php echo Form::open(array('url' =>'admin/products/update', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')); ?>

                                        <?php echo Form::hidden('id', $result['product'][0]->products_id, array('class'=>'form-control', 'id'=>'id')); ?>

                                        
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.slug')); ?> </label>
            <div class="col-sm-10 col-md-8">
                <input type="hidden" name="old_slug" value="<?php echo e($result['product'][0]->products_slug); ?>">
                <input type="text" name="slug" class="form-control field-validate" value="<?php echo e($result['product'][0]->products_slug); ?>">
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;"><?php echo e(trans('labels.slugText')); ?></span>
                <span class="help-block hidden"><?php echo e(trans('labels.textRequiredFieldMessage')); ?></span>
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Product Type')); ?> </label>
            <div class="col-sm-10 col-md-8">
                <select class="form-control field-validate prodcust-type" name="products_type" onChange="prodcust_type();">
                    <option value=""><?php echo e(trans('labels.Choose Type')); ?></option>
                    <option value="0" <?php if($result['product'][0]->products_type==0): ?> selected <?php endif; ?>><?php echo e(trans('labels.Simple')); ?></option>
                    <option value="1" <?php if($result['product'][0]->products_type==1): ?> selected <?php endif; ?>><?php echo e(trans('labels.Variable')); ?></option>                                                    
                </select><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    <?php echo e(trans('labels.Product Type Text')); ?>.</span>
            </div>
        </div>
        <div class="form-group" style="display:<?php if($result['product'][0]->products_type==1): ?> block <?php else: ?> none <?php endif; ?> ;">
            <label for="name" class="col-sm-2 col-md-3 control-label">Parent Product</label>
            <div class="col-sm-10 col-md-8">
                <select class="form-control" name="parent_products_id">
                    <option value="">--Select--</option>    
                    <?php $__currentLoopData = $result['main_products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($o->products_id); ?>" <?php if($result['product'][0]->parent_products_id==$o->products_id): ?> selected <?php endif; ?>><?php echo e($o->products_name); ?></option>   
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                                                                                                    
                </select>                                                        
            </div>
        </div>
        <div class="form-group">
            <label for="products_sku" class="col-sm-2 col-md-3 control-label">Unique ID<span style="color:red;">*</span></label>
            <div class="col-sm-10 col-md-8">
                <?php echo Form::text('products_sku', $result['product'][0]->products_sku, array('class'=>'form-control field-validate', 'id'=>'products_sku')); ?>

                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                Enter unique id of product
                </span>
                <span class="help-block hidden">Enter unique id of product</span>
            </div>
        </div>
       <div class="form-group">
            <label class="col-sm-2 col-md-3 control-label">SB Unique ID</label>
            <div class="col-sm-10 col-md-8">
                <input type="text" name="sb_unique_id" class="form-control" value="<?php echo e($result['product'][0]->sb_unique_id); ?>" />
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Category')); ?></label>
            <div class="col-sm-10 col-md-8">
            <?php print_r($result['categories']); ?>
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    <?php echo e(trans('labels.ChooseCatgoryText')); ?>.</span>
                <span class="help-block hidden"><?php echo e(trans('labels.textRequiredFieldMessage')); ?></span>
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">Brand</label>
            <div class="col-sm-10 col-md-8">
                <select class="form-control" name="manufacturers_id">
                    <option value=""><?php echo e(trans('labels.Choose Manufacturer')); ?></option>
                    <?php $__currentLoopData = $result['manufacturer']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manufacturer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php if($result['product'][0]->manufacturers_id == $manufacturer->id ): ?>
                        selected
                        <?php endif; ?>
                        value="<?php echo e($manufacturer->id); ?>"><?php echo e($manufacturer->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    <?php echo e(trans('labels.ChooseManufacturerText')); ?>.</span>
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.ProductsPrice')); ?></label>
            <div class="col-sm-10 col-md-8">
                <?php echo Form::text('products_price', $result['product'][0]->products_price, array('class'=>'form-control number-validate', 'id'=>'products_price')); ?>

                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    <?php echo e(trans('labels.ProductPriceText')); ?>

                </span>
                <span class="help-block hidden"><?php echo e(trans('labels.ProductPriceText')); ?></span>
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">Points</label>
            <div class="col-sm-10 col-md-8">
                <?php echo Form::text('products_points', $result['product'][0]->products_points, array('class'=>'form-control number-validate', 'id'=>'products_points')); ?>

                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    <?php echo e(trans('labels.ProductPriceText')); ?>

                </span>
                <span class="help-block hidden">Points</span>
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.ProductsWeight')); ?></label>
            <div class="col-sm-10 col-md-4">
                <?php echo Form::text('products_weight', $result['product'][0]->products_weight, array('class'=>'form-control field-validate number-validate', 'id'=>'products_weight')); ?>

                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    <?php echo e(trans('labels.RequiredTextForWeight')); ?>

                </span>
            </div>
            <div class="col-sm-10 col-md-4" style="padding-left: 0;">
                <select class="form-control" name="products_weight_unit">
                    <?php if($result['units'] !== null): ?>
                    <?php $__currentLoopData = $result['units']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($unit->units_name); ?>" <?php if($result['product'][0]->products_weight_unit==$unit->units_name): ?> selected <?php endif; ?>><?php echo e($unit->units_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>                                                                                                                        
                </select>
            </div>
        </div>

        

        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">Product Stock<span style="color:red;">*</span></label>
            <div class="col-sm-10 col-md-8">
                <input type="text" id="stock_n" name="stock" value="<?php echo e($result['product'][0]->products_in_stock); ?>" class="form-control">
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    <?php echo e(trans('labels.Enter Stock Text')); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">Enter Min Order<span style="color:red;">*</span></label>
            <div class="col-sm-10 col-md-8">
                <input type="text" id="products_min_order" name="products_min_order" value="<?php echo e($result['product'][0]->products_min_order); ?>" class="form-control">
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    Enter Min order</span>
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">
                <?php echo e(trans('labels.Min Level')); ?><span style="color:red;">*</span>
            </label>
            <div class="col-sm-10 col-md-8">
                <input type="text" name="min_level" id="min_level_n" value="<?php echo e($result['product'][0]->products_min_stock); ?>" class="form-control number-validate-level">
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    <?php echo e(trans('labels.Min Level Text')); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">
                <?php echo e(trans('labels.Max Level')); ?><span style="color:red;">*</span>
            </label>
            <div class="col-sm-10 col-md-8">
                <input type="text" name="max_level" id="max_level_n" value="<?php echo e($result['product'][0]->products_max_stock); ?>" class="form-control number-validate-level">
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    <?php echo e(trans('labels.Max Level Text')); ?></span>
            </div>
        </div>
        
        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">Expire Date</label>
            <div class="col-sm-10 col-md-8">
                <input class="form-control datepicker" value="<?php echo e(($result['product'][0]->expire_date != '0000-00-00') ? $result['product'][0]->expire_date : ''); ?>" readonly="" type="text" name="expire_date" id="expire_date">
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">Main Img</label>
            <div class="col-sm-10 col-md-8">
                <img id="p_main_image" src="<?php echo e($result['product'][0]->main_image); ?>" alt="" width="100px" height="100px">
                <input type="file" name="p_main_img">
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">Sub Images</label>
            <div class="col-sm-10 col-md-3">
                <img id="p_sub_image_1" src="<?php echo e($result['product'][0]->sub_images[0]); ?>" alt="" width="100px" height="100px">
                <input type="file" name="p_sub_image_1">
            </div>
            <div class="col-sm-10 col-md-3" style="padding-left: 0;">
                <div class="col-sm-10 col-md-8">
                    <img id="p_sub_image_2" src="<?php echo e($result['product'][0]->sub_images[1]); ?>" alt="" width="100px" height="100px">
                    <input type="file" name="p_sub_image_2">
                </div>
            </div>
            <div class="col-sm-10 col-md-3" style="padding-left: 0;">
                <img id="p_sub_image_3" src="<?php echo e($result['product'][0]->sub_images[2]); ?>" alt="" width="100px" height="100px">
                <input type="file" name="p_sub_image_3">
            </div>
        </div>
        
    </div>
    <div class="col-sm-6">
       <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Status')); ?> </label>
            <div class="col-sm-10 col-md-8">
                <select class="form-control" name="products_status">
                    <option value="1" <?php if($result['product'][0]->products_status==1): ?> selected <?php endif; ?> ><?php echo e(trans('labels.Active')); ?></option>
                    <option value="0" <?php if($result['product'][0]->products_status==0): ?> selected <?php endif; ?>><?php echo e(trans('labels.Inactive')); ?></option>
                </select>
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    <?php echo e(trans('labels.SelectStatus')); ?></span>
            </div>
        </div>
        
        
        
        
        <div class="form-group">
            <label class="control-label col-sm-2 col-md-3">Bundle</label>
                <div class="col-sm-10 col-md-8">
                <select name="bundle_id" class="form-control">
                    <option value="">--Select--</option>
                    <?php $__currentLoopData = $result['bundles']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bundle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($bundle->id); ?>" <?php if($result['bundle_id']==$bundle->id): ?> selected <?php endif; ?>><?php echo e($bundle->bundle_title); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-sm-2 col-md-3">Combo</label>
                <div class="col-sm-10 col-md-8">
                <select name="combo_id" class="form-control">
                    <option value="">--Select--</option>
                    <?php $__currentLoopData = $result['combos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $combo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($combo->id); ?>" <?php if($result['combo_id']==$combo->id): ?> selected <?php endif; ?>><?php echo e($combo->combo_title); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
       
        <!--<div class="form-group">
            <label class="col-sm-2 col-md-3 control-label">Is Exotic?</label>
            <div class="col-sm-10 col-md-8">
                <select class="form-control" name="exotic">
                    <option value="N" <?php if($result['product'][0]->products_exotic=='N'): ?> selected <?php endif; ?>><?php echo e(trans('labels.No')); ?></option>
                    <option value="Y" <?php if($result['product'][0]->products_exotic=='Y'): ?> selected <?php endif; ?>><?php echo e(trans('labels.Yes')); ?></option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.IsFeature')); ?> </label>
            <div class="col-sm-10 col-md-8">
                <select class="form-control" name="is_feature">
                    <option value="0" <?php if($result['product'][0]->is_feature==0): ?> selected <?php endif; ?>><?php echo e(trans('labels.No')); ?></option>
                    <option value="1" <?php if($result['product'][0]->is_feature==1): ?> selected <?php endif; ?>><?php echo e(trans('labels.Yes')); ?></option>
                </select>
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    <?php echo e(trans('labels.IsFeatureProuctsText')); ?></span>
            </div>
        </div>-->
        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Hotcat')); ?></label>
            <div class="col-sm-10 col-md-8">
                <?php print_r($result['hotcats']); ?>
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    <?php echo e(trans('labels.ChoosehotcatText')); ?>.</span>
                <span class="help-block hidden"><?php echo e(trans('labels.textRequiredFieldMessage')); ?></span>
            </div>
        </div>
       <div class="form-group" id="tax-class">
            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.TaxClass')); ?> </label>
            <div class="col-sm-10 col-md-8">
                <select class="form-control field-validate" name="tax_class_id">
                    <option selected> <?php echo e(trans('labels.SelectTaxClass')); ?></option>
                    <?php $__currentLoopData = $result['taxClass']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxClass): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php if($result['product'][0]->products_tax_class_id == $taxClass->tax_class_id ): ?>
                        selected
                        <?php endif; ?>
                        value="<?php echo e($taxClass->tax_class_id); ?>"><?php echo e($taxClass->tax_class_title); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    <?php echo e(trans('labels.ChooseTaxClassForProductText')); ?>

                </span>
                <span class="help-block hidden"><?php echo e(trans('labels.SelectProductTaxClass')); ?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-md-3 control-label">Bonus Points</label>
            <div class="col-sm-10 col-md-8">
                <input type="text" name="bonus_points" class="form-control" value="<?php echo e($result['product'][0]->products_points_bonus); ?>" />
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">Redeem Points</label>
            <div class="col-sm-10 col-md-8">
                <?php echo Form::text('products_points_redeem', $result['product'][0]->products_points_redeem, array('class'=>'form-control', 'id'=>'products_points_redeem')); ?>                                                        
                <span class="help-block hidden">Redeem Points</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-md-3 control-label">Note</label>
            <div class="col-sm-10 col-md-8">
                <input type="text" name="note" class="form-control" value="<?php echo e($result['product'][0]->products_note); ?>" />
            </div>
        </div>  
         <div class="form-group">
            <label class="col-sm-2 col-md-3 control-label">Max Orders</label>
            <div class="col-sm-10 col-md-8">
                <input type="text" class="form-control" value="<?php echo e($result['product'][0]->products_max_order); ?>" name="max_order" />
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Maximum number of orders</span>
            </div>                                                    
        </div>      
        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">Market Price</label>
            <div class="col-sm-10 col-md-7">
                <?php echo Form::text('products_price_market', $result['product'][0]->products_price_market, array('class'=>'form-control', 'id'=>'products_price_market')); ?>

                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    <?php echo e(trans('labels.ProductPriceText')); ?>

                </span>
                <span class="help-block hidden"><?php echo e(trans('labels.ProductPriceText')); ?></span>
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">Purchase Price</label>
            <div class="col-sm-10 col-md-7">
                <?php echo Form::text('price_purchase', $result['product'][0]->products_price_purchase, array('class'=>'form-control', 'id'=>'products_price_purchase')); ?>

                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Enter numeric purchase price</span>
            </div>
        </div>
      
       
      
        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.FlashSale')); ?></label>
            <div class="col-sm-10 col-md-8">
                <select class="form-control" onChange="showFlash()" name="isFlash" id="isFlash">
                    <option value="no" <?php if($result['flashProduct'][0]->flash_status == 0): ?>
                        selected
                        <?php endif; ?>><?php echo e(trans('labels.No')); ?></option>
                    <option value="yes" <?php if($result['flashProduct'][0]->flash_status == 1): ?>
                        selected
                        <?php endif; ?>><?php echo e(trans('labels.Yes')); ?></option>
                </select>
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    <?php echo e(trans('labels.FlashSaleText')); ?></span>
            </div>
        </div>
        <div class="flash-container" style="display: none;">
            <div class="form-group">
                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.FlashSalePrice')); ?></label>
                <div class="col-sm-10 col-md-8">
                    <input class="form-control" type="text" name="flash_sale_products_price" id="flash_sale_products_price" value="<?php echo e($result['flashProduct'][0]->flash_sale_products_price); ?>">
                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                        <?php echo e(trans('labels.FlashSalePriceText')); ?></span>
                    <span class="help-block hidden"><?php echo e(trans('labels.FlashSalePriceText')); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.FlashSaleDate')); ?></label>
                <?php if($result['flashProduct'][0]->flash_status == 1): ?>
                <div class="col-sm-10 col-md-4">
                    <input class="form-control datepicker" readonly type="text" name="flash_start_date" id="flash_start_date" value="<?php echo e(date('d/m/Y', $result['flashProduct'][0]->flash_start_date)); ?>">
                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                        <?php echo e(trans('labels.FlashSaleDateText')); ?></span>
                    <span class="help-block hidden"><?php echo e(trans('labels.textRequiredFieldMessage')); ?></span>
                </div>
                <div class="col-sm-10 col-md-4 bootstrap-timepicker">
                    <input type="text" class="form-control timepicker" readonly name="flash_start_time" id="flash_start_time"
                        value="<?php echo e(date('h:i:sA',  $result['flashProduct'][0]->flash_start_date )); ?>">
                    <span class="help-block hidden"><?php echo e(trans('labels.textRequiredFieldMessage')); ?></span>
                </div>
                <?php else: ?>
                <div class="col-sm-10 col-md-4">
                    <input class="form-control datepicker" readonly type="text" name="flash_start_date" id="flash_start_date" value="">
                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                        <?php echo e(trans('labels.FlashSaleDateText')); ?></span>
                    <span class="help-block hidden"><?php echo e(trans('labels.textRequiredFieldMessage')); ?></span>
                </div>
                <div class="col-sm-10 col-md-4 bootstrap-timepicker">
                    <input type="text" class="form-control timepicker" readonly name="flash_start_time" id="flash_start_time" value="">
                    <span class="help-block hidden"><?php echo e(trans('labels.textRequiredFieldMessage')); ?></span>
                </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.FlashExpireDate')); ?></label>
                <?php if($result['flashProduct'][0]->flash_status == 1): ?>
                <div class="col-sm-10 col-md-4">
                    <input class="form-control datepicker" readonly type="text" name="flash_expires_date" id="flash_expires_date"
                        value="<?php echo e(date('d/m/Y', $result['flashProduct'][0]->flash_expires_date )); ?>">
                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                        <?php echo e(trans('labels.FlashExpireDateText')); ?></span>
                    <span class="help-block hidden"><?php echo e(trans('labels.textRequiredFieldMessage')); ?></span>
                </div>
                <div class="col-sm-10 col-md-4 bootstrap-timepicker">
                    <input type="text" class="form-control timepicker" readonly name="flash_end_time" id="flash_end_time" value="<?php echo e(date('h:i:sA', $result['flashProduct'][0]->flash_expires_date )); ?>">
                    <span class="help-block hidden"><?php echo e(trans('labels.textRequiredFieldMessage')); ?></span>
                </div>
                <?php else: ?>
                <div class="col-sm-10 col-md-4">
                    <input class="form-control datepicker" readonly type="text" name="flash_expires_date" id="flash_expires_date" value="">
                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                        <?php echo e(trans('labels.FlashExpireDateText')); ?></span>
                    <span class="help-block hidden"><?php echo e(trans('labels.textRequiredFieldMessage')); ?></span>
                </div>
                <div class="col-sm-10 col-md-4 bootstrap-timepicker">
                    <input type="text" class="form-control timepicker" readonly name="flash_end_time" id="flash_end_time" value="">
                    <span class="help-block hidden"><?php echo e(trans('labels.textRequiredFieldMessage')); ?></span>
                </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Status')); ?></label>
                <div class="col-sm-10 col-md-8">
                    <select class="form-control" name="flash_status">
                        <option value="1"><?php echo e(trans('labels.Active')); ?></option>
                        <option value="0"><?php echo e(trans('labels.Inactive')); ?></option>
                    </select>
                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                        <?php echo e(trans('labels.ActiveFlashSaleProductText')); ?></span>
                </div>
            </div>
            
        </div>
        <div class="form-group  special-link">
            <label for="name" class="col-sm-2 col-md-3 control-label">Discount </label>
            <div class="col-sm-10 col-md-8">
                <select class="form-control" onChange="showSpecial()" name="isSpecial" id="isSpecial">
                    <option <?php if($result['product'][0]->products_id != $result['specialProduct'][0]->products_id && $result['specialProduct'][0]->status == 0): ?>
                        selected
                        <?php endif; ?>
                        value="no"><?php echo e(trans('labels.No')); ?></option>
                    <option <?php if($result['product'][0]->products_id == $result['specialProduct'][0]->products_id && $result['specialProduct'][0]->status == 1): ?>
                        selected
                        <?php endif; ?>
                        value="yes"><?php echo e(trans('labels.Yes')); ?></option>
                </select>
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"> <?php echo e(trans('labels.SpecialProductText')); ?></span>
            </div>
        </div>
        <div class="special-container" style="display: none;">
            <div class="form-group">
                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.SpecialPrice')); ?></label>
                <div class="col-sm-10 col-md-8">
                    <?php echo Form::text('specials_new_products_price', $result['specialProduct'][0]->specials_new_products_price, array('class'=>'form-control', 'id'=>'special-price')); ?>

                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                        <?php echo e(trans('labels.SpecialPriceTxt')); ?>.</span>
                    <span class="help-block hidden"><?php echo e(trans('labels.SpecialPriceNote')); ?>.</span>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.ExpiryDate')); ?></label>
                <div class="col-sm-10 col-md-8">
                    <?php if(!empty($result['specialProduct'][0]->status) and $result['specialProduct'][0]->status == 1): ?>
                    <?php echo Form::text('expires_date', date('d/m/Y', $result['specialProduct'][0]->expires_date), array('class'=>'form-control datepicker', 'id'=>'expiry-date', 'readonly'=>'readonly')); ?>

                    <?php else: ?>
                    <?php echo Form::text('expires_date', '', array('class'=>'form-control datepicker', 'id'=>'expiry-date', 'readonly'=>'readonly')); ?>

                    <?php endif; ?>
                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                        <?php echo e(trans('labels.SpecialExpiryDateTxt')); ?>

                    </span>
                    <span class="help-block hidden"><?php echo e(trans('labels.textRequiredFieldMessage')); ?></span>
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Status')); ?></label>
                <div class="col-sm-10 col-md-8">
                    <select class="form-control" name="status">
                    <option
                        <?php if($result['specialProduct'][0]->status == 1 ): ?>
                        selected
                        <?php endif; ?>
                        value="1"><?php echo e(trans('labels.Active')); ?>

                        </option>
                    <option
                        <?php if($result['specialProduct'][0]->status == 0 ): ?>
                        selected
                        <?php endif; ?>
                        value="0"><?php echo e(trans('labels.Inactive')); ?></option>
                    </select>
                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                        <?php echo e(trans('labels.ActiveSpecialProductText')); ?>.</span>
                </div>
            </div>
        </div>
       
        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">MSD</label>
            <div class="col-sm-10 col-md-8">
                <select class="form-control" onChange="showMSD(this.value);" name="isMSD" id="isMSD">
                    <option value="N" <?php if($result['product'][0]->products_msd=='N'): ?> selected <?php endif; ?>>No</option>
                    <option value="Y" <?php if($result['product'][0]->products_msd=='Y'): ?> selected <?php endif; ?>>Yes</option>
                </select>
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Member Special Discount</span>
            </div>
        </div>
        <div class="msd-container" style="display: <?php if($result['product'][0]->products_msd=='N'): ?> none <?php else: ?> block <?php endif; ?>  ;">
            <?php $__currentLoopData = $result['user_levels']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user_level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="form-group">
                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e($user_level->membership_name); ?></label>
                <div class="col-sm-10 col-md-8">
                    <input type="text" class="form-control" value="<?php if(isset($result['product'][0]->msd[$user_level->membership_id])): ?><?php echo e($result['product'][0]->msd[$user_level->membership_id]); ?><?php endif; ?>" name="msd_<?php echo e($user_level->membership_id); ?>" />
                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Enter discount amount in %</span>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

    </div>
</div>                                        
                                        
                                        
                                        <hr>
                                       
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="tabbable tabs-left">
                                                    <ul class="nav nav-tabs">
                                                        <?php
                                                        $i = 0;
                                                        ?>
                                                        <?php $__currentLoopData = $result['languages']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$languages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li class="<?php if($i==0): ?> active <?php endif; ?>"><a href="#product_<?=$languages->languages_id?>" data-toggle="tab"><?=$languages->name?></a></li>
                                                        <?php
                                                        $i++;
                                                        ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <?php
                                                        $j = 0;
                                                        ?>
                                                        <?php $__currentLoopData = $result['description']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$description_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div style="margin-top: 15px;" class="tab-pane <?php if($j==0): ?> active <?php endif; ?>" id="product_<?=$description_data['languages_id']?>">
                                                            <?php
                                                            $j++;
                                                            ?>
                                                            <div class="form-group">
                                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.ProductName')); ?> (<?php echo e($description_data['language_name']); ?>)</label>
                                                                <div class="col-sm-10 col-md-4">
                                                                    <input type="text" name="products_name_<?=$description_data['languages_id']?>" class="form-control <?php if($description_data['languages_id']==1): ?> field-validate <?php endif; ?>" value='<?php echo e($description_data['products_name']); ?>'>
                                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                        <?php echo e(trans('labels.EnterProductNameIn')); ?> <?php echo e($description_data['language_name']); ?> </span>
                                                                    <span class="help-block hidden"><?php echo e(trans('labels.textRequiredFieldMessage')); ?></span>

                                                                </div>
                                                            </div>

                                                            <div class="form-group external_link" style="display: none">
                                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.External URL')); ?> (<?php echo e($description_data['language_name']); ?>)</label>
                                                                <div class="col-sm-10 col-md-4">
                                                                    <input type="text" name="products_url_<?=$description_data['languages_id']?>" class="form-control products_url" value='<?php echo e($description_data['products_url']); ?>'>
                                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                        <?php echo e(trans('labels.External URL Text')); ?> (<?php echo e($description_data['language_name']); ?>) </span>
                                                                    <span class="help-block hidden"><?php echo e(trans('labels.textRequiredFieldMessage')); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Description')); ?> (<?php echo e($description_data['language_name']); ?>)</label>
                                                                <div class="col-sm-10 col-md-8">
                                                                    <textarea id="editor<?=$description_data['languages_id']?>" name="products_description_<?=$description_data['languages_id']?>" class="form-control"
                                                                      rows="5"><?php echo e(stripslashes($description_data['products_description'])); ?></textarea>

                                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                        <?php echo e(trans('labels.EnterProductDetailIn')); ?> <?php echo e($description_data['language_name']); ?></span> </div>
                                                            </div>

                                                        </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                        <div class="box-footer text-center">
                                            <button type="submit" class="btn btn-primary pull-right" id="normal-btn"><?php echo e(trans('labels.Save_And_Continue')); ?> <i class="fa fa-angle-right 2x"></i></button>
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
        </div>
        <!-- /.row -->

        <!-- Main row -->

        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<script src="<?php echo asset('admin/plugins/jQuery/jQuery-2.2.0.min.js'); ?>"></script>
<script type="text/javascript">
    $(function() {

        //for multiple languages
        <?php $__currentLoopData = $result['languages']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $languages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor<?php echo e($languages->languages_id); ?>');
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();

    });

    function showMSD(state)
    {
        if(state=='Y')
        {
            $('.msd-container').show();
        }
        else
        {
            $('.msd-container').hide();
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/app/current/resources/views/admin/products/edit.blade.php ENDPATH**/ ?>

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Collections <small>Listing all the collections...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('labels.breadcrumb_dashboard')); ?></a></li>
                <li class=" active">Collections</li>
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
                            

                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-6 form-inline">
                                                <form name='filter' id="registration" class="filter  " method="get" action="<?php echo e(url('admin/manufacturers/filter')); ?>">
                                                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                                    <div class="input-group-form search-panel ">
                                                      <select type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" name="FilterBy" id="FilterBy" >
                                                        <option value="" selected disabled hidden><?php echo e(trans('labels.Filter By')); ?></option>
                                                        <option value="Name" <?php if(isset($name)): ?> <?php if($name == "Name"): ?> <?php echo e('selected'); ?> <?php endif; ?> <?php endif; ?>><?php echo e(trans('labels.Name')); ?></option>
                                                        <option value="URL" <?php if(isset($name)): ?> <?php if($name == "URL"): ?> <?php echo e('selected'); ?> <?php endif; ?> <?php endif; ?>><?php echo e(trans('labels.URL')); ?></option>
                                                      </select>
                                                      <input type="text" class="form-control input-group-form " name="parameter" placeholder="<?php echo e(trans('labels.Search')); ?>..." id="parameter" <?php if(isset($param)): ?> value="<?php echo e($param); ?>" <?php endif; ?>>
                                                      <button class="btn btn-primary " type="submit" id="submit"><span class="glyphicon glyphicon-search"></span></button>
                                                      <?php if(isset($param,$name)): ?>  <a class="btn btn-danger " href="<?php echo e(URL::to('admin/bundles/display')); ?>"><i class="fa fa-ban" aria-hidden="true"></i> </a><?php endif; ?>
                                                    </div>
                                                </form>
                                                <div class="col-lg-4 form-inline" id="contact-form12"></div>
                                        </div>
                                    </div>
                                </div>

                            <div class="box-tools pull-right">
                                <a href="<?php echo e(URL::to('admin/packages/add')); ?>" type="button" class="btn btn-block btn-primary"><?php echo e(trans('labels.AddNew')); ?></a>
                            </div>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <?php if(count($errors) > 0): ?>
                                        <?php if($errors->any()): ?>
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <?php echo e($errors->first()); ?>

                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Color Code</th>
                                            <th>Background</th>                                            
                                            <th>Status</th>
                                            <th>Number of Products</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(count($list)>0): ?>
                                            <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <tr>
                                                    <td><?php echo e($o->id); ?></td>
                                                    <td>
                                                        <?php if(empty($o->parent_id)): ?>
                                                        <?php echo e($o->package_info()->package_title); ?>

                                                        <?php else: ?> 
                                                        <?php echo e($o->parent_package()->package_info()->package_title); ?> <i class="fa fa-angle-right"></i> <?php echo e($o->package_info()->package_title); ?>

                                                        <?php endif; ?>
                                                        
                                                        <?php if(count($o->child_packages)>0): ?>
                                                        <span class="badge badge-dark" onClick="$('.tr_<?php echo e($o->id); ?>').toggle();"><i class="fa fa-angle-down"></i></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if(isset($o->color_code)): ?>
                                                            <?php echo e($o->color_code); ?>

                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if(isset($o->image_category)): ?>
                                                        <img src="<?php echo e(asset($o->image_category->path)); ?>" width="60" />
                                                        <?php endif; ?>
                                                    </td>                                                                                              
                                                    <!--<td>
                                                        <?php echo e($o->end_time); ?>

                                                        <?php if(time()>strtotime($o->end_time)): ?>
                                                        <span class="badge bg-red ml-2">Expired</span>                                                    
                                                        <?php endif; ?>
                                                    </td>-->
                                                    
                                                    <td>
                                                      <?php if($o->status==1): ?>
                                                      <span class="label label-success">
                                                        <?php echo e(trans('labels.Active')); ?>

                                                      </span>
                                                      <?php elseif($o->status==0): ?>
                                                      <span class="label label-danger">
                                                          <?php echo e(trans('labels.InActive')); ?>

                                                      <?php endif; ?>
                                                    </td>
                                                    
                                                    <td><a href="<?php echo e(URL::to('admin/packages/products/'.$o->id)); ?>"><?php echo e($o->package_products()->count()); ?> Products</a></td>
                                                    <td>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="<?php echo e(URL::to('admin/packages/edit/'.$o->id)); ?>" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="Delete" onClick="return confirm('Sure to delete?')" href="<?php echo e(url('admin/packages/delete/'.$o->id)); ?>" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>    

                                                <?php $__currentLoopData = $o->child_packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="tr_<?php echo e($o2->parent_id); ?>" style="display:none;">
                                                    <td><?php echo e($o2->id); ?></td>
                                                    <td>
                                                        <?php if(empty($o2->parent_id)): ?>
                                                        <?php echo e($o2->package_info()->package_title); ?>

                                                        <?php else: ?> 
                                                        <?php echo e($o2->parent_package()->package_info()->package_title); ?> <i class="fa fa-angle-right"></i> <?php echo e($o2->package_info()->package_title); ?>

                                                        <?php endif; ?>
                                                    </td>                                                
                                                    <td>
                                                        <?php if(isset($o2->image_category)): ?>
                                                        <img src="<?php echo e(asset($o2->image_category->path)); ?>" width="60" />
                                                        <?php endif; ?>
                                                    </td>                                                                                              
                                                    <td>
                                                      <?php if($o->status==1): ?>
                                                      <span class="label label-success">
                                                        <?php echo e(trans('labels.Active')); ?>

                                                      </span>
                                                      <?php elseif($o->status==0): ?>
                                                      <span class="label label-danger">
                                                          <?php echo e(trans('labels.InActive')); ?>

                                                      <?php endif; ?>
                                                    </td>
                                                    <td><a href="<?php echo e(URL::to('admin/packages/products/'.$o2->id)); ?>"><?php echo e($o2->package_products()->count()); ?> Products</a></td>
                                                    <td>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="<?php echo e(URL::to('admin/packages/edit/'.$o2->id)); ?>" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="Delete" onClick="return confirm('Sure to delete?')" href="<?php echo e(url('admin/packages/delete/'.$o2->id)); ?>" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6">No records found.</td>
                                            </tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                    
                                    <div class="col-xs-12 text-right">
                                        <?php echo e($list->links()); ?>

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/app/current/resources/views/admin/collections/index.blade.php ENDPATH**/ ?>
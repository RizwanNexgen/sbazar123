
<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Collections <small>Add Products...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('labels.breadcrumb_dashboard')); ?></a></li>
                <li><a href="<?php echo e(URL::to('admin/packages/display')); ?>"><i class="fa fa-industry"></i> Collections</a></li>
                <li class="active">Products</li>
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
                            <h3 class="box-title">Add Products</h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info">
                                        <br>

                                        <?php if(session('update')): ?>
                                            <div class="alert alert-success alert-dismissable custom-success-box" style="margin: 15px;">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <strong> <?php echo e(session('update')); ?> </strong>
                                            </div>
                                        <?php endif; ?>


                                        <?php if($errors->any()): ?>
                                            <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li><?php echo e($error); ?></li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>

                                    <!-- /.box-header -->
                                        <!-- form start -->
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Search product</label>
                                                <input type="text" class="form-control" id="searchProduct" name="search" value="" placeholder="Enter Product ID/Name/SKU" />
                                            </div>

                                            <table id="myTable" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="10%">Product ID</th>                                                                                   
                                                        <th>Title</th>
                                                        <th width="10%">Price</th> 
                                                        <th>SKU</th>                                            
                                                        <th width="10%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="searchResult">
                                                <?php if(count($list)>0): ?>
                                                    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($o->products_id); ?></td>                                                                     
                                                        <td><?php echo e($o->products_name); ?> (<?php echo e($o->products_weight); ?> <?php echo e($o->products_weight_unit); ?>)</td>
                                                        <td>€<?php echo e($o->products_price); ?></td>  
                                                        <td><?php echo e($o->products_sku); ?></td>                                            
                                                        <td>
                                                            <a href="javascript:void(0)" onClick="addPackageProduct(<?php echo e($o->products_id); ?>, <?php echo e($info->id); ?>)" class="btn btn-success btn-sm">Add</a>                                                            
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                
                                                <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <div class="box">
                        <div class="box-header">Products</div>
                        <div class="box-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="10%">Product ID</th>                                                                                   
                                        <th>Title</th>
                                        <th width="10%">Price</th> 
                                        <th>SKU</th>                                            
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="addedResult">
                                <?php if(count($products)>0): ?>
                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($o->products_id); ?></td>                                                                     
                                        <td><?php echo e($o->products_name); ?> (<?php echo e($o->products_weight); ?> <?php echo e($o->products_weight_unit); ?>)</td>
                                        <td>€<?php echo e($o->products_price); ?></td>  
                                        <td><?php echo e($o->products_sku); ?></td>                                            
                                        <td>
                                            <a onClick="return confirm('Sure to delete?')" href="<?php echo e(url('admin/packages/remove_products/'.$o->products_id.'/'.$info->id)); ?>" class="btn btn-danger btn-sm">Remove</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
            $('#searchProduct').keyup(function(){
                
                var input, filter, table, tr, td, i, product_id, product_title, product_sku;                            
                input = document.getElementById("searchProduct");                                               
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");
                
                // Loop through all table rows, and hide those who don't match the search query
                for (i = 1; i < tr.length; i++) 
                {
                    product_id = tr[i].getElementsByTagName("td")[0];
                    
                    product_title = tr[i].getElementsByTagName("td")[1];
                    product_sku = tr[i].getElementsByTagName("td")[3];

                    product_idValue = product_id.textContent || product_id.innerText;
                    product_titleValue = product_title.textContent || product_title.innerText;
                    product_skuValue = product_sku.textContent || product_sku.innerText;

                    if ( (product_idValue.toUpperCase().indexOf(filter) > -1) || (product_titleValue.toUpperCase().indexOf(filter) > -1) || (product_skuValue.toUpperCase().indexOf(filter) > -1)) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
                
            });
        });   

        function addPackageProduct(product_id, package_id)
        {
            $.ajax({
                url:'<?php echo e(url("admin/packages/add_product")); ?>',
                data:'product_id='+product_id+'&package_id='+package_id,
                type:'GET',
                dataType:'json',
                success:function(response){
                    if(response.error=='N') {
                        html = '<tr>'+
                        '<td>'+response.product.products_id+'</td>'+  
                        '<td>'+response.product.products_name+' ('+response.product.products_weight+' '+response.product.products_weight_unit+')</td>'+       
                        '<td>€'+response.product.products_price+'</td>'+  
                        '<td>'+response.product.products_sku+'</td>'+
                        '<td><a onClick="return confirm(\'Sure to delete?\')" href="<?php echo e(url("admin/packages/remove_products")); ?>/'+response.product.products_id+'/'+package_id+'" class="btn btn-danger btn-sm">Remove</a></td>'+    
                        '</tr>';
                        $('#tr_'+response.product.products_id).remove();
                        $('#addedResult').append(html);
                    }else{
                        alert(response.error_msg);
                    }
                }
            });
        }     
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/app/current/resources/views/admin/collections/products.blade.php ENDPATH**/ ?>
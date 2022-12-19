<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid pt-3">
            <?php
            errorAlert();
            successAlert();
            ?>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><?=$title?></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="<?= base_url('backend/products/edit/'.$item->id); ?>" method="post">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" value="<?= $item->title; ?>">
                            <?php echo form_error('title','<span class = text-danger >','</span>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" class="form-control" value="<?= $item->description; ?>">
                            <?php echo form_error('description','<span class = text-danger >','</span>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" class="form-control" value="<?= $item->quantity; ?>">
                            <?php echo form_error('quantity','<span class = text-danger >','</span>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" name="price" class="form-control"  step="0.01" min="0" value="<?= $item->price; ?>">
                            <?php echo form_error('price','<span class = text-danger >','</span>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="sales_prices">Sales prices</label>
                            <input type="number" name="sales_prices" class="form-control" step="0.01" min="0" value="<?= $item->sales_prices; ?>">
                            <?php echo form_error('sales_prices','<span class = text-danger >','</span>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="brand">Brand</label>
                            <br>
                            <select class="custom-select form-control" id="brand" name="brand">
                                <?php foreach($lists as $list): ?>
                                <option value="<?= $list->id; ?>" <?php echo ($item->id == $list->id) ? 'selected' : '' ?> ><?= $list->title; ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Status">Status</label>
                            <br>
                            <select class="custom-select form-control" id="Status" name="status">
                                <option value="0" <?php echo  ($item->status == 0) ? 'selected' : ''  ?>>Non-Active</option>
                                <option value="1" <?php echo ($item->status == 1) ? 'selected' : ''  ?>>Active</option>
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </section>
</div>
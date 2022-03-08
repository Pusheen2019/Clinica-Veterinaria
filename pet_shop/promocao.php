 <!-- Header-->
 <header class="bg-wheat py-5" id="main-header">
    <div class="container px-5 px-lg-2 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">O melhor para os seus animais</h1>
            <p class="lead fw-normal text-white-50 mb-0">Compre agora!</p>
        </div>
    </div>
</header>
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php 
                $products = $conn->query("SELECT * FROM `products` where status = 1 limit 1 ");
                while($row = $products->fetch_assoc()):
                    $upload_path = base_app.'/uploads/product_'.$row['id'];
                    $img = "";
                    if(is_dir($upload_path)){
                        $fileO = scandir($upload_path);
                        if(isset($fileO[2]))
                            $img = "uploads/product_".$row['id']."/".$fileO[2];
                        // var_dump($fileO);
                    }
                    $inventory = $conn->query("SELECT * FROM inventory where product_id = ".$row['id']);
                    $inv = array();
                    while($ir = $inventory->fetch_assoc()){
                        $inv[$ir['size']] = number_format($ir['price']);
                    }
            ?>
            <div class="col mb-5">
                <div class="card h-100 product-item rounded-3 border-light">
                    <!-- Product image-->
                    <img class="card-img-center w-40" src="<?php echo validate_image($img) ?>" alt="..." />
                    <!-- Product details-->
                    <div class="card-body p-8">
                        <div class="text-center">
                            <!-- Product name-->
                            <h5 class="fst-italic"><?php echo $row['product_name'] ?></h5>
                            <!-- Product price-->
                            <?php foreach($inv as $k=> $v): ?>
                                <span><b> Tamanhos:</b> <b><?php echo $k ?> </b><del><?php echo $v ?>&#8364;</del> <span class="badge bg-red text-wrap" style="width: 6rem;">20 &#8364;</span></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center">
                            <a class="btn btn-flat rounded-3 btn-warning "   href=".?p=view_product&id=<?php echo md5($row['id']) ?>">Ver</a>
                        </div>
                        
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
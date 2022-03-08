<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `sub_categories` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="card card-outline card-info">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Update ": "Create New " ?> Sub Catgoria</h3>
	</div>
	<div class="card-body">
		<form action="" id="category-form">
			<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
            <div class="form-group">
				<label for="parent_id" class="control-label">Categoria</label>
                <select name="parent_id" id="parent_id" class="custom-select select2">
                <option value=""></option>
                <?php
                    $qry = $conn->query("SELECT * FROM `categories` order by category asc");
                    while($row= $qry->fetch_assoc()):
                ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($parent_id) && $parent_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['category'] ?></option>
                <?php endwhile; ?>
                </select>
			</div>
			<div class="form-group">
				<label for="sub_category" class="control-label">Sub categoria Nome</label>
                <textarea name="sub_category" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo isset($sub_category) ? $sub_category : ''; ?></textarea>
			</div>
            <div class="form-group">
				<label for="description" class="control-label">Descrição</label>
                <textarea name="description" id="" cols="30" rows="2" class="form-control form no-resize summernote"><?php echo isset($description) ? $description : ''; ?></textarea>
			</div>
            <div class="form-group">
				<label for="status" class="control-label">Estado</label>
                <select name="status" id="status" class="custom-select selevt">
                <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Ativo</option>
                <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inativo</option>
                </select>
			</div>
			
		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-flat btn-primary" form="category-form">Guardar</button>
		<a class="btn btn-flat btn-default" href="?page=maintenance/sub_category">Cancelar</a>
	</div>
</div>
<script>
  
	$(document).ready(function(){
        $('.select2').select2({placeholder:"Please Select here",width:"relative"})
		$('#category-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_sub_category",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.href = "./?page=maintenance/sub_category";
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})

        $('.summernote').summernote({
		        height: 200,
		        toolbar: [
		            [ 'style', [ 'style' ] ],
		            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
		            [ 'fontname', [ 'fontname' ] ],
		            [ 'fontsize', [ 'fontsize' ] ],
		            [ 'color', [ 'color' ] ],
		            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
		            [ 'table', [ 'table' ] ],
		            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
		        ]
		    })
	})
</script>
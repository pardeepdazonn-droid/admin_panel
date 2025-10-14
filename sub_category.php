<?php 
include('header/header.php');
include('conn.php');
$sql = "SELECT category_id, category_name FROM product_category";
$result = $conn->query($sql);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Add Subcategory</h4>
                </div>
                <div class="card-body">
                    <form id="subcategoryForm" enctype="multipart/form-data">

                        <div id="msg"></div>

                        <div class="mb-3">
                            <label for="subcategory_name" class="form-label">Subcategory Name</label>
                            <input type="text" class="form-control" id="subcategory_name" name="sub_category"
                                placeholder="Enter subcategory name" required>
                        </div>


                        <div class="mb-3">
                            <label for="subcategory_slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="subcategory_slug" name="subcategory_slug"
                                placeholder="auto-generated slug">
                            <div class="form-text">URL-friendly name, lowercase with hyphens.</div>
                        </div>


                        <div class="mb-3">
                            <label for="category_id" class="form-label">Select Category</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">-- Choose Category --</option>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='{$row['category_id']}'>{$row['category_name']}</option>";
                                    }
                                } else {
                                    echo "<option value=''>No categories found</option>";
                                }
                                ?>
                            </select>

                        </div>


                        <div class="mb-3">
                            <label for="subcategory_description" class="form-label">Description</label>
                            <textarea class="form-control" id="subcategory_description" name="subcategory_description"
                                rows="3" placeholder="Optional description"></textarea>
                        </div>


                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>


                        <div class="mb-4">
                            <label for="subcategory_img" class="form-label">Upload Image</label>
                            <input class="form-control" type="file" id="subcategory_img" name="subcategory_img"
                                accept="image/*">
                        </div>


                        <button type="submit" class="btn btn-primary w-100">Add Subcategory</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script>
const msgDiv = document.getElementById('msg');

document.getElementById('subcategoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);

    fetch('sub_categoryScript.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === "success"){
            msgDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
            this.reset(); 
        } else {
            msgDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        msgDiv.innerHTML = `<div class="alert alert-warning">Something went wrong!</div>`;
    });
});

</script>

<?php
include('footer/footer.php');
?>
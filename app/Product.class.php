<?php
require('Catogory.class.php');
class Product
{
    private $id;
    private $name;
    private $price;
    private $quantity;
    private $imag;
    private $cat_id;
    private $is_active;

    public function addProduct($name, $price, $quantity, $cat_id, $image_name)
    {
        $conn = new DB();
        $name = strtolower($name);
        $sql = "insert into product(name,price,quantity,imag,cat_id) VALUES ('$name',$price,$quantity,'$image_name',$quantity)";
        if (mysqli_query($conn->getConnection(), $sql) === TRUE) {
            echo "<p id='alart' class='sess-alart'> New product added successfully <span class='close'>X</span></p>";
        } else {
            $sql = "select * from product where is_active=0 AND name= '$name'";
            $rows = $conn->getConnection()->query($sql);
            if ($row = mysqli_fetch_assoc($rows)) {
                $sql = "UPDATE product SET is_active=1,price=$price,quantity=$quantity,imag=$image_name,cat_id=$cat_id WHERE is_active=0 AND id=" . $row["id"];
                if (mysqli_query($conn->getConnection(), $sql) === TRUE) {
                    echo "<p id='alart' class='sess-alart'> New product added successfully <span class='close'>X</span></p>";
                } else {
                    echo "<p id='alart' class='err-alart'>This product is Diplicated <span class='close'>X</span></p>";
                }
            } else
                echo "<p id='alart' class='err-alart'>This product is Diplicated <span class='close'>X</span></p>";
        }
    }

    public function deleteProduct($id)
    {
        $conn = new DB();
        $sql = "UPDATE product SET is_active=0 WHERE id=" . $id;
        if (mysqli_query($conn->getConnection(), $sql) === TRUE) {
            echo "<p id='alart' class='sess-alart'> The product you are selected is deleted <span class='close'>X</span></p>";
        } else {
            echo "<p id='alart' class='err-alart'>This product is Diplicated <span class='close'>X</span></p>";
        }
    }

    public function getProduct($id)
    {
        $this->id = $id;
        $conn = new DB();
        $sql = "select * from product where is_active=1 and id=" . $this->id;
        return $conn->getConnection()->query($sql);
    }

    public function updateProduct($name, $price, $quantity, $cat_id)
    {
        $conn = new DB();
        $pro=new Product();
        $data = $pro->getProduct($this->id);
        $pro_name = strtolower($name);
        $url = "./add.product.php?true=true";
        $sql = "UPDATE product SET name=$pro_name,price=$price,quantity=$quantity,cat_id=$cat_id WHERE is_active=0 AND id=" . $this->id;
        if (mysqli_query($conn->getConnection(), $sql) === TRUE) {
            echo "<p id='alart' class='sess-alart'> New product added successfully <span class='close'>X</span></p>";
            header('Location: ' . $url);
        } else {
            $sql = "select * from category where id=$_POST[cat_id]";
            $rows = $conn->getConnection()->query($sql);
            if ($row = mysqli_fetch_assoc($rows)) {
                echo " <div class='row mt-5 mx-0 '>
                            <form action='add.product.php' method='post' class='col-8 m-auto h-50' enctype='multipart/form-data'>
                                <h1 class='t-alin mb-3'>Update New Product</h1>
                                <input type='text' placeholder='Product Name'  value='$row[name]' name='name' id='' class='my-3 form-control'>
                                <input type='number' placeholder='Product Price' value='$row[price]' name='price' id='' class='my-3 form-control'>
                                <input type='number' placeholder='Product Quantity' value='$row[quantity]' name='quantity' id='' class='my-3 form-control'>
                                <select  name='category_id' class='my-3 form-control' id=''>
                                    <option disabled  value=''>Select Category</option>";

                                $sql = "select * from category where is_active=1";
                                $categoris = $conn->getConnection()->query($sql);
                                while ($category = mysqli_fetch_assoc($categoris)) {
                                    if ($category['id'] === $row['cat_id']) {
                                        echo "<option selected value='$category[id]'>$category[name]</option>";
                                    } else {
                                        echo "<option value='$category[id]'>$category[name]</option>";
                                    }
                                }
                                echo "</select>
                                                <input type='submit' name='submit' class='btn btn-primary my-3 float-end' value='Upadte'>
                                            </form>
                                        </div>";
            } else
                echo "<p id='alart' class='err-alart'>This Category is Note Found <span class='close'>X</span></p>";
            echo "<p id='alart' class='err-alart'>This Category is Diplicated <span class='close'>X</span></p>";
        }
    }


    public function uploudImage(array $imag, $imag_dir)
    {
        $file_type = explode(".", $imag["name"]);
        $ext = end($file_type);
        $allowed_ext = array('png', 'jpg', 'jpeg');
        if (in_array($ext, $allowed_ext)) {
            $new_name = time() . rand(1000000, 10000000) . '.' . $ext;
            move_uploaded_file($imag['tmp_name'], $imag_dir . $new_name);
            return $new_name;
        } else
            return false;
    }

    public function deletImage($image_name, $imag_dir)
    {
        if (substr($imag_dir, -1) === '/') {
            return unlink($imag_dir . $image_name);
        } else
            return unlink($imag_dir . '/' . $image_name);
    }


    // public function setName($name){
    //     $this->name=$name;
    // }
    // public function getNname(){
    //     return $this->name;
    // }

    // public function setPrice($price){
    //     $this->price=$price;
    // }
    // public function getPrice(){
    //     return $this->price;
    // }

    // public function setQuantity($quantity){
    //     $this->quantity=$quantity;
    // }
    // public function getQuantity(){
    //     return $this->quantity;
    // }

    // public function setImag($imag){
    //     $this->imag=$imag;
    // }
    // public function getImag(){
    //     return $this->imag;
    // }

    // public function setCatId($cat_id){
    //     $this->cat_id=$cat_id;
    // }
    // public function getCatId(){
    //     return $this->cat_id;
    // }

    // public function setIsActive($is_active){
    //     $this->is_active=$is_active;
    // }
    // public function getIsActive(){
    //     return $this->is_active;
    // }



}

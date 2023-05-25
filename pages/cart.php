<?php
$global->check_logged_in();
$store = new Store();
$account_id = $_SESSION['account_id'];
$cart = $store->get_cart($account_id);
$check = true; 

if (isset($_POST['remove_from_cart'])) {
    $store->remove_from_cart($_POST['id']);

    header("Location: ?page=cart");
    exit();
}

if (isset($_POST['check-out'])) {
    $check = $store->check_cart($account_id);
}

?>
<div class="container">
    <div class="card mt-3 mx-auto" style="max-width: 700px;">
        <div class="card-body custom-card-body">
            <div class="row">
                <h3 class="custom-card-text text-center">Cart</h3>
                <!-- Check if account has enough donor points -->
                <?php if ($check == false) : ?>
                    <div class="col text-center text-white">
                        <p>You don't have enough points!</p>
                    </div>
                <?php endif; ?>
            </div>
            <hr>
            <div class="row">
                <table class="table mx-auto text-white" style="max-width: 500px;">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($cart as $item) :
                            $item_price = $store->get_item_price($item['product_id']);
                            $item_name = $store->get_item_name($item['product_id']);
                            $total += $item_price[1] * $item['quantity'];
                        ?>
                            <tr>
                                <td>
                                    <a href="http://wotlk.cavernoftime.com/item=<?= $item['product_id'] ?>" class="item">
                                        <?= $item_name ?>
                                    </a>
                                </td>
                                <td><?php echo $item_price[1]; ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td>
                                    <form method="POST">
                                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                        <input type="submit" name="remove_from_cart" value="Remove" class="btn btn-danger">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="row">
                <div class="col text-center text-white">
                    <p>Total: <?php echo $total; ?> Donor Points</p>
                    <form method="POST">
                        <input type="submit" name="check-out" value="Check Out" class="btn btn-success">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

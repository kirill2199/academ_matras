<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<section class="product-cart product footer-padding">
    <div class="container">
        <div class="cart-section">
            <?php if (empty($cartItems)): ?>
                <div class="empty-cart">
                    <h3>Ваша корзина пуста</h3>
                    <p>Продолжите покупки и положите товар в корзину</p>
                    <a href="<?= Url::to(['/shop/default/index']) ?>" class="shop-btn">Продолжить покупки</a>
                </div>
            <?php else: ?>
                <table>
                    <tbody>
                        <tr class="table-row table-top-row">
                            <td class="table-wrapper wrapper-product">
                                <h5 class="table-heading">PRODUCT</h5>
                            </td>
                            <td class="table-wrapper">
                                <div class="table-wrapper-center">
                                    <h5 class="table-heading">PRICE</h5>
                                </div>
                            </td>
                            <td class="table-wrapper">
                                <div class="table-wrapper-center">
                                    <h5 class="table-heading">QUANTITY</h5>
                                </div>
                            </td>
                            <td class="table-wrapper wrapper-total">
                                <div class="table-wrapper-center">
                                    <h5 class="table-heading">TOTAL</h5>
                                </div>
                            </td>
                            <td class="table-wrapper">
                                <div class="table-wrapper-center">
                                    <h5 class="table-heading">ACTION</h5>
                                </div>
                            </td>
                        </tr>

                        <?php foreach ($cartItems as $item): ?>
                            <tr class="table-row ticket-row" id="cart-item-<?= $item->id ?>">
                                <td class="table-wrapper wrapper-product">
                                    <div class="wrapper">
                                        <div class="wrapper-img">
                                            <?= Html::img(explode(',', $item->product->images)[0], ['alt' => $item->product->name]) ?>
                                        </div>
                                        <div class="wrapper-content">
                                            <h5 class="heading"><?= Html::encode($item->product->name) ?></h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-wrapper">
                                    <div class="table-wrapper-center">
                                        <h5 class="heading">$<?= number_format($item->price, 2) ?></h5>
                                    </div>
                                </td>
                                <td class="table-wrapper">
                                    <div class="table-wrapper-center">
                                        <div class="quantity">
                                            <span class="minus" data-cart-id="<?= $item->id ?>">
                                                -
                                            </span>
                                            <span class="number"><?= $item->quantity ?></span>
                                            <span class="plus" data-cart-id="<?= $item->id ?>">
                                                +
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-wrapper wrapper-total">
                                    <div class="table-wrapper-center">
                                        <h5 class="heading item-total">$<?= number_format($item->getItemTotal(), 2) ?></h5>
                                    </div>
                                </td>
                                <td class="table-wrapper">
                                    <div class="table-wrapper-center">
                                        <span class="remove-from-cart" data-cart-id="<?= $item->id ?>">
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9.7 0.3C9.3 -0.1 8.7 -0.1 8.3 0.3L5 3.6L1.7 0.3C1.3 -0.1 0.7 -0.1 0.3 0.3C-0.1 0.7 -0.1 1.3 0.3 1.7L3.6 5L0.3 8.3C-0.1 8.7 -0.1 9.3 0.3 9.7C0.7 10.1 1.3 10.1 1.7 9.7L5 6.4L8.3 9.7C8.7 10.1 9.3 10.1 9.7 9.7C10.1 9.3 10.1 8.7 9.7 8.3L6.4 5L9.7 1.7C10.1 1.3 10.1 0.7 9.7 0.3Z"
                                                    fill="#AAAAAA"></path>
                                            </svg>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="cart-total">
                    <div class="total-amount">
                        <h4>Total: <span id="cart-total-amount">$<?= number_format($totalAmount, 2) ?></span></h4>
                    </div>
                </div>

                <div class="wishlist-btn cart-btn">
                    <button class="clean-btn" id="clear-cart">Clear Cart</button>
                    <a href="<?= Url::to(['/shop/default/index']) ?>" class="shop-btn">Продолжить покупки</a>
                    <a href="<?= Url::to(['/shop-order/default/checkout']) ?>" class="shop-btn">Оформить заказ</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
// JavaScript для обработки действий корзины
$this->registerJs(<<<JS
    // Добавление обработчиков событий
    $(document).ready(function() {
        // Увеличение количества
        $('.plus').on('click', function() {
            var cartId = $(this).data('cart-id');
            var currentQty = parseInt($(this).siblings('.number').text());
            updateCartItem(cartId, currentQty + 1);
        });
        
        // Уменьшение количества
        $('.minus').on('click', function() {
            var cartId = $(this).data('cart-id');
            var currentQty = parseInt($(this).siblings('.number').text());
            if (currentQty > 1) {
                updateCartItem(cartId, currentQty - 1);
            }
        });
        
        // Удаление товара
        $('.remove-from-cart').on('click', function() {
            var cartId = $(this).data('cart-id');
            deleteCartItem(cartId);
        });
        
        // Очистка корзины
        $('#clear-cart').on('click', function(e) {
            e.preventDefault();
            clearCart();
        });
    });
    
    function updateCartItem(cartId, quantity) {
        $.post('/shop-cart/default/update', {
            cart_id: cartId,
            quantity: quantity
        }, function(response) {
            if (response.success) {
                // Обновляем интерфейс
                location.reload(); // или динамическое обновление
            } else {
                alert(response.message);
            }
        });
    }
    
    function deleteCartItem(cartId) {
        $.post('/shop-cart/default/delete', {
            cart_id: cartId
        }, function(response) {
            if (response.success) {
                $('#cart-item-' + cartId).remove();
                $('#cart-total-amount').text(response.cartTotal);
                // Обновляем счетчик в хедере
                updateCartCounter(response.cartCount);
            } else {
                alert(response.message);
            }
        });
    }
    
    function clearCart() {
        if (confirm('Are you sure you want to clear your cart?')) {
            $.post('/shop-cart/default/clear', function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.message);
                }
            });
        }
    }
    
    function updateCartCounter(count) {
        $('.cart-counter').text(count);
    }
JS
);
?>